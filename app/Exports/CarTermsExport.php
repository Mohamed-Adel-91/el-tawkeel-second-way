<?php

namespace App\Exports;

use App\Models\CarTerm;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class CarTermsExport implements WithMultipleSheets
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function sheets(): array
    {
        $terms = $this->query()->get();

        $sheets = [
            new CarTermsSummarySheet($terms),
        ];

        foreach ($terms as $term) {
            $sheets[] = new CarTermFeaturesSheet($term);
        }

        return $sheets;
    }

    protected function query()
    {
        return CarTerm::with([
            'model.brand',
            'model.shape',
            'features.category',
            'specs',
        ])
            ->when(!empty($this->filters['term_id']), function ($query) {
                $query->where('id', $this->filters['term_id']);
            })
            ->when(!empty($this->filters['brand_id']), function ($query) {
                $query->whereHas('model', function ($q) {
                    $q->where('brand_id', $this->filters['brand_id']);
                });
            })
            ->when(!empty($this->filters['car_model_id']), function ($query) {
                $query->where('car_model_id', $this->filters['car_model_id']);
            })
            ->when(!empty($this->filters['from_date']), function ($query) {
                $query->whereDate('created_at', '>=', $this->filters['from_date']);
            })
            ->when(!empty($this->filters['to_date']), function ($query) {
                $query->whereDate('created_at', '<=', $this->filters['to_date']);
            })
            ->orderByDesc('id');
    }
}

class CarTermsSummarySheet implements FromCollection, WithHeadings, WithTitle
{
    protected Collection $terms;

    public function __construct(Collection $terms)
    {
        $this->terms = $terms;
    }

    public function collection()
    {
        return $this->terms->map(function ($carTerm) {
            $specs = $carTerm->specs->pluck('value')->filter()->implode(' | ');

            return [
                $carTerm->id,
                $carTerm->term_name,
                optional($carTerm->model)->name,
                optional(optional($carTerm->model)->brand)->name,
                optional(optional($carTerm->model)->shape)->name,
                $carTerm->price,
                $carTerm->inventory,
                $carTerm->reservation_amount,
                $carTerm->status ? 'active' : 'inactive',
                $carTerm->color_over_price ? json_encode($carTerm->color_over_price, JSON_UNESCAPED_UNICODE) : '',
                $specs,
                optional($carTerm->created_at)->format('Y-m-d H:i:s'),
                optional($carTerm->updated_at)->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Term Name',
            'Model',
            'Brand',
            'Shape',
            'Price',
            'Inventory',
            'Reservation Amount',
            'Status',
            'Color Over Price',
            'Specs',
            'Created At',
            'Updated At',
        ];
    }

    public function title(): string
    {
        return 'Car Terms';
    }
}

class CarTermFeaturesSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function collection()
    {
        return $this->term->features->map(function ($feature) {
            return [
                $feature->id,
                optional($feature->category)->name,
                $feature->name,
                $feature->pivot->value,
                $feature->pivot->status ? 'true' : 'false',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Feature ID',
            'Feature Category',
            'Feature Name',
            'Value',
            'Status',
        ];
    }

    public function title(): string
    {
        $model = optional($this->term->model)->name;
        $brand = optional(optional($this->term->model)->brand)->name;
        $term = $this->term->term_name;

        $title = implode(' - ', array_filter([$model, $brand, $term]));

        // Excel sheet title must be <= 31 chars
        return mb_substr($title ?: 'Car Term', 0, 31);
    }
}
