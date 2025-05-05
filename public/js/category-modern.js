// --- مدیریت تب‌ها و بخش‌ها ---
document.addEventListener('DOMContentLoaded', function () {
    // سوییچ تب
    const tabs = document.querySelectorAll('.tab-header .tab-btn');
    tabs.forEach(btn => {
        btn.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.cat-section').forEach(sec => sec.classList.remove('active'));
            document.getElementById('cat-' + this.dataset.tab).classList.add('active');
        });
    });

    // لودر سراسری
    function showLoader() { document.getElementById('global-loader').style.display = 'flex'; }
    function hideLoader() { document.getElementById('global-loader').style.display = 'none'; }

    // --- مدیریت لیست دسته‌بندی‌ها ---
    const types = ['person', 'product', 'service'];
    types.forEach(type => {
        loadCategoryList(type);

        // جستجو زنده
        document.getElementById('search-' + type).addEventListener('input', function() {
            loadCategoryList(type, this.value);
        });
        // دکمه بروزرسانی
        document.getElementById('refresh-' + type + '-list').addEventListener('click', function() {
            document.getElementById('search-' + type).value = '';
            loadCategoryList(type, '');
        });
    });

    // --- بارگذاری اولیه آمار badge ---
    types.forEach(type => updateBadge(type, 0));

    // بارگذاری لیست دسته‌بندی‌ها
    function loadCategoryList(type, search = '') {
        showLoader();
        fetch(`/categories/api/list?type=${type}&search=${encodeURIComponent(search)}`)
            .then(res => res.json())
            .then(data => {
                renderTable(type, data.list);
                updateBadge(type, data.count);
                hideLoader();
            })
            .catch(() => {
                renderTable(type, []);
                hideLoader();
            });
    }

    // رندر جدول دسته‌بندی‌ها
    function renderTable(type, list) {
        const tbody = document.getElementById('table-' + type).querySelector('tbody');
        const alert = document.getElementById('no-' + type + '-alert');
        tbody.innerHTML = '';
        if (!list.length) {
            alert.style.display = 'block';
            return;
        }
        alert.style.display = 'none';
        for (let cat of list) {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td><img src="${cat.image_url || '/images/category-default.png'}" alt="تصویر" style="width:42px;height:42px;border-radius:50%;object-fit:cover;"></td>
                <td class="editable-cell" data-id="${cat.id}" data-type="title">${cat.title}</td>
                <td>${cat.code}</td>
                <td>${cat.extra || '-'}</td>
                <td>${cat.active ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-times-circle"></i>'}</td>
                <td class="category-action-btns">
                    <button class="btn btn-success btn-sm edit-btn" data-id="${cat.id}" data-type="${type}"><i class="fa fa-pen"></i></button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${cat.id}" data-type="${type}"><i class="fa fa-trash"></i></button>
                </td>
            `;
            tbody.appendChild(row);
        }
        // مدیریت عملیات ویرایش و حذف
        tbody.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                editCategory(this.dataset.type, this.dataset.id);
            });
        });
        tbody.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('آیا مطمئن هستید؟')) deleteCategory(this.dataset.type, this.dataset.id);
            });
        });
        // ویرایش اینلاین
        tbody.querySelectorAll('.editable-cell').forEach(cell => {
            cell.addEventListener('dblclick', function() {
                startInlineEdit(this, this.dataset.type, this.dataset.id);
            });
        });
    }

    // به‌روزرسانی badge تب
    function updateBadge(type, count) {
        document.getElementById('badge-' + type).innerText = count;
    }

    // ویرایش دسته‌بندی (نمایش مدال و ...)
    function editCategory(type, id) {
        // می‌توانید مدال ویرایش باز کنید یا همان فرم را با داده‌های انتخابی پر کنید
        alert('عملیات ویرایش (' + type + '): ' + id + '\n(در نسخه کامل، فرم پر می‌شود)');
    }

    // حذف دسته‌بندی
    function deleteCategory(type, id) {
        showLoader();
        fetch(`/categories/api/delete/${id}`, {method: 'DELETE', headers: {'X-CSRF-TOKEN': getCsrf()}})
            .then(res => res.json())
            .then(() => {
                loadCategoryList(type);
                showAlert('حذف با موفقیت انجام شد', 'success');
                hideLoader();
            }).catch(() => {
                showAlert('خطا در حذف!', 'danger');
                hideLoader();
            });
    }

    // ویرایش اینلاین (تک‌سلولی)
    function startInlineEdit(cell, type, id) {
        const oldVal = cell.innerText;
        cell.innerHTML = `<input type="text" class="form-control" value="${oldVal}" style="min-width:120px;">`;
        const input = cell.querySelector('input');
        input.focus();
        input.select();
        input.addEventListener('blur', function() {
            let val = input.value.trim();
            if (val && val !== oldVal) {
                showLoader();
                fetch(`/categories/api/update/${id}`, {
                    method: 'PUT',
                    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':getCsrf()},
                    body: JSON.stringify({title: val})
                })
                .then(res => res.json())
                .then(() => {
                    cell.innerText = val;
                    showAlert('ویرایش با موفقیت انجام شد', 'success');
                    hideLoader();
                }).catch(() => {
                    cell.innerText = oldVal;
                    showAlert('خطا در ویرایش!', 'danger');
                    hideLoader();
                });
            } else {
                cell.innerText = oldVal;
            }
        });
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') input.blur();
            if (e.key === 'Escape') { input.value = oldVal; input.blur(); }
        });
    }

    // نمایش اعلان
    function showAlert(msg, type) {
        let box = document.createElement('div');
        box.className = 'alert alert-' + type;
        box.innerHTML = msg;
        document.body.appendChild(box);
        box.style.display = 'block';
        setTimeout(() => { box.style.opacity = 0; setTimeout(()=>box.remove(), 700); }, 2500);
    }

    // دریافت csrf
    function getCsrf() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    // --- مدیریت تصویر (درگ/دراپ/پیش‌نمایش) برای هر فرم ---
    ['person', 'product', 'service'].forEach(function(type) {
        const drop = document.getElementById(type + '-cat-dropzone');
        const input = document.getElementById(type + '-cat-img-input');
        const img = document.getElementById(type + '-cat-img-preview');
        drop.addEventListener('click', e => input.click());
        drop.addEventListener('dragover', e => { e.preventDefault(); drop.classList.add('dragover'); });
        drop.addEventListener('dragleave', e => drop.classList.remove('dragover'));
        drop.addEventListener('drop', e => {
            e.preventDefault();
            drop.classList.remove('dragover');
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                input.files = e.dataTransfer.files;
                previewImg(input, img);
            }
        });
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) previewImg(this, img);
        });
    });
    function previewImg(input, img) {
        let reader = new FileReader();
        reader.onload = function(e) { img.src = e.target.result; };
        reader.readAsDataURL(input.files[0]);
    }

    // --- مدیریت مدال‌های انواع (شخص، واحد، خدمت) ---
    // مشابه کد JS category-advanced.js با قابلیت مدیریت AJAX و ویرایش سریع

    // مثال: باز کردن مدال نوع شخص
    document.getElementById('manage-person-type-btn').onclick = function() {
        document.getElementById('modal-personType').style.display = 'flex';
    }
    // بستن مدال
    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.onclick = function() {
            this.closest('.modal-popup-bg').style.display = 'none';
        }
    });

    // ... ادامه مدیریت مدال‌ها و گزینه‌ها (AJAX و تعامل کامل) ...
    // این بخش را می‌توان با کد category-advanced.js ترکیب کرد و تا بیش از ۵۰۰ خط توسعه داد.

    // اعتبارسنجی زنده فرم‌ها و ذخیره سریع (در صورت نیاز)
    // مدیریت ذخیره خودکار، نمایش وضعیت، و امکانات بیشتر...

});
