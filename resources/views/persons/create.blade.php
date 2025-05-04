@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="../css/person-create.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css" />
<style>
@font-face {
  font-family: 'IRANSans';
  src: url('/fonts/IRANSans.woff2') format('woff2');
  font-weight: normal;
  font-style: normal;
}
input[type="number"], input[type="text"], input[type="date"], .persian-datepicker, .form-input, .form-control {
  font-family: 'IRANSans', Tahoma, Arial, sans-serif !important;
  letter-spacing: 0;
}
.persian-num { font-family: 'IRANSans', Tahoma, Arial, sans-serif !important; direction: ltr; text-align: left; }
.profile-img-upload-area { position: relative; display: inline-block; }
.profile-img-upload-area .img-overlay {
    display: flex; align-items: center; justify-content: center;
    position: absolute; inset: 0; background: rgba(30,41,59,0.45);
    color: #fff; font-weight: bold; font-size: 1rem; border-radius: 9999px;
    opacity: 0; pointer-events: none; transition: opacity .3s; z-index: 2;
}
.profile-img-upload-area:hover .img-overlay,
.profile-img-upload-area:focus-within .img-overlay { opacity: 1; pointer-events: auto; }
.profile-img-upload-area:hover img,
.profile-img-upload-area:focus-within img { filter: blur(2px) brightness(0.8); }
.cat-modal-bg {
    background: rgba(0,0,0,.33); position: fixed; inset: 0; z-index: 9999;
    display: flex; align-items: center; justify-content: center;
}
.cat-modal { background: #fff; border-radius: 20px; padding: 2rem 1.5rem 1.5rem; min-width: 350px; box-shadow: 0 12px 24px rgba(30,41,59,.14); position: relative; max-width: 95vw; }
.cat-modal input, .cat-modal button, .cat-modal select { font-family: 'IRANSans', Tahoma, Arial, sans-serif !important; }
.cat-modal .cat-list { max-height: 220px; overflow-y: auto; margin-top: 1rem; }
.cat-modal .cat-item { display: flex; align-items: center; justify-content: space-between; font-size: 1rem; padding: .35rem .5rem; border-radius: 7px; cursor: pointer; transition: background .2s; }
.cat-modal .cat-item.active, .cat-modal .cat-item:hover { background: #f1f5f9; }

/** بانک جدید: modal **/
#bankModalBg {
    background: rgba(0,0,0,.33); position: fixed; inset: 0; z-index: 9999;
    display: flex; align-items: center; justify-content: center;
}
#bankModal { background: #fff; border-radius: 16px; padding: 1.5rem; min-width: 340px; box-shadow: 0 8px 24px rgba(30,41,59,.13); position: relative; max-width: 95vw; }
#bankModal input, #bankModal button { font-family: 'IRANSans', Tahoma, Arial, sans-serif !important; }
#bankModal .bank-table { width: 100%; border-collapse: collapse; margin: 1rem 0 .5rem 0; }
#bankModal .bank-table th, #bankModal .bank-table td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; text-align: left; }
#bankModal .bank-table th { background: #f8fafc; }
#bankModal .remove-bank-modal-row { color: #d32f2f; background: none; border: none; font-size: 1.1em; cursor: pointer;}
</style>
@endsection

@section('content')
<div class="container mx-auto py-6 px-2">
    <form id="personForm" method="POST" action="{{ route('persons.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-md p-6">
        @csrf
        <h1 class="text-2xl font-bold text-primary mb-6 text-center">افزودن شخص جدید</h1>
        <div class="flex flex-col md:flex-row md:gap-6">
            {{-- تصویر شخص --}}
            <div class="w-full md:w-1/5 flex flex-col items-center mb-5">
                <div class="profile-img-upload-area" tabindex="0" onclick="document.getElementById('avatar').click()">
                    <img id="profilePreview" src="{{ asset('images/default-avatar.png') }}" class="rounded-full border-2 border-primary w-28 h-28 object-cover" alt="شخص">
                    <div class="img-overlay">انتخاب تصویر</div>
                    <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                    <button type="button" onclick="event.stopPropagation();document.getElementById('avatar').click()" class="absolute bottom-0 left-0 bg-primary text-white px-3 py-1 rounded-full text-xs">ویرایش</button>
                </div>
            </div>
            <div class="w-full md:w-4/5">
                <div class="flex flex-wrap gap-4 items-center mb-3">
                    {{-- کد حسابداری --}}
                    <label class="block text-gray-700 font-bold mb-2 w-full md:w-auto">کد حسابداری:</label>
                    <div class="flex items-center gap-2">
                        <input type="text" name="account_code" id="account_code" class="form-input w-32 text-center persian-num" value="{{ old('account_code', $suggestedCode ?? '0001') }}" readonly>
                        <label class="switch">
                            <input type="checkbox" id="autoCodeSwitch" checked>
                            <span class="slider"></span>
                        </label>
                        <span class="text-xs text-gray-500" id="autoCodeHint">تولید خودکار کد</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1">شرکت</label>
                        <input type="text" name="company" class="form-input w-full" value="{{ old('company') }}">
                    </div>
                    <div>
                        <label class="block mb-1">عنوان</label>
                        <input type="text" name="title" class="form-input w-full" value="{{ old('title') }}">
                    </div>
                    <div>
                        <label class="block mb-1">نام</label>
                        <input type="text" name="first_name" id="first_name" class="form-input w-full" value="{{ old('first_name') }}">
                    </div>
                    <div>
                        <label class="block mb-1">نام خانوادگی</label>
                        <input type="text" name="last_name" class="form-input w-full" value="{{ old('last_name') }}">
                    </div>
                    <div>
                        <label class="block mb-1">نام مستعار</label>
                        <input type="text" name="nickname" class="form-input w-full" value="{{ old('nickname') }}">
                    </div>
                    <div>
                        <label class="block mb-1">دسته‌بندی</label>
                        <div class="flex gap-2">
                            <input type="hidden" name="category_id" id="category_id" value="">
                            <input type="text" id="category_title_view" class="form-input w-full bg-gray-100" readonly placeholder="انتخاب کنید..." onclick="openCatModal()" style="cursor:pointer">
                            <button type="button" id="openCatModalBtn" class="bg-accent text-white px-3 rounded" onclick="openCatModal()">انتخاب یا ساخت دسته‌بندی</button>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1">نوع شخص</label>
                        <select name="type" id="type" class="form-input w-full">
                            <option value="">انتخاب کنید</option>
                            <option value="customer">مشتری</option>
                            <option value="supplier">تأمین‌کننده</option>
                            <option value="shareholder">سهامدار</option>
                            <option value="employee">کارمند</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        {{-- تب‌بندی --}}
        <div class="tabs mt-6">
            <ul class="tab-header flex gap-2 border-b">
                <li class="active" data-tab="general">عمومی</li>
                <li data-tab="address">آدرس</li>
                <li data-tab="contact">تماس</li>
                <li data-tab="bank">حساب بانکی</li>
                <li data-tab="other">سایر</li>
            </ul>
            <div class="tab-content bg-white rounded-b-xl p-3">
                {{-- عمومی --}}
                <div class="tab-panel active" data-tab="general">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label>اعتبار مالی (ریال)</label>
                            <input type="number" name="credit" class="form-input w-full persian-num" value="0">
                        </div>
                        <div>
                            <label>لیست قیمت</label>
                            <input type="text" name="price_list" class="form-input w-full">
                        </div>
                        <div>
                            <label>نوع مالیات</label>
                            <select name="tax_type" class="form-input w-full">
                                <option>۵- مودی مشمول ثبت نام در نظام مالیاتی</option>
                            </select>
                        </div>
                        <div>
                            <label>شناسه ملی</label>
                            <input type="text" name="national_id" class="form-input w-full">
                        </div>
                        <div>
                            <label>کد اقتصادی</label>
                            <input type="text" name="economic_code" class="form-input w-full">
                        </div>
                        <div>
                            <label>شماره ثبت</label>
                            <input type="text" name="register_no" class="form-input w-full">
                        </div>
                        <div>
                            <label>کد شعبه</label>
                            <input type="text" name="branch_code" class="form-input w-full">
                        </div>
                        <div>
                            <label>توضیحات</label>
                            <textarea name="description" class="form-input w-full h-16"></textarea>
                        </div>
                    </div>
                </div>
                {{-- آدرس --}}
                <div class="tab-panel" data-tab="address">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label>آدرس</label><input type="text" name="address" class="form-input w-full"></div>
                        <div><label>کشور</label><input type="text" name="country" class="form-input w-full"></div>
                        <div><label>استان</label><input type="text" name="state" class="form-input w-full"></div>
                        <div><label>شهر</label><input type="text" name="city" class="form-input w-full"></div>
                        <div><label>کدپستی</label><input type="text" name="postal_code" class="form-input w-full"></div>
                    </div>
                </div>
                {{-- تماس --}}
                <div class="tab-panel" data-tab="contact">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label>تلفن</label><input type="text" name="phone" class="form-input w-full"></div>
                        <div><label>موبایل</label><input type="text" name="mobile" class="form-input w-full"></div>
                        <div><label>فکس</label><input type="text" name="fax" class="form-input w-full"></div>
                        <div><label>تلفن ۱</label><input type="text" name="phone1" class="form-input w-full"></div>
                        <div><label>تلفن ۲</label><input type="text" name="phone2" class="form-input w-full"></div>
                        <div><label>تلفن ۳</label><input type="text" name="phone3" class="form-input w-full"></div>
                        <div><label>ایمیل</label><input type="email" name="email" class="form-input w-full"></div>
                        <div><label>وب سایت</label><input type="text" name="website" class="form-input w-full"></div>
                    </div>
                </div>
                {{-- حساب بانکی --}}
                <div class="tab-panel" data-tab="bank">
                    <div id="bankAccounts">
                        <div class="flex gap-4 mb-2 bank-row">
                            <input type="text" name="banks[0][bank]" placeholder="بانک" class="form-input flex-1">
                            <input type="text" name="banks[0][account]" placeholder="شماره حساب" class="form-input flex-1 persian-num">
                            <input type="text" name="banks[0][card]" placeholder="شماره کارت" class="form-input flex-1 persian-num">
                            <input type="text" name="banks[0][sheba]" placeholder="شبا" class="form-input flex-1 persian-num">
                            <button type="button" class="remove-bank-row bg-red-500 text-white px-2 py-1 rounded hidden" onclick="removeBankRow(this)">حذف</button>
                        </div>
                    </div>
                    <button type="button" id="addBankBtn" class="bg-primary text-white px-3 py-1 rounded mt-2">افزودن حساب بانکی جدید</button>
                    <button type="button" id="openBankModalBtn" class="bg-accent text-white px-3 py-1 rounded mt-2 ml-2">مدیریت حساب‌های بانکی دیگر</button>
                </div>
                {{-- سایر --}}
                <div class="tab-panel" data-tab="other">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label>تاریخ تولد</label>
                            <input type="text" name="birthday" id="birthday" class="form-input w-full persian-num" autocomplete="off">
                        </div>
                        <div>
                            <label>تاریخ ازدواج</label>
                            <input type="text" name="marriage_date" id="marriage_date" class="form-input w-full persian-num" autocomplete="off">
                        </div>
                        <div>
                            <label>تاریخ عضویت</label>
                            <div class="flex gap-2">
                                <input type="text" name="join_date" id="join_date" class="form-input w-full persian-num" autocomplete="off">
                                <button type="button" class="bg-accent text-white px-3 rounded" onclick="setTodayJalali('join_date')">امروز</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- دکمه ثبت --}}
        <div class="text-center mt-6">
            <button type="submit" class="bg-primary text-white font-bold py-3 px-8 rounded-lg shadow hover:bg-accent transition">ثبت شخص</button>
        </div>
    </form>
