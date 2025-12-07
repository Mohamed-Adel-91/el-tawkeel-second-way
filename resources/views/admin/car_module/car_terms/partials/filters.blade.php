<div class="col-md-3">
    <div class="form-group">
        <label for="brand_id">{{ __('admin.sidebar.brands') }}</label>
        <select class="form-control" id="brand_id" name="brand_id">
            <option value="">{{ __('admin.forms.choose_brand') }}</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" {{ (string) request()->input('brand_id', $filters['brand_id'] ?? '') === (string) $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="car_model_id">{{ __('admin.forms.model') }}</label>
        <select class="form-control" id="car_model_id" name="car_model_id">
            <option value="">{{ __('admin.forms.choose_model') }}</option>
            @foreach ($models as $model)
                <option value="{{ $model->id }}" {{ (string) request()->input('car_model_id', $filters['car_model_id'] ?? '') === (string) $model->id ? 'selected' : '' }}>
                    {{ $model->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="term_id">{{ __('admin.forms.term_name') }}</label>
        <select class="form-control" id="term_id" name="term_id">
            <option value="">{{ __('admin.forms.term_name') ?? __('admin.forms.search') }}</option>
            @foreach ($termOptions as $term)
                @php
                    $brandName = optional(optional($term->model)->brand)->name;
                    $modelName = optional($term->model)->name;
                    $label = implode(' - ', array_filter([$brandName, $modelName, $term->term_name]));
                @endphp
                <option value="{{ $term->id }}" {{ (string) request()->input('term_id', $filters['term_id'] ?? '') === (string) $term->id ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
</div>
