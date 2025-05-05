<form method="POST" action="{{ route('categories.store', ['type' => 'service']) }}" enctype="multipart/form-data" id="serviceCatForm" autocomplete="off">
    @csrf
    <div class="mb-4 text-center">
        <label class="category-img-dropzone" id="service-cat-dropzone">
            <img id="service-cat-img-preview" src="{{ asset('images/category-default.png') }}" alt="تصویر دسته" />
            <span class="category-img-edit-overlay">ویرایش تصویر</span>
            <input type="file" name="image" id="service-cat-img-input" accept="image/*" style="display:none">
        </label>
        <div class="text-muted" style="font-size:0.95rem;">تصویر دسته‌بندی</div>
    </div>
    <div class="mb-3">
        <label class="form-label">نام دسته‌بندی <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" required maxlength="100">
    </div>
    <div class="mb-3">
        <div class="code-switch-box">
            <label for="service-code-switch">کد خودکار:</label>
            <input type="checkbox" id="service-code-switch" checked>
            <span style="font-size:0.92rem;">(در حالت فعال، کد غیرقابل ویرایش و اتوماتیک است)</span>
        </div>
        <label class="form-label">کد دسته‌بندی <span class="text-danger">*</span></label>
        <input type="text" name="code" id="service-code-input" class="form-control" required maxlength="20" readonly value="cat-ser1001">
    </div>
    <div class="mb-3">
        <label class="form-label">دسته والد</label>
        <select name="parent_id" class="form-select">
            <option value="">بدون والد (دسته اصلی)</option>
            @isset($serviceCategories)
                @foreach($serviceCategories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                @endforeach
            @endisset
        </select>
    </div>
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label class="form-label mb-0">نوع خدمت</label>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="manage-service-type-btn">
            مدیریت نوع خدمت
        </button>
    </div>
    <div class="mb-3">
        <select name="service_type" class="form-select" id="service-type-select">
            <option value="">انتخاب کنید</option>
            <option>مشاوره</option>
            <option>تعمیرات</option>
            <option>آموزش</option>
            <option>حمل‌ونقل</option>
            <option>سایر</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">نرخ پایه خدمت (تومان)</label>
        <input type="number" name="base_rate" class="form-control" min="0" step="1000">
    </div>
    <div class="mb-3">
        <label class="form-label">مالیات پیش‌فرض (%)</label>
        <input type="number" name="tax" class="form-control" min="0" max="100" step="0.1">
    </div>
    <div class="mb-3">
        <label class="form-label">توضیحات</label>
        <textarea name="description" class="form-control" rows="3" maxlength="500"></textarea>
    </div>
    <div class="mb-3 form-switch">
        <input class="form-check-input" type="checkbox" value="1" name="active" id="service-active" checked>
        <label class="form-check-label" for="service-active">فعال</label>
    </div>
    <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary btn-lg fw-bold">
            <i class="fa fa-save ms-2"></i> ثبت دسته‌بندی خدمات
        </button>
    </div>
</form>
