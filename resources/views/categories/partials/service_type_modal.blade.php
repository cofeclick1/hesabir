<div class="modal fade" id="serviceTypeModal" tabindex="-1" aria-labelledby="serviceTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="serviceTypeModalLabel">مدیریت نوع خدمات</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group mb-3" id="serviceTypeList">
          {{-- این قسمت با JS پر می‌شود --}}
        </ul>
        <div class="input-group">
          <input type="text" id="newServiceTypeInput" class="form-control" placeholder="افزودن نوع خدمت جدید">
          <button class="btn btn-success" type="button" id="addServiceTypeBtn">
            <i class="fa fa-plus"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
(function(){
  // مقدار اولیه را از select فرم اصلی بخوان
  function getInitialServiceTypes() {
    let opts = document.querySelectorAll('#cat-service select[name="service_type"] option');
    let arr = [];
    opts.forEach(o => {
      if (o.value && !arr.includes(o.textContent.trim())) arr.push(o.textContent.trim());
    });
    return arr;
  }
  let serviceTypes = getInitialServiceTypes();
  function renderServiceTypes() {
    const list = document.getElementById('serviceTypeList');
    list.innerHTML = '';
    serviceTypes.forEach((type, idx) => {
      const li = document.createElement('li');
      li.className = "list-group-item d-flex justify-content-between align-items-center";
      li.innerHTML = `
        <span>${type}</span>
        <span>
          <button class="btn btn-sm btn-warning me-1 edit-btn" data-idx="${idx}"><i class="fa fa-edit"></i></button>
          <button class="btn btn-sm btn-danger delete-btn" data-idx="${idx}"><i class="fa fa-trash"></i></button>
        </span>
      `;
      list.appendChild(li);
    });
    // به‌روزرسانی گزینه‌های select
    updateServiceTypeSelect();
  }
  function updateServiceTypeSelect() {
    const select = document.querySelector('#cat-service select[name="service_type"]');
    if (!select) return;
    const first = select.querySelector('option[value=""]');
    select.innerHTML = '';
    if (first) select.appendChild(first.cloneNode(true));
    serviceTypes.forEach(type => {
      let opt = document.createElement('option');
      opt.value = type;
      opt.textContent = type;
      select.appendChild(opt);
    });
  }
  document.addEventListener('DOMContentLoaded', renderServiceTypes);
  document.getElementById('addServiceTypeBtn').onclick = function() {
    const val = document.getElementById('newServiceTypeInput').value.trim();
    if(val && !serviceTypes.includes(val)) {
      serviceTypes.push(val);
      renderServiceTypes();
      document.getElementById('newServiceTypeInput').value = '';
    }
  };
  document.getElementById('serviceTypeList').onclick = function(e) {
    const idx = e.target.closest('button')?.dataset?.idx;
    if(typeof idx === "undefined") return;
    if(e.target.closest('.delete-btn')) {
      serviceTypes.splice(idx, 1);
      renderServiceTypes();
    } else if(e.target.closest('.edit-btn')) {
      const newVal = prompt("ویرایش نوع خدمت:", serviceTypes[idx]);
      if(newVal && !serviceTypes.includes(newVal)) {
        serviceTypes[idx] = newVal;
        renderServiceTypes();
      }
    }
  };
})();
</script>
