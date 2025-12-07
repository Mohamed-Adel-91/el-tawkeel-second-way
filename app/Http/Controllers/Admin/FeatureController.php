<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureRequest;
use App\Exports\FeaturesExport;
use App\Models\Feature;
use App\Models\FeatureCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        $data = Feature::with('category')
            ->when($request->filled('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
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

        return view('admin.car_module.features.index')->with([
            'pageName' => 'قائمة المزايا',
            'data' => $data,
            'filters' => $request->only(['name', 'from_date', 'to_date']),
        ]);
    }

    public function create()
    {
        return view('admin.car_module.features.form')->with([
            'pageName' => 'إنشاء ميزة',
            'categories' => FeatureCategory::all(),
        ]);
    }

    public function store(FeatureRequest $request)
    {
        Feature::create($request->validated());
        return redirect()->route('admin.features.index')->with('success','تم إنشاء الميزة بنجاح.');
    }

    public function edit($id)
    {
        $data = Feature::findOrFail($id);
        return view('admin.car_module.features.form')->with([
            'pageName' => 'تعديل ميزة',
            'data' => $data,
            'categories' => FeatureCategory::all(),
        ]);
    }

    public function update(FeatureRequest $request, $id)
    {
        $item = Feature::findOrFail($id);
        $item->update($request->validated());
        return redirect()->route('admin.features.index', $request->query())->with('success','تم تحديث الميزة بنجاح.');
    }

    public function destroy($id)
    {
        $item = Feature::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.features.index')->with('success','تم حذف الميزة بنجاح.');
    }

    public function export(Request $request)
    {
        $filters = $request->only(['name', 'from_date', 'to_date']);
        return Excel::download(new FeaturesExport($filters), 'features.xlsx');
    }
}
