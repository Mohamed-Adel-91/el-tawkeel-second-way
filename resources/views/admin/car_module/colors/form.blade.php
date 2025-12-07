@extends('admin.layouts.master')
@section('content')
    <div class="page-wrapper">
        @include('admin.layouts.sidebar')
        <div class="page-content">
            @include('admin.layouts.page-header')
            <div class="main-container">
                @include('admin.layouts.alerts')
                <form method="POST"
                    action="{{ isset($data) ? route('admin.colors.update', $data->id) : route('admin.colors.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($data))
                        @method('PUT')
                    @endif
                    <div class="row gutters">
                        <div class="col-12">
                            <div class="card h-100">
                                <div class="card-header">
                                    <div class="card-title">
                                        {{ isset($data) ? __('admin.forms.edit') : __('admin.forms.create') }}
                                        {{ __('admin.forms.color_entity') }}
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row gutters">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">{{ __('admin.forms.name') }}</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ isset($data) ? $data->name : '' }}">
                                                @if ($errors->has('name'))
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="front_name">{{ __('admin.forms.front_name') }}</label>
                                                <input type="text" class="form-control" id="front_name" name="front_name"
                                                    value="{{ isset($data) ? $data->front_name : '' }}">
                                                @if ($errors->has('front_name'))
                                                    <span class="text-danger">{{ $errors->first('front_name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type">{{ __('admin.forms.type') }}</label>
                                                <select class="form-control" id="type" name="type">
                                                    <option value="">{{ __('admin.forms.choose_type') }}</option>
                                                    <option value="{{ \App\Enums\ColorTypeEnum::LIGHT }}"
                                                        {{ isset($data) && $data->type->value == \App\Enums\ColorTypeEnum::LIGHT ? 'selected' : '' }}>
                                                        {{ __('admin.forms.light') }}
                                                    </option>
                                                    <option value="{{ \App\Enums\ColorTypeEnum::DARK }}"
                                                        {{ isset($data) && $data->type->value == \App\Enums\ColorTypeEnum::DARK ? 'selected' : '' }}>
                                                        {{ __('admin.forms.dark') }}
                                                    </option>
                                                </select>
                                                @if ($errors->has('type'))
                                                    <span class="text-danger">{{ $errors->first('type') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        @include('admin.layouts.components.media-upload', [
                                            'label' => __('admin.forms.image'),
                                            'name' => 'image',
                                            'oldFile' => $data->image ?? null,
                                            'previewPath' =>
                                                isset($data) && $data->image ? $data->image_path : null,
                                        ])
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit"
                                        class="btn btn-primary">{{ __('admin.forms.save_button') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
