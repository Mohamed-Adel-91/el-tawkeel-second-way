<?php

namespace App\Exports;

use App\Models\Feature;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FeaturesExport implements FromQuery, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return Feature::with('category')
            ->when(!empty($this->filters['name']), function ($query) {
                $query->where('name', 'like', '%' . $this->filters['name'] . '%');
            })
            ->when(!empty($this->filters['from_date']), function ($query) {
                $query->whereDate('created_at', '>=', $this->filters['from_date']);
            })
            ->when(!empty($this->filters['to_date']), function ($query) {
                $query->whereDate('created_at', '<=', $this->filters['to_date']);
            })
            ->orderByDesc('id');
    }

    public function headings(): array
    {
        return [
            '#',
            'Category',
            'Name',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

    public function map($feature): array
    {
        return [
            $feature->id,
            optional($feature->category)->name ?? '-',
            $feature->name,
            $feature->status ? 'Active' : 'Inactive',
            optional($feature->created_at)->format('Y-m-d H:i:s'),
            optional($feature->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
