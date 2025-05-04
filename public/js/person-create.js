// مدیریت تب‌ها
document.querySelectorAll('.tab-header li').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.tab-header li').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('.tab-panel').forEach(panel => {
            panel.classList.remove('active');
            if (panel.dataset.tab === this.dataset.tab) panel.classList.add('active');
        });
    });
});

// سوییچ کد حسابداری
const autoCodeSwitch = document.getElementById('autoCodeSwitch');
const accountCode = document.getElementById('account_code');
const autoCodeHint = document.getElementById('autoCodeHint');
autoCodeSwitch.addEventListener('change', function() {
    if(this.checked) {
        accountCode.readOnly = true;
        autoCodeHint.innerText = 'تولید خودکار کد';
        // درخواست ajax برای دریافت آخرین کد (در پروژه اصلی باید مسیر زیر را تنظیم کنی)
        fetch('persons/latest-code')
            .then(res => res.json())
            .then(data => {
                let code = parseInt(data.code) + 1;
                accountCode.value = code.toString().padStart(4, '0');
            });
    } else {
        accountCode.readOnly = false;
        autoCodeHint.innerText = 'کد شخصی';
    }
});

// آپلود تصویر پروفایل
document.getElementById('avatar').addEventListener('change', function(e){
    if(this.files[0]){
        let reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('profilePreview').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    }
});

// افزودن حساب بانکی
let bankIdx = 1;
document.getElementById('addBankBtn').addEventListener('click', function(){
    let container = document.getElementById('bankAccounts');
    let template = `
        <div class="flex gap-4 mb-2">
            <input type="text" name="banks[${bankIdx}][bank]" placeholder="بانک" class="form-input flex-1">
            <input type="text" name="banks[${bankIdx}][account]" placeholder="شماره حساب" class="form-input flex-1">
            <input type="text" name="banks[${bankIdx}][card]" placeholder="شماره کارت" class="form-input flex-1">
            <input type="text" name="banks[${bankIdx}][sheba]" placeholder="شبا" class="form-input flex-1">
        </div>`;
    container.insertAdjacentHTML('beforeend', template);
    bankIdx++;
});

// دسته‌بندی: نمایش و افزودن
document.getElementById('addCategoryBtn').addEventListener('click', function() {
    document.getElementById('categoryModal').classList.add('show');
});
function closeCategoryModal() {
    document.getElementById('categoryModal').classList.remove('show');
}
function submitCategory() {
    let title = document.getElementById('newCategoryTitle').value.trim();
    if(!title) return;
    // باید ajax به سرور بزنی و دسته‌بندی جدید اضافه کنی (در پروژه اصلی مسیر را تنظیم کن)
    fetch('persons/add-category', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value},
        body: JSON.stringify({title: title})
    })
    .then(res => res.json())
    .then(data => {
        if(data.success && data.category){
            let sel = document.getElementById('category_id');
            let option = new Option(data.category.title, data.category.id, true, true);
            sel.add(option);
        }
        closeCategoryModal();
    });
}

// انتخاب امروز برای تاریخ عضویت
window.setToday = function(inputId){
    var today = new Date().toISOString().slice(0, 10);
    document.getElementById(inputId).value = today;
};
