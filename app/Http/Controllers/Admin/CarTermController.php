<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarTermRequest;
use App\Exports\CarTermsExport;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\CarTerm;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CarTermController extends Controller
{
    public function index(Request $request)
    {
        $data = CarTerm::with(['model.brand'])
            ->when($request->filled('term_id'), function ($query) use ($request) {
                $query->where('id', $request->term_id);
            })
            ->when($request->filled('brand_id'), function ($query) use ($request) {
                $query->whereHas('model', function ($q) use ($request) {
                    $q->where('brand_id', $request->brand_id);
                });
            })
            ->when($request->filled('car_model_id'), function ($query) use ($request) {
                $query->where('car_model_id', $request->car_model_id);
            })
            ->when($request->filled('from_date'), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->filled('to_date'), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->to_date);
            })
            ->orderBy('id', 'desc')
            ->paginate(25)
            ->appends($request->query());

        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        $models = CarModel::select('id', 'name', 'brand_id')
            ->when($request->filled('brand_id'), function ($query) use ($request) {
                $query->where('brand_id', $request->brand_id);
            })
            ->orderBy('name')
            ->get();
        $termOptions = CarTerm::with(['model.brand'])
            ->when($request->filled('brand_id'), function ($query) use ($request) {
                $query->whereHas('model', function ($q) use ($request) {
                    $q->where('brand_id', $request->brand_id);
                });
            })
            ->when($request->filled('car_model_id'), function ($query) use ($request) {
                $query->where('car_model_id', $request->car_model_id);
            })
            ->orderBy('term_name')
            ->get();

        return view('admin.car_module.car_terms.index')->with([
            'pageName' => 'قائمة فئات السيارات',
            'data' => $data,
            'filters' => $request->only(['term_id', 'brand_id', 'car_model_id', 'from_date', 'to_date']),
            'brands' => $brands,
            'models' => $models,
            'termOptions' => $termOptions,
        ]);
    }

    public function create()
    {
        $models = CarModel::with('colors:id,name')->get();
        return view('admin.car_module.car_terms.form')->with([
            'pageName' => 'إنشاء فئة سيارة',
            'models' => $models,
            'modelColors' => $this->modelColorsMap($models),
            'features' => Feature::all(),
        ]);
    }

    public function store(CarTermRequest $request)
    {
        $validated = $request->validated();
        $validated['status'] = $request->boolean('status', true);
        $validated['color_over_price'] = $this->cleanColorOverPrice($request->input('color_over_price', []));
        $carTerm = CarTerm::create($validated);

        foreach ($request->input('specs', []) as $key => $value) {
            if ($value !== null && $value !== '') {
                $carTerm->specs()->create(['value' => $value, 'status' => true]);
            }
        }
        $featuresData = [];
        foreach ($request->input('features', []) as $featureId) {
            $featuresData[$featureId] = [
                'value' => $request->input('feature_values.' . $featureId),
                'status' => $request->boolean('feature_statuses.' . $featureId),
            ];
        }
        if ($featuresData) {
            $carTerm->features()->attach($featuresData);
        }
        return redirect()->route('admin.car_terms.index')->with('success', 'تم إنشاء فئة السيارة بنجاح.');
    }

    public function edit($id)
    {
        $data = CarTerm::findOrFail($id);
        $models = CarModel::with('colors:id,name')->get();
        return view('admin.car_module.car_terms.form')->with([
            'pageName' => 'تعديل فئة سيارة',
            'data' => $data,
            'models' => $models,
            'modelColors' => $this->modelColorsMap($models),
            'features' => Feature::all(),
        ]);
    }

    public function update(CarTermRequest $request, $id)
    {
        $item = CarTerm::findOrFail($id);
        $validated = $request->validated();
        $validated['status'] = $request->boolean('status', true);
        $validated['color_over_price'] = $this->cleanColorOverPrice($request->input('color_over_price', []));
        $item->update($validated);

        $specs = $request->input('specs', []);
        foreach ($specs as $specId => $value) {
            if (str_starts_with((string)$specId, 'new_')) {
                if ($value !== null && $value !== '') {
                    $item->specs()->create(['value' => $value, 'status' => true]);
                }
            } else {
                $spec = $item->specs()->where('id', $specId)->first();
                if ($spec) {
                    $spec->update(['value' => $value]);
                }
            }
        }

        $deleteSpecs = $request->input('delete_specs', []);
        if ($deleteSpecs) {
            $item->specs()->whereIn('id', $deleteSpecs)->delete();
        }

        $requestedFeatures = $request->input('features', []);
        $featuresData = [];
        foreach ($requestedFeatures as $featureId) {
            $featuresData[$featureId] = [
                'value' => $request->input('feature_values.' . $featureId),
                'status' => $request->boolean('feature_statuses.' . $featureId),
            ];
        }
        $item->features()->sync($featuresData);
        return redirect()->route('admin.car_terms.index', $request->query())->with('success', 'تم تحديث فئة السيارة بنجاح.');
    }

    public function destroy($id)
    {
        $item = CarTerm::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.car_terms.index')->with('success', 'تم حذف فئة السيارة بنجاح.');
    }

    public function duplicate($id)
    {
        $carTerm = CarTerm::with(['specs', 'features'])->findOrFail($id);

        DB::transaction(function () use ($carTerm) {
            $newTerm = $carTerm->replicate();
            $newTerm->push();

            foreach ($carTerm->specs as $spec) {
                $newTerm->specs()->create([
                    'value' => $spec->value,
                    'status' => $spec->status,
                ]);
            }

            $featurePivot = [];
            foreach ($carTerm->features as $feature) {
                $featurePivot[$feature->id] = [
                    'value' => $feature->pivot->value,
                    'status' => $feature->pivot->status,
                ];
            }

            if ($featurePivot) {
                $newTerm->features()->attach($featurePivot);
            }
        });

        return redirect()->route('admin.car_terms.index')->with('success', 'تم اعادة تكرار تلك الفئة من السيارة.');
    }

    public function toggleStatus(CarTerm $car_term)
    {
        $car_term->status = !$car_term->status;
        $car_term->save();

        return response()->json(['status' => $car_term->status]);
    }

    public function export(Request $request)
    {
        $filters = $request->only(['term_id', 'brand_id', 'car_model_id', 'from_date', 'to_date']);
        return Excel::download(new CarTermsExport($filters), 'car_terms.xlsx');
    }

    private function modelColorsMap($models)
    {
        return $models->mapWithKeys(function ($model) {
            return [$model->id => $model->colors->map(function ($color) {
                return [
                    'id' => $color->id,
                    'name' => $color->name,
                ];
            })->values()];
        });
    }

    private function cleanColorOverPrice(array $input): ?array
    {
        $clean = [];
        foreach ($input as $colorId => $value) {
            if ($value === null || $value === '' || !is_numeric($value)) {
                continue;
            }
            $clean[(int)$colorId] = (float)$value;
        }
        return !empty($clean) ? $clean : null;
    }
}