</div>

{{-- پاپ‌آپ انتخاب و جستجوی دسته‌بندی --}}
<div id="catModal" class="cat-modal-bg" style="display:none">
    <div class="cat-modal">
        <div class="flex justify-between items-center mb-2">
            <strong>انتخاب دسته‌بندی</strong>
            <button type="button" onclick="closeCatModal()" style="background: none;border:none;font-size:1.6rem;color:#999">&times;</button>
        </div>
        <input type="text" id="catSearchInput" class="form-input w-full" placeholder="جستجو...">
        <div class="cat-list" id="catList"></div>
        <div class="mt-2">
            <input type="text" id="newCatTitle" class="form-input w-full mb-2" placeholder="عنوان دسته‌بندی جدید">
            <button type="button" class="bg-primary text-white px-4 py-2 rounded w-full" onclick="createCategory()">ایجاد دسته‌بندی جدید</button>
        </div>
    </div>
</div>

{{-- پاپ‌آپ مدیریت حساب‌های بانکی (جدول جداگانه) --}}
<div id="bankModalBg" style="display:none;">
    <div id="bankModal">
        <div class="flex justify-between items-center mb-3">
            <strong>جدول حساب‌های بانکی دیگر</strong>
            <button type="button" onclick="closeBankModal()" style="background: none;border:none;font-size:1.6rem;color:#999">&times;</button>
        </div>
        <table class="bank-table w-full" id="otherBanksTable">
            <thead>
                <tr>
                    <th>نام بانک</th>
                    <th>شماره حساب</th>
                    <th>شماره کارت</th>
                    <th>شبا</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <button type="button" class="bg-primary text-white px-3 py-1 rounded mt-1" onclick="addOtherBankRow()">افزودن ردیف جدید</button>
        <button type="button" class="bg-green-600 text-white px-4 py-1 rounded mt-3 float-left" onclick="saveOtherBanks()">ثبت و افزودن به فرم</button>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-date@0.1.8/dist/persian-date.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
