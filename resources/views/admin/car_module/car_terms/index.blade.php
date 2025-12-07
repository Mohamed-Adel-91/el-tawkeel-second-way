@extends('admin.layouts.master')
@section('content')
    <div class="page-wrapper">
        @include('admin.layouts.sidebar')
        <div class="page-content">
            @include('admin.layouts.page-header')
            <div class="main-container">
                @include('admin.layouts.alerts')
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="table-container">
                            @php
                                $extraFilters = view('admin.car_module.car_terms.partials.filters', [
                                    'filters' => $filters,
                                    'brands' => $brands,
                                    'models' => $models,
                                    'termOptions' => $termOptions,
                                ])->render();
                            @endphp
                            @include('admin.partials.filter-form', [
                                'action' => route('admin.car_terms.index'),
                                'resetUrl' => route('admin.car_terms.index'),
                                'exportUrl' => route('admin.car_terms.export', request()->query()),
                                'filters' => $filters,
                                'extraFilters' => $extraFilters,
                            ])
                            <div class="col-mb-12 p-0" style="margin: 15px;">
                                <div class="row d-flex justify-content-end p-0">
                                    <div class="col-md-2 d-flex justify-content-end p-0">
                                        <div class="col-md-6 d-flex justify-content-end  p-0">
                                            <button type="text" class="btn btn-primary" style="margin-top: 20px;">
                                                <a href="{{ route('admin.car_terms.create') }}" style="color: #fff;">
                                                    <i class="icon-plus-circle mr-1"></i>جديد</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('admin.partials.results-summary', [
                                'data' => $data,
                                'label' => 'فئات السيارات',
                            ])
                            <div class="table-responsive">
                                <table class="table custom-table m-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم الفئه</th>
                                            <th>الموديل</th>
                                            <th>السعر</th>
                                            <th>المخزون</th>
                                            <th>قيمة الحجز</th>
                                            <th>حالة العرض</th>
                                            <th>تاريخ الإنشاء</th>
                                            <th>تاريخ التحديث</th>
                                            <th>الخيارات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($data) && count($data) > 0)
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->term_name }}</td>
                                                    <td class="dubai">{{ $item->model->name ?? '-' }}</td>
                                                    <td>{{ $item->price }}</td>
                                                    <td>{{ $item->inventory }}</td>
                                                    <td>{{ $item->reservation_amount }}</td>
                                                    <td>
                                                        <div class="form-check form-switch d-flex align-items-center gap-2">
                                                            {{-- <input class="form-check-input status-toggle" type="checkbox" role="switch"
                                                                id="status_{{ $item->id }}" data-id="{{ $item->id }}"
                                                                {{ $item->status ? 'checked' : '' }}> --}}
                                                            <span class="badge {{ $item->status ? 'badge-success' : 'badge-danger' }}">
                                                                {{ $item->status ? 'معروض' : 'مخفي' }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->created_at ?? '-' }}</td>
                                                    <td>{{ $item->updated_at ?? '-' }}</td>
                                                    <td>
                                                        <div class="td-actions">
                                                            <form method="POST" class="d-inline" action="{{ route('admin.car_terms.duplicate', ['car_term' => $item->id]) }}">
                                                                @csrf
                                                                <button type="submit" class="icon bg-warning" data-toggle="tooltip"
                                                                    data-placement="top" title="Duplicate Row">
                                                                    <i class="icon-copy"></i>
                                                                </button>
                                                            </form>
                                                            <a href="{{ route('admin.car_terms.edit', $item->id) }}"
                                                                class="icon bg-info" data-toggle="tooltip"
                                                                data-placement="top" title="Edit Row">
                                                                <i class="icon-edit"></i>
                                                            </a>
                                                            <form method="POST" id="delete_form_{{ $item->id }}" class="d-inline delete_form" action="{{ route('admin.car_terms.destroy', ['car_term' => $item->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="icon red" data-toggle="tooltip" data-placement="top" title="Delete Row" onclick="checker(event, {{ $item->id }})">
                                                                    <i class="icon-cancel"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    <div class="alert alert-danger">
                                                        لا توجد سجلات لشروط السيارات مطابقة للمعايير.
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @include('admin.partials.pagination')
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection

@push('custom-js-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.status-toggle').forEach(function(el) {
                el.addEventListener('change', function() {
                    const id = this.dataset.id;
                    axios.post('/dashboard/car_terms/' + id + '/toggle-status')
                        .then(function(response) {
                            const badge = el.closest('.form-switch').querySelector('.badge');
                            const isShown = response.data.show_status;
                            el.checked = isShown;
                            if (badge) {
                                badge.classList.toggle('badge-success', isShown);
                                badge.classList.toggle('badge-danger', !isShown);
                                badge.textContent = isShown ? 'معروض' : 'مخفي';
                            }
                            Swal.fire({
                                title: 'Success',
                                text: 'تم تحديث حالة العرض',
                                icon: 'success',
                                confirmButtonColor: '#d03b37'
                            });
                        })
                        .catch(() => {
                            el.checked = !el.checked;
                            Swal.fire({
                                title: 'Error',
                                text: 'تعذر تحديث حالة العرض',
                                icon: 'error',
                                confirmButtonColor: '#d03b37'
                            });
                        });
                });
            });
        });
    </script>
@endpush
