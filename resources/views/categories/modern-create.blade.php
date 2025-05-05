@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/category-form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/category-advanced.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Custom styles for the modern category management page */
        .tab-header {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .tab-header .tab-btn {
            padding: .7rem 2.2rem;
            border-radius: 2rem;
            font-weight: bold;
            font-size: 1.1rem;
            border: 2px solid #dbeafe;
            background: #f8fafc;
            color: #2779e2;
            position: relative;
            cursor: pointer;
            transition: all .18s;
        }
        .tab-header .tab-btn.active,
        .tab-header .tab-btn:focus {
            background: linear-gradient(90deg,#e0f2fe 50%,#c7d2fe 100%);
            color: #0f172a;
            border-color: #60a5fa;
            box-shadow: 0 2px 12px #c7d2fe77;
        }
        .tab-header .tab-btn i {
            margin-left: 8px;
        }
        .tab-header .tab-badge {
            position: absolute;
            top: 2px;
            left: 3px;
            background: #16a34a;
            color: #fff;
            border-radius: 8px;
            font-size: .78rem;
            padding: 1px 7px;
            font-weight: bold;
            min-width: 24px;
            text-align: center;
        }
        .cat-section {
            display: none;
        }
        .cat-section.active {
            display: block;
        }
        .category-list-search {
            background: #f4f6fb;
            border-radius: 1rem;
            margin: 2rem 0 1.2rem 0;
            padding: 1rem 1.2rem;
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .category-list-search input {
            max-width: 340px;
            direction: rtl;
        }
        .category-list-table {
            width: 100%;
            background: #fff;
            border-radius: 1.1rem;
            box-shadow: 0 2px 12px #e0e7ef33;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .category-list-table th, .category-list-table td {
            vertical-align: middle !important;
            font-size: .98rem;
        }
        .category-list-table th {
            background: #e0e7ef;
            color: #374151;
        }
        .category-list-table tr {
            transition: background .13s;
        }
        .category-list-table tr:hover {
            background: #f1f5f9;
        }
        .category-action-btns button {
            margin-left: 6px;
        }
        .category-list-table .fa-check-circle {
            color: #16a34a;
        }
        .category-list-table .fa-times-circle {
            color: #ef4444;
        }
        .category-list-table .editable-cell {
            background: #f5faff;
        }
        .alert {
            margin-top: 1.2rem;
            display: none;
        }
        /* Loader overlay */
        .loader-overlay {
            position: fixed;
            z-index: 99999;
            inset: 0;
            background: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .loader {
            border: 6px solid #dbeafe;
            border-top: 6px solid #3b82f6;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1.1s linear infinite;
        }
        @keyframes spin {
            0% {transform: rotate(0);}
            100% {transform: rotate(360deg);}
        }
        /* Responsive */
        @media (max-width: 700px) {
            .tab-header {
                flex-direction: column;
                gap: .6rem;
            }
            .category-list-search {
                flex-direction: column;
                gap: .7rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="container py-5">
    <div class="mx-auto bg-white rounded-3xl shadow p-5" style="max-width:950px">
        <h2 class="mb-2 text-blue-700 fw-bold d-flex align-items-center gap-2" style="font-size:1.7rem">
            <i class="fa fa-layer-group text-blue-400"></i>
            مدیریت دسته‌بندی‌ها
        </h2>

        <!-- تب‌های انتخاب نوع دسته‌بندی -->
        <div class="tab-header mb-4" id="tab-header">
            <button class="tab-btn active" data-tab="person">
                <i class="fa fa-user-group"></i> اشخاص
                <span class="tab-badge" id="badge-person">0</span>
            </button>
            <button class="tab-btn" data-tab="product">
                <i class="fa fa-cube"></i> کالا
                <span class="tab-badge" id="badge-product">0</span>
            </button>
            <button class="tab-btn" data-tab="service">
                <i class="fa fa-hand-holding-heart"></i> خدمات
                <span class="tab-badge" id="badge-service">0</span>
            </button>
        </div>

        <!-- بخش دسته‌بندی اشخاص -->
        <div class="cat-section active" id="cat-person">
            @include('categories.partials.modern_person_form')
            <div class="category-list-search">
                <input type="text" class="form-control" id="search-person" placeholder="جستجو در دسته‌بندی اشخاص...">
                <button class="btn btn-outline-primary" id="refresh-person-list"><i class="fa fa-sync"></i> بروزرسانی</button>
            </div>
            <div class="table-responsive">
                <table class="table category-list-table" id="table-person">
                    <thead>
                        <tr>
                            <th>تصویر</th>
                            <th>نام</th>
                            <th>کد</th>
                            <th>نوع</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="alert alert-info text-center" id="no-person-alert">دسته‌بندی یافت نشد.</div>
            </div>
        </div>

        <!-- بخش دسته‌بندی کالا -->
        <div class="cat-section" id="cat-product">
            @include('categories.partials.modern_product_form')
            <div class="category-list-search">
                <input type="text" class="form-control" id="search-product" placeholder="جستجو در دسته‌بندی کالا...">
                <button class="btn btn-outline-primary" id="refresh-product-list"><i class="fa fa-sync"></i> بروزرسانی</button>
            </div>
            <div class="table-responsive">
                <table class="table category-list-table" id="table-product">
                    <thead>
                        <tr>
                            <th>تصویر</th>
                            <th>نام</th>
                            <th>کد</th>
                            <th>واحد</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="alert alert-info text-center" id="no-product-alert">دسته‌بندی یافت نشد.</div>
            </div>
        </div>

        <!-- بخش دسته‌بندی خدمات -->
        <div class="cat-section" id="cat-service">
            @include('categories.partials.modern_service_form')
            <div class="category-list-search">
                <input type="text" class="form-control" id="search-service" placeholder="جستجو در دسته‌بندی خدمات...">
                <button class="btn btn-outline-primary" id="refresh-service-list"><i class="fa fa-sync"></i> بروزرسانی</button>
            </div>
            <div class="table-responsive">
                <table class="table category-list-table" id="table-service">
                    <thead>
                        <tr>
                            <th>تصویر</th>
                            <th>نام</th>
                            <th>کد</th>
                            <th>نوع خدمت</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="alert alert-info text-center" id="no-service-alert">دسته‌بندی یافت نشد.</div>
            </div>
        </div>

        <!-- لودر سراسری -->
        <div id="global-loader" class="loader-overlay" style="display:none;">
            <div class="loader"></div>
        </div>
    </div>
    <!-- مدال‌های مدیریت انواع شخص، واحد، نوع خدمت -->
    @include('categories.partials.modern_person_type_modal')
    @include('categories.partials.modern_unit_modal')
    @include('categories.partials.modern_service_type_modal')
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    <script src="{{ asset('js/category-modern.js') }}"></script>
@endsection
