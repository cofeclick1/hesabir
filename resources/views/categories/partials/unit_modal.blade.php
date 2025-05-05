<div class="modal fade" id="unitModal" tabindex="-1" aria-labelledby="unitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="unitModalLabel">مدیریت واحد اصلی</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group mb-3" id="unitList">
          {{-- این قسمت با JS پر می‌شود --}}
        </ul>
        <div class="input-group">
          <input type="text" id="newUnitInput" class="form-control" placeholder="افزودن واحد جدید">
          <button class="btn btn-success" type="button" id="addUnitBtn">
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
  function getInitialUnits() {
    let opts = document.querySelectorAll('#cat-product select[name="unit"] option');
    let arr = [];
    opts.forEach(o => {
      if (o.value && !arr.includes(o.textContent.trim())) arr.push(o.textContent.trim());
    });
    return arr;
  }
  let units = getInitialUnits();
  function renderUnits() {
    const list = document.getElementById('unitList');
    list.innerHTML = '';
    units.forEach((unit, idx) => {
      const li = document.createElement('li');
      li.className = "list-group-item d-flex justify-content-between align-items-center";
      li.innerHTML = `
        <span>${unit}</span>
        <span>
          <button class="btn btn-sm btn-warning me-1 edit-btn" data-idx="${idx}"><i class="fa fa-edit"></i></button>
          <button class="btn btn-sm btn-danger delete-btn" data-idx="${idx}"><i class="fa fa-trash"></i></button>
        </span>
      `;
      list.appendChild(li);
    });
    // به‌روزرسانی گزینه‌های select
    updateUnitSelect();
  }
  function updateUnitSelect() {
    const select = document.querySelector('#cat-product select[name="unit"]');
    if (!select) return;
    const first = select.querySelector('option[value=""]');
    select.innerHTML = '';
    if (first) select.appendChild(first.cloneNode(true));
    units.forEach(unit => {
      let opt = document.createElement('option');
      opt.value = unit;
      opt.textContent = unit;
      select.appendChild(opt);
    });
  }
  document.addEventListener('DOMContentLoaded', renderUnits);
  document.getElementById('addUnitBtn').onclick = function() {
    const val = document.getElementById('newUnitInput').value.trim();
    if(val && !units.includes(val)) {
      units.push(val);
      renderUnits();
      document.getElementById('newUnitInput').value = '';
    }
  };
  document.getElementById('unitList').onclick = function(e) {
    const idx = e.target.closest('button')?.dataset?.idx;
    if(typeof idx === "undefined") return;
    if(e.target.closest('.delete-btn')) {
      units.splice(idx, 1);
      renderUnits();
    } else if(e.target.closest('.edit-btn')) {
      const newVal = prompt("ویرایش واحد:", units[idx]);
      if(newVal && !units.includes(newVal)) {
        units[idx] = newVal;
        renderUnits();
      }
    }
  };
})();
</script>
