@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/category-form.css') }}">
<style>
.switch-cat-type {
    display: flex; gap: 1rem; justify-content: center; margin-bottom: 2rem;
}
.switch-cat-type label {
    font-weight: bold; font-size: 1.05rem;
    padding: .5rem 1.3rem; border-radius: 30px;
    background: #f3f7fa; cursor: pointer; transition: background .16s;
    border: 2px solid #cbd5e1;
    display: flex; align-items: center; gap: .5rem;
}
.switch-cat-type input[type="radio"]:checked + span {
    color: #1565c0;
    font-weight: bold;
    background: #e3f2fd;
    border-color: #1565c0;
}
.switch-cat-type input[type="radio"] { display: none; }
.cat-section { display: none; }
.cat-section.active { display: block; }
.form-switch { display: flex; align-items: center; gap: .5rem; }

/* --- CUSTOM FOR CODE FIELD --- */
.code-switch-box {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}
.code-switch-box label {
    margin-bottom: 0;
    font-size: 0.98rem;
    font-weight: 500;
}
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="mx-auto bg-white shadow rounded-3xl p-5" style="max-width: 600px;">
        <h2 class="mb-2 text-blue-700 fw-bold d-flex align-items-center gap-2" style="font-size:1.7rem">
            <i class="fa fa-layer-group text-blue-400"></i>
            مدیریت دسته‌بندی‌ها
        </h2>
        <div class="switch-cat-type mb-4">
            <label>
                <input type="radio" name="catType" value="person" checked>
                <span><i class="fa fa-user-group"></i> دسته‌بندی اشخاص</span>
            </label>
            <label>
                <input type="radio" name="catType" value="product">
                <span><i class="fa fa-cube"></i> دسته‌بندی کالا</span>
            </label>
            <label>
                <input type="radio" name="catType" value="service">
                <span><i class="fa fa-hand-holding-heart"></i> دسته‌بندی خدمات</span>
            </label>
        </div>

        {{-- دسته‌بندی اشخاص --}}
        <div class="cat-section active" id="cat-person">
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
                        @foreach($personCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0">نوع شخص</label>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="manage-person-type-btn">
                        مدیریت نوع شخص
                    </button>
                </div>
                <div class="mb-3">
                    <select name="person_type" class="form-select">
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
        </div>

        {{-- دسته‌بندی کالا --}}
        <div class="cat-section" id="cat-product">
            <form method="POST" action="{{ route('categories.store', ['type' => 'product']) }}" enctype="multipart/form-data" id="productCatForm" autocomplete="off">
                @csrf
                <div class="mb-4 text-center">
                    <label class="category-img-dropzone" id="product-cat-dropzone">
                        <img id="product-cat-img-preview" src="{{ asset('images/category-default.png') }}" alt="تصویر دسته" />
                        <span class="category-img-edit-overlay">ویرایش تصویر</span>
                        <input type="file" name="image" id="product-cat-img-input" accept="image/*" style="display:none">
                    </label>
                    <div class="text-muted" style="font-size:0.95rem;">تصویر دسته‌بندی</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">نام دسته‌بندی <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required maxlength="100">
                </div>
                <div class="mb-3">
                    <div class="code-switch-box">
                        <label for="product-code-switch">کد خودکار:</label>
                        <input type="checkbox" id="product-code-switch" checked>
                        <span style="font-size:0.92rem;">(در حالت فعال، کد غیرقابل ویرایش و اتوماتیک است)</span>
                    </div>
                    <label class="form-label">کد دسته‌بندی <span class="text-danger">*</span></label>
                    <input type="text" name="code" id="product-code-input" class="form-control" required maxlength="20" readonly value="cat-pr1001">
                </div>
                <div class="mb-3">
                    <label class="form-label">دسته والد</label>
                    <select name="parent_id" class="form-select">
                        <option value="">بدون والد (دسته اصلی)</option>
                        @foreach($productCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0">واحد اصلی</label>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="manage-unit-btn">
                        مدیریت واحد اصلی
                    </button>
                </div>
                <div class="mb-3">
                    <select name="unit" class="form-select">
                        <option value="">انتخاب کنید</option>
                        <option>عدد</option>
                        <option>کیلوگرم</option>
                        <option>متر</option>
                        <option>لیتر</option>
                        <option>بسته</option>
                        <option>سایر</option>
                    </select>
                </div>
                {{-- حذف حساب معین مرتبط --}}
                <div class="mb-3">
                    <label class="form-label">مالیات پیش‌فرض (%)</label>
                    <input type="number" name="tax" class="form-control" min="0" max="100" step="0.1">
                </div>
                <div class="mb-3">
                    <label class="form-label">توضیحات</label>
                    <textarea name="description" class="form-control" rows="3" maxlength="500"></textarea>
                </div>
                <div class="mb-3 form-switch">
                    <input class="form-check-input" type="checkbox" value="1" name="active" id="product-active" checked>
                    <label class="form-check-label" for="product-active">فعال</label>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">
                        <i class="fa fa-save ms-2"></i> ثبت دسته‌بندی کالا
                    </button>
                </div>
            </form>
        </div>

        {{-- دسته‌بندی خدمات --}}
        <div class="cat-section" id="cat-service">
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
                        @foreach($serviceCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0">نوع خدمات</label>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="manage-service-type-btn">
                        مدیریت نوع خدمات
                    </button>
                </div>
                <div class="mb-3">
                    <select name="service_type" class="form-select">
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
                {{-- حذف حساب معین مرتبط --}}
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
        </div>
        {{-- MODALS (پاپ‌آپ) --}}
        @include('categories.partials.person_type_modal')
        @include('categories.partials.unit_modal')
        @include('categories.partials.service_type_modal')
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
<script>
document.querySelectorAll('.switch-cat-type input[type="radio"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.cat-section').forEach(function(sec){ sec.classList.remove('active'); });
        if(this.value === "person") document.getElementById('cat-person').classList.add('active');
        else if(this.value === "product") document.getElementById('cat-product').classList.add('active');
        else if(this.value === "service") document.getElementById('cat-service').classList.add('active');
    });
});

