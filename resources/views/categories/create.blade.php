@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('css/category-form.css') }}">
@endsection

@section('content')
<div class="category-container">
    <div class="category-tabs">
        <button class="category-tab active" data-target="person"><i class="fa fa-user-group"></i> دسته‌بندی اشخاص</button>
        <button class="category-tab" data-target="product"><i class="fa fa-cube"></i> دسته‌بندی کالا</button>
        <button class="category-tab" data-target="service"><i class="fa fa-hand-holding-heart"></i> دسته‌بندی خدمات</button>
    </div>
    <div class="category-forms">
        {{-- فرم اشخاص --}}
        <form method="POST" action="{{ route('categories.store', ['type' => 'person']) }}" enctype="multipart/form-data" class="category-form active" id="form-person" autocomplete="off">
            @csrf
            @include('categories.partials.category_person_form')
        </form>
        {{-- فرم کالا --}}
        <form method="POST" action="{{ route('categories.store', ['type' => 'product']) }}" enctype="multipart/form-data" class="category-form" id="form-product" autocomplete="off">
            @csrf
            @include('categories.partials.category_product_form')
        </form>
        {{-- فرم خدمات --}}
        <form method="POST" action="{{ route('categories.store', ['type' => 'service']) }}" enctype="multipart/form-data" class="category-form" id="form-service" autocomplete="off">
            @csrf
            @include('categories.partials.category_service_form')
        </form>
    </div>
    {{-- پاپ‌آپ مدیریت گزینه‌ها --}}
    @include('categories.partials.person_type_modal')
    @include('categories.partials.unit_modal')
    @include('categories.partials.service_type_modal')
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/category-form.js') }}"></script>
@endsection
