// --- سوییچ تب نوع دسته‌بندی ---
document.querySelectorAll('.switch-cat-type input[type="radio"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.cat-section').forEach(function(sec){ sec.classList.remove('active'); });
        if(this.value === "person") document.getElementById('cat-person').classList.add('active');
        else if(this.value === "product") document.getElementById('cat-product').classList.add('active');
        else if(this.value === "service") document.getElementById('cat-service').classList.add('active');
    });
});

// --- تصویر (پیش‌نمایش) برای هر فرم ---
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

// --- کد خودکار و سوییچ ---
const codeMap = {
    'person': {prefix: 'per-', start: 1, digits: 3, input: 'person-code', switch: 'person-autocode'},
    'product': {prefix: 'cat-pr', start: 1001, digits: 4, input: 'product-code', switch: 'product-autocode'},
    'service': {prefix: 'cat-ser', start: 1001, digits: 4, input: 'service-code', switch: 'service-autocode'},
};
Object.entries(codeMap).forEach(([key, val]) => {
    const sw = document.getElementById(val.switch);
    const codeInput = document.getElementById(val.input);
    sw.addEventListener('change', function(){
        if(this.checked){
            codeInput.value = val.prefix + (val.start.toString().padStart(val.digits, '0'));
            codeInput.readOnly = true;
        }else{
            codeInput.readOnly = false;
        }
    });
    // مقدار اولیه
    codeInput.value = val.prefix + (val.start.toString().padStart(val.digits, '0'));
    codeInput.readOnly = sw.checked;
});

// --- مدیریت پاپ‌آپ‌ها و داده‌های انتخابی با AJAX ---
const optionTypes = {
    personType: {type: 'person_type', selectId: 'person-type-select', modalId: 'modal-personType', listId: 'personType-list', inputId: 'personType-new'},
    unit: {type: 'unit', selectId: 'unit-select', modalId: 'modal-unit', listId: 'unit-list', inputId: 'unit-new'},
    serviceType: {type: 'service_type', selectId: 'service-type-select', modalId: 'modal-serviceType', listId: 'serviceType-list', inputId: 'serviceType-new'},
};
let popupData = { personType: [], unit: [], serviceType: [] };

function openModal(type){
    fetchCategoryOptions(type, function(){
        document.getElementById(optionTypes[type].modalId).style.display = 'flex';
    });
}
function closeModal(type){
    document.getElementById(optionTypes[type].modalId).style.display = 'none';
}
function fetchCategoryOptions(type, cb){
    const info = optionTypes[type];
    fetch(`/category-options?type=${info.type}`)
        .then(res => res.json())
        .then(data => {
            popupData[type] = data;
            renderPopupList(type);
            updateSelect(type);
            if(cb) cb();
        });
}
function renderPopupList(type){
    let list = popupData[type];
    let tbody = document.getElementById(optionTypes[type].listId);
    tbody.innerHTML = '';
    list.forEach((item, i)=>{
        tbody.innerHTML += `<tr>
            <td><input type="text" value="${item.title}" class="form-control" onchange="editPopupItem('${type}',${item.id},this.value)"></td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="removePopupItem('${type}',${item.id})"><i class="fa fa-trash"></i></button>
            </td>
        </tr>`;
    });
}
function addPopupItem(type){
    const info = optionTypes[type];
    let input = document.getElementById(info.inputId);
    let val = input.value.trim();
    if(!val) return;
    fetch('/category-options', {
        method: 'POST',
        headers: {'Content-Type':'application/json', 'X-CSRF-TOKEN':window.csrfToken},
        body: JSON.stringify({type: info.type, title: val})
    })
    .then(res=>res.json())
    .then(option=>{
        input.value = '';
        fetchCategoryOptions(type);
    });
}
function editPopupItem(type, id, value){
    fetch(`/category-options/${id}`, {
        method: 'PUT',
        headers: {'Content-Type':'application/json', 'X-CSRF-TOKEN':window.csrfToken},
        body: JSON.stringify({title: value})
    }).then(()=>fetchCategoryOptions(type));
}
function removePopupItem(type, id){
    fetch(`/category-options/${id}`, {
        method: 'DELETE',
        headers: {'X-CSRF-TOKEN':window.csrfToken}
    }).then(()=>fetchCategoryOptions(type));
}
function updateSelect(type){
    const info = optionTypes[type];
    let sel = document.getElementById(info.selectId);
    if(!sel) return;
    sel.innerHTML = '';
    popupData[type].forEach(item=>{
        let opt = document.createElement('option');
        opt.value = item.title;
        opt.text = item.title;
        sel.appendChild(opt);
    });
}

// لود اولیه گزینه‌ها در صفحه (در صورت نیاز)
document.addEventListener('DOMContentLoaded', function(){
    Object.keys(optionTypes).forEach(type => fetchCategoryOptions(type));
});

// CSRF توکن را برای JS ست می‌کنیم
window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