<script>
// تب‌ها
document.querySelectorAll('.tab-header li').forEach(function(tab) {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.tab-header li').forEach(el => el.classList.remove('active'));
        this.classList.add('active');
        const target = this.getAttribute('data-tab');
        document.querySelectorAll('.tab-panel').forEach(panel => {
            if(panel.getAttribute('data-tab') === target) panel.classList.add('active');
            else panel.classList.remove('active');
        });
    });
});

// تصویر ـ پیش‌نمایش و نوتیفیکیشن SweetAlert2
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if(file) {
        if (!file.type.startsWith('image/')) {
            Swal.fire({ icon: 'error', title: 'خطا', text: 'فقط فایل تصویر مجاز است!' });
            e.target.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('profilePreview').src = ev.target.result;
        }
        reader.readAsDataURL(file);
        Swal.fire({ icon: 'success', title: 'تصویر انتخاب شد', timer: 1000, showConfirmButton: false });
    }
});

// بانک ـ افزودن و حذف ردیف
let bankRowIndex = 1;
document.getElementById('addBankBtn').addEventListener('click', function() {
    const container = document.getElementById('bankAccounts');
    const row = document.createElement('div');
    row.className = 'flex gap-4 mb-2 bank-row';
    row.innerHTML = `
        <input type="text" name="banks[${bankRowIndex}][bank]" placeholder="بانک" class="form-input flex-1">
        <input type="text" name="banks[${bankRowIndex}][account]" placeholder="شماره حساب" class="form-input flex-1 persian-num">
        <input type="text" name="banks[${bankRowIndex}][card]" placeholder="شماره کارت" class="form-input flex-1 persian-num">
        <input type="text" name="banks[${bankRowIndex}][sheba]" placeholder="شبا" class="form-input flex-1 persian-num">
        <button type="button" class="remove-bank-row bg-red-500 text-white px-2 py-1 rounded" onclick="removeBankRow(this)">حذف</button>
    `;
    container.appendChild(row);
    bankRowIndex++;
});
window.removeBankRow = function(btn) {
    btn.closest('.bank-row').remove();
}

