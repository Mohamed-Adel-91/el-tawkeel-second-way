<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstallmentOrder;
use App\Models\User;
use App\Models\CarTerm;
use App\Models\Insurance;
use App\Traits\DeleteFileTrait;

class InstallmentOrderController extends Controller
{
    use DeleteFileTrait;

    public function index()
    {
        $data = InstallmentOrder::with(['user','brand','carModel','term','branch','program'])->orderBy('id','desc')->paginate(25);
        return view('admin.finance_and_payment.installment_orders.index')->with([
            'pageName' => 'قائمة طلبات التقسيط',
            'data' => $data,
            'filters' => [],
        ]);
    }

    public function show($id)
    {
        $data = InstallmentOrder::with('user')->findOrFail($id);
        return view('admin.finance_and_payment.installment_orders.show')->with([
            'pageName' => 'عرض طلب تقسيط',
            'data' => $data,
            'users' => User::all(),
            'carTerms' => CarTerm::all(),
            'insurances' => Insurance::all(),
        ]);
    }


}
