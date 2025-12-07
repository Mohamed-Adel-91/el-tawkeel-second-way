<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Guest;
use App\Services\BookingService;
use App\Services\BookingColorService;
use App\Services\ConfirmBookingService;
use App\Http\Requests\BookingOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Enums\OrderStatusEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use niklasravnsborg\LaravelPdf\Facades\Pdf as MPdf;
use Illuminate\Support\Facades\Log;
use App\Support\GuestToken;

class OrderController extends Controller
{
    use FileUploadTrait;

    public function booking(Request $request, BookingService $service)
    {
        [$sessionId, $guestToken] = GuestToken::resolve();

        $carModelId = (int) $request->query('id');
        $termId = (int) $request->query('term_id');
        $colorId = $request->input('color_id') ? (int)$request->input('color_id') : null;
        $cloneId = $request->query('booking_clone_id') ? (int)$request->query('booking_clone_id') : null;

        if (!auth('user')->check()) {
            Guest::firstOrCreate(
                [
                    'session_id'  => $sessionId,
                    'guest_token' => $guestToken,
                    'car_id'      => $carModelId,
                    'term_id'     => $termId,
                ],
                [
                    'ip_address' => $request->ip(),
                    'user_id'    => null,
                ]
            );
        }

        $data = $service->build(
            $carModelId,
            $termId,
            $colorId,
            $cloneId
        );

        $pendingOrder = $data['bookingCarClone']->order()
            ->where('status', OrderStatusEnum::PENDING)
            ->first();

        if ($pendingOrder) {
            $data['order'] = $pendingOrder;
        }

        return view('web.pages.order.booking', $data);
    }

    public function updateColor(Request $request, BookingColorService $service)
    {
        $validated = $request->validate([
            'booking_clone_id' => ['required', 'integer', 'exists:booking_car_clones,id'],
            'color_id'         => ['required', 'integer', 'exists:colors,id'],
            'is_second'        => ['nullable', 'boolean'],
        ]);

        $res = $service->update(
            (int)$validated['booking_clone_id'],
            (int)$validated['color_id'],
            (bool)($validated['is_second'] ?? false)
        );

        return response()->json($res);
    }

    public function status(Order $order)
    {
        $steps = [
            ['title' => 'تم حجز السيارة', 'description' => 'تم تأكيد طلبك وجاري المتابعة.', 'completed' => true],
            ['title' => 'يتم شحن السيارة', 'description' => 'السيارة قيد الشحن حالياً.', 'completed' => false],
            ['title' => 'تم استلام السيارة من خلال الوكيل', 'description' => 'تم استلام السيارة من الوكيل.', 'completed' => false],
            ['title' => 'تخضع حالياً لإجراءات قانونية', 'description' => 'السيارة في مرحلة الإجراءات القانونية.', 'completed' => false],
        ];

        $completedSteps = match ($order->status) {
            OrderStatusEnum::PAID => 2,
            default => 1,
        };

        foreach ($steps as $index => &$step) {
            $step['completed'] = $index < $completedSteps;
        }

        return response()->json([
            'order_id' => $order->id,
            'steps' => $steps,
        ]);
    }

    public function confirmBooking(Order $order, ConfirmBookingService $service)
    {
        $viewData = $service->build($order, true);
        return view('web.pages.order.confirmbooking', $viewData);
    }

    public function store(BookingOrderRequest $request, OrderService $service)
    {
        $data = $request->validated();
        $orderId = $request->input('order_id');

        $mapFiles = function (array $keys) use ($request) {
            $out = [];
            foreach ($keys as $k) {
                $out[$k] = $request->file($k);
            }
            return $out;
        };

        $fileKeys = [
            'cash_front_national_id_image',
            'cash_back_national_id_image',
            'installment_front_national_id_image',
            'installment_back_national_id_image',
            'installment_bank_statement',
            'installment_hr_letter',
            'installment_commercial_registration_image',
            'installment_tax_card_image',
            'installment_company_bank_statement',
        ];
        $data += $mapFiles($fileKeys);

        // guest tracking
        $data['session_id'] = session()->getId();
        $data['guest_token'] = $request->cookie('guest_token');

        $uploader = function ($files, $folders, $attrs, $model) {
            return $this->uploadFile($files, $folders, $attrs, $model);
        };

        if ($orderId) {
            $existingOrder = Order::where('status', OrderStatusEnum::PENDING)
                ->findOrFail((int)$orderId);
            $order = $service->updateFromRequest($existingOrder, $data, $uploader);
        } else {
            $order = $service->createFromRequest($data, $uploader);
        }

        if ($request->boolean('no_payment')) {
            return redirect()->route('web.thanks.not-paid', ['order' => $order->id]);
        }

        return redirect()->route('web.confirm-booking', ['order' => $order->id]);
    }

    public function invoice(Order $order, ConfirmBookingService $service)
    {
        $data = $service->build($order);
        $data['invoiceNumber'] = $order->reference_number;
        $data['issueDate'] = now()->timezone(config('app.timezone'))->format('d/m/Y');

        $temp = storage_path('app/pdf-temp');
        if (! is_dir($temp)) {
            @mkdir($temp, 0775, true);
        }

        try {
            $pdf = MPdf::loadView('web.pdf.invoice', $data, [], [
                'mode'          => 'utf-8',
                'format'        => 'A4',
                'default_font'  => 'dubai',
                'direction'     => 'rtl',
                'tempDir'       => $temp,
                'margin_left'   => 10,
                'margin_right'  => 10,
                'margin_top'    => 10,
                'margin_bottom' => 10,
            ]);

            if (ob_get_length()) {
                ob_end_clean();
            }

            return $pdf->stream('invoice-' . $order->id . '.pdf');
        } catch (\Throwable $e) {
            Log::error('mPDF failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response('PDF generation failed: ' . $e->getMessage(), 500);
        }
    }

    public function thanks(Order $order, ConfirmBookingService $service)
    {
        if (
            $order->provider_order_reference &&
            $order->provider_transaction_reference &&
            !$order->inventory_decremented &&
            $order->status->is(OrderStatusEnum::PAID())
        ) {
            $decremented = $order->term()->where('inventory', '>', 0)->decrement('inventory');

            if ($decremented) {
                $order->inventory_decremented = true;
                $order->save();
            } else {
                return redirect()->back()->with('error', 'المخزون غير متاح');
            }
        }
        $viewData = $service->build($order);
        return view('web.pages.order.thanks-page', $viewData);
    }

    public function notPaidThanks(Order $order, ConfirmBookingService $service)
    {
        $viewData = $service->build($order);
        return view('web.pages.order.not-paid-thanks-page', $viewData);
    }
}
