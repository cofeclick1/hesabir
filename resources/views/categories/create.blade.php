@extends('layouts.app')

@section('title', 'افزودن دسته‌بندی جدید')

@section('content')
<div class="container py-8">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">
            <div class="card shadow">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="mb-0 h5">افزودن دسته‌بندی جدید</h2>
                    <a href="{{ route('categories.list') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-list ms-1"></i> لیست دسته‌بندی‌ها
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>خطا:</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="categoryForm" action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">عنوان دسته‌بندی <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="{{ old('title') }}" class="form-control" maxlength="100" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">کد دسته‌بندی <span class="text-danger">*</span></label>
                                <input type="text" name="code" value="{{ old('code') }}" class="form-control" maxlength="32" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">نوع دسته‌بندی</label>
                                <select name="type" class="form-select" id="categoryType">
                                    <option value="person" @selected(old('type')=='person')>اشخاص</option>
                                    <option value="product" @selected(old('type')=='product')>کالا</option>
                                    <option value="service" @selected(old('type')=='service')>خدمات</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">دسته والد</label>
                                <select name="parent_id" class="form-select">
                                    <option value="">بدون والد</option>
                                    @foreach($personCategories as $cat)
                                        <option value="{{ $cat->id }}" @selected(old('parent_id')==$cat->id)>{{ $cat->title }}</option>
                                    @endforeach
                                    @foreach($productCategories as $cat)
                                        <option value="{{ $cat->id }}" @selected(old('parent_id')==$cat->id)>{{ $cat->title }}</option>
                                    @endforeach
                                    @foreach($serviceCategories as $cat)
                                        <option value="{{ $cat->id }}" @selected(old('parent_id')==$cat->id)>{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">تصویر دسته‌بندی</label>
                                <div class="category-img-dropzone" id="category-dropzone">
                                    <span class="category-img-edit-overlay">انتخاب تصویر</span>
                                    <img src="{{ asset('images/no-img.png') }}" id="category-img-preview" alt="پیش‌نمایش" class="img-fluid" style="display:block;">
                                    <input type="file" name="image" id="category-img-input" accept="image/*" style="display:none;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">توضیحات</label>
                                <textarea name="description" rows="2" class="form-control">{{ old('description') }}</textarea>
                            </div>
                            <div class="col-md-6" id="personTypeGroup" style="display:none;">
                                <label class="form-label">نوع شخص</label>
                                <div class="input-group">
                                    <select name="person_type" class="form-select" id="personTypeSelect">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($personTypes as $pt)
                                            <option value="{{ $pt->title }}" @selected(old('person_type')==$pt->title)>{{ $pt->title }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-primary" type="button" id="btnManagePersonTypes"><i class="fa fa-cog"></i></button>
                                </div>
                            </div>
                            <div class="col-md-6" id="unitGroup" style="display:none;">
                                <label class="form-label">واحد اصلی</label>
                                <div class="input-group">
                                    <select name="unit" class="form-select" id="unitSelect">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit }}" @selected(old('unit')==$unit)>{{ $unit }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-primary" type="button" id="btnManageUnits"><i class="fa fa-cog"></i></button>
                                </div>
                            </div>
                            <div class="col-md-6" id="serviceTypeGroup" style="display:none;">
                                <label class="form-label">نوع خدمت</label>
                                <div class="input-group">
                                    <select name="service_type" class="form-select" id="serviceTypeSelect">
                                        <option value="">انتخاب کنید</option>
                                        {{-- اگر serviceTypes ارسال شد --}}
                                        @isset($serviceTypes)
                                            @foreach($serviceTypes as $st)
                                                <option value="{{ $st->title }}" @selected(old('service_type')==$st->title)>{{ $st->title }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    <button class="btn btn-outline-primary" type="button" id="btnManageServiceTypes"><i class="fa fa-cog"></i></button>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-center">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" name="active" id="activeSwitch" value="1" checked>
                                    <label class="form-check-label ms-2" for="activeSwitch">فعال باشد</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-success px-4">ثبت دسته‌بندی</button>
                            <a href="{{ route('categories.list') }}" class="btn btn-outline-secondary">انصراف</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('categories.partials.person_type_modal')
@include('categories.partials.unit_modal')
@include('categories.partials.service_type_modal')
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/category-form.css') }}">
<link rel="stylesheet" href="{{ asset('css/category-advanced.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/category-form.js') }}"></script>
<script src="{{ asset('js/category-advanced.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // نمایش/مخفی کردن فیلدهای وابسته به نوع دسته‌بندی
    function updateTypeFields() {
        let type = document.getElementById('categoryType').value;
        document.getElementById('personTypeGroup').style.display = (type === 'person' ? '' : 'none');
        document.getElementById('unitGroup').style.display = (type === 'product' ? '' : 'none');
        document.getElementById('serviceTypeGroup').style.display = (type === 'service' ? '' : 'none');
    }
    document.getElementById('categoryType').addEventListener('change', updateTypeFields);
    updateTypeFields();

    // مدیریت مدال‌ها
    document.getElementById('btnManagePersonTypes').onclick = function() {
        document.getElementById('modal-personType').style.display = 'flex';
    };
    document.getElementById('btnManageUnits').onclick = function() {
        document.getElementById('modal-unit').style.display = 'flex';
    };
    document.getElementById('btnManageServiceTypes').onclick = function() {
        document.getElementById('modal-serviceType').style.display = 'flex';
    };
});
</script>
@endpush