// تصویر (پیش‌نمایش) برای هر فرم
function previewImg(inputId, imgId) {
    document.getElementById(inputId).addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = ev => document.getElementById(imgId).src = ev.target.result;
            reader.readAsDataURL(file);
        }
    });
}
previewImg('person-cat-img-input', 'person-cat-img-preview');
previewImg('product-cat-img-input', 'product-cat-img-preview');
previewImg('service-cat-img-input', 'service-cat-img-preview');

['person-cat-dropzone','product-cat-dropzone','service-cat-dropzone'].forEach(function(id, i){
    document.getElementById(id).onclick = function(){
        this.querySelector('input[type="file"]').click();
    };
});

// --- کد دسته‌بندی خودکار و سوییچ ---
function toggleCodeSwitch(codeInputId, codeSwitchId, defaultValue) {
    const input = document.getElementById(codeInputId);
    const sw = document.getElementById(codeSwitchId);
    sw.addEventListener('change', function() {
        if (this.checked) {
            input.value = defaultValue;
            input.setAttribute('readonly', true);
        } else {
            input.removeAttribute('readonly');
        }
    });
}
toggleCodeSwitch('person-code-input', 'person-code-switch', 'per-001');
toggleCodeSwitch('product-code-input', 'product-code-switch', 'cat-pr1001');
toggleCodeSwitch('service-code-input', 'service-code-switch', 'cat-ser1001');

// --- مدیریت پاپ‌آپ‌ها ---
document.getElementById('manage-person-type-btn').onclick = function() {
    var myModal = new bootstrap.Modal(document.getElementById('personTypeModal'));
    myModal.show();
};
document.getElementById('manage-unit-btn').onclick = function() {
    var myModal = new bootstrap.Modal(document.getElementById('unitModal'));
    myModal.show();
};
document.getElementById('manage-service-type-btn').onclick = function() {
    var myModal = new bootstrap.Modal(document.getElementById('serviceTypeModal'));
    myModal.show();
};
</script>
@endsection