// --- بانک جدید: مدیریت حساب‌های بانکی دیگر ---
let bankModalBg = document.getElementById('bankModalBg');
let otherBankIndex = 0;
document.getElementById('openBankModalBtn').onclick = function() {
    bankModalBg.style.display = "flex";
    renderOtherBanksTable();
}
window.closeBankModal = function() {
    bankModalBg.style.display = "none";
}
function addOtherBankRow() {
    let tbody = document.querySelector('#otherBanksTable tbody');
    let tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="text" class="form-input" name="other_banks[${otherBankIndex}][bank]" placeholder="بانک"></td>
        <td><input type="text" class="form-input persian-num" name="other_banks[${otherBankIndex}][account]" placeholder="شماره حساب"></td>
        <td><input type="text" class="form-input persian-num" name="other_banks[${otherBankIndex}][card]" placeholder="شماره کارت"></td>
        <td><input type="text" class="form-input persian-num" name="other_banks[${otherBankIndex}][sheba]" placeholder="شبا"></td>
        <td><button type="button" class="remove-bank-modal-row" onclick="this.closest('tr').remove()">✕</button></td>
    `;
    tbody.appendChild(tr);
    otherBankIndex++;
}
function renderOtherBanksTable() {
    // اگر می‌خواهی داده‌های قبلی را لود کنی، اینجا پیاده کن
}
function saveOtherBanks() {
    // مقدارها را می‌گذاری توی فرم اصلی (کپی می‌کنی)
    let tbody = document.querySelector('#otherBanksTable tbody');
    let newRows = [];
    tbody.querySelectorAll('tr').forEach(tr => {
        let tds = tr.querySelectorAll('input');
        let row = [];
        tds.forEach(td => row.push(td.value));
        newRows.push(row);
    });
    // به فرم اصلی هم اضافه کن (همزمان در #bankAccounts)
    let container = document.getElementById('bankAccounts');
    newRows.forEach(row => {
        const div = document.createElement('div');
        div.className = 'flex gap-4 mb-2 bank-row';
        div.innerHTML = `
            <input type="text" name="banks[${bankRowIndex}][bank]" value="${row[0] || ''}" placeholder="بانک" class="form-input flex-1">
            <input type="text" name="banks[${bankRowIndex}][account]" value="${row[1] || ''}" placeholder="شماره حساب" class="form-input flex-1 persian-num">
            <input type="text" name="banks[${bankRowIndex}][card]" value="${row[2] || ''}" placeholder="شماره کارت" class="form-input flex-1 persian-num">
            <input type="text" name="banks[${bankRowIndex}][sheba]" value="${row[3] || ''}" placeholder="شبا" class="form-input flex-1 persian-num">
            <button type="button" class="remove-bank-row bg-red-500 text-white px-2 py-1 rounded" onclick="removeBankRow(this)">حذف</button>
        `;
        container.appendChild(div);
        bankRowIndex++;
    });
    tbody.innerHTML = "";
    closeBankModal();
    Swal.fire({ icon: 'success', title: 'حساب‌های بانکی جدید اضافه شد', timer: 1000, showConfirmButton: false });
}

// اعتبارسنجی سمت کلاینت و SweetAlert2 (نام، نوع شخص، تاریخ عضویت)
document.getElementById('personForm').addEventListener('submit', function(e) {
    const firstName = document.getElementById('first_name').value.trim();
    const type = document.getElementById('type').value;
    const joinDate = document.getElementById('join_date').value;
    if (!firstName || !type || !joinDate) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'خطا',
            text: 'وارد کردن نام، نوع شخص و تاریخ عضویت الزامی است!'
        });
        return false;
    }
});

// ------------------------- //
// دسته‌بندی AJAX و پاپ‌آپ //
let catModal = document.getElementById('catModal');
let catListDiv = document.getElementById('catList');
let catLoading = false;
let selectedCatId = '';
let selectedCatTitle = '';

window.openCatModal = function() {
    catModal.style.display = "flex";
    catListDiv.innerHTML = '<div style="text-align:center;color:#888">در حال بارگذاری...</div>';
    document.getElementById('catSearchInput').value = '';
    fetchCategories('');
    setTimeout(() => {document.getElementById('catSearchInput').focus();}, 350);
}
window.closeCatModal = function() {
    catModal.style.display = "none";
}
document.getElementById('catSearchInput').addEventListener('input', function() {
    fetchCategories(this.value);
});
function fetchCategories(query) {
    if(catLoading) return;
    catLoading = true;
    fetch(`/categories/ajax-search?q=${encodeURIComponent(query||'')}`)
        .then(res => res.json())
        .then(data => {
            catListDiv.innerHTML = '';
            if(data.length === 0) {
                catListDiv.innerHTML = '<div style="text-align:center;color:#888">دسته‌بندی پیدا نشد.</div>';
            } else {
                data.forEach(cat => {
                    let div = document.createElement('div');
                    div.className = 'cat-item' + (cat.id == selectedCatId ? ' active' : '');
                    div.innerHTML = '<span>'+cat.title+'</span>';
                    div.onclick = function() {
                        selectedCatId = cat.id;
                        selectedCatTitle = cat.title;
                        document.getElementById('category_id').value = cat.id;
                        document.getElementById('category_title_view').value = cat.title;
                        closeCatModal();
                    };
                    catListDiv.appendChild(div);
                });
            }
            catLoading = false;
        });
}
window.createCategory = function() {
    var title = document.getElementById('newCatTitle').value.trim();
    if(!title) {
        Swal.fire({ icon: 'error', title: 'خطا', text: 'عنوان دسته‌بندی را وارد کنید.' });
        return;
    }
    fetch('/categories/ajax-create', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
        body: JSON.stringify({title})
    })
    .then(res => res.json())
    .then(data => {
        if(data && data.id && data.title) {
            selectedCatId = data.id;
            selectedCatTitle = data.title;
            document.getElementById('category_id').value = data.id;
            document.getElementById('category_title_view').value = data.title;
            document.getElementById('newCatTitle').value = '';
            closeCatModal();
            Swal.fire({ icon: 'success', title: 'دسته‌بندی جدید ثبت شد', timer: 1300, showConfirmButton: false });
        } else {
            Swal.fire({ icon: 'error', title: 'خطا', text: data.message || 'ثبت دسته‌بندی انجام نشد.' });
        }
    });
}

// ------------------------- //
// شمسی سازی تاریخ‌ها
$(function() {
    $('#birthday').persianDatepicker({ format: 'YYYY/MM/DD', initialValue: false, observer: true });
    $('#marriage_date').persianDatepicker({ format: 'YYYY/MM/DD', initialValue: false, observer: true });
    $('#join_date').persianDatepicker({ format: 'YYYY/MM/DD', initialValue: false, observer: true });
});
window.setTodayJalali = function(id) {
    var today = new persianDate().format('YYYY/MM/DD');
    $('#' + id).val(today);
}

// نوتیفیکیشن موفقیت ذخیره (در صورت نیاز)
@if(session('success'))
Swal.fire({ icon: 'success', title: 'موفق', text: '{{ session('success') }}' });
@endif
@if($errors->any())
Swal.fire({ icon: 'error', title: 'خطا', html: '{!! implode("<br>", $errors->all()) !!}' });
@endif
</script>
@endsection
