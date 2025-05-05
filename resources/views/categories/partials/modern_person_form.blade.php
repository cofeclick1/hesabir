<form method="POST" action="{{ route('categories.store', ['type' => 'person']) }}" enctype="multipart/form-data" id="personCatForm" autocomplete="off">
    @csrf
    <div class="mb-4 text-center">
        <label class="category-img-dropzone" id="person-cat-dropzone">
            <img id="person-cat-img-preview" src="{{ asset('images/category-default.png') }}" alt="تصویر دسته" />
            <span class="category-img-edit-overlay">ویرایش تصویر</span>
            <input type="file" name="image" id="person-cat-img-input" accept="image/*" style="display:none">
        </label>
        <div class="text-muted" style="font-size:0.95rem;">تصویر دسته‌بندی</div>
    </div>
    <div class="mb-3">
        <label class="form-label">نام دسته‌بندی <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" required maxlength="100">
    </div>
    <div class="mb-3">
        <div class="code-switch-box">
            <label for="person-code-switch">کد خودکار:</label>
            <input type="checkbox" id="person-code-switch" checked>
            <span style="font-size:0.92rem;">(در حالت فعال، کد غیرقابل ویرایش و اتوماتیک است)</span>
        </div>
        <label class="form-label">کد دسته‌بندی <span class="text-danger">*</span></label>
        <input type="text" name="code" id="person-code-input" class="form-control" required maxlength="20" readonly value="per-001">
    </div>
    <div class="mb-3">
        <label class="form-label">دسته والد</label>
        <select name="parent_id" class="form-select">
            <option value="">بدون والد (دسته اصلی)</option>
            @isset($personCategories)
                @foreach($personCategories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                @endforeach
            @endisset
        </select>
    </div>
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <label class="form-label mb-0">نوع شخص</label>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="manage-person-type-btn">
            مدیریت نوع شخص
        </button>
    </div>
    <div class="mb-3">
        <select name="person_type" class="form-select" id="person-type-select">
            <option value="">انتخاب کنید</option>
            <option>مشتری</option>
            <option>تأمین‌کننده</option>
            <option>کارمند</option>
            <option>سهامدار</option>
            <option>سایر</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">توضیحات</label>
        <textarea name="description" class="form-control" rows="3" maxlength="500"></textarea>
    </div>
    <div class="mb-3 form-switch">
        <input class="form-check-input" type="checkbox" value="1" name="active" id="person-active" checked>
        <label class="form-check-label" for="person-active">فعال</label>
    </div>
    <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary btn-lg fw-bold">
            <i class="fa fa-save ms-2"></i> ثبت دسته‌بندی اشخاص
        </button>
    </div>
</form>
