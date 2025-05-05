<div class="modal fade" id="personTypeModal" tabindex="-1" aria-labelledby="personTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="personTypeModalLabel">مدیریت نوع شخص</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group mb-3" id="personTypeList"></ul>
        <div class="input-group">
          <input type="text" id="newPersonTypeInput" class="form-control" placeholder="افزودن نوع شخص جدید">
          <button class="btn btn-success" type="button" id="addPersonTypeBtn">
            <i class="fa fa-plus"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function loadPersonTypes() {
    fetch('/person-types')
        .then(res => res.json())
        .then(data => {
            window.personTypeList = data;
            renderPersonTypes();
        });
}
function renderPersonTypes() {
    const list = document.getElementById('personTypeList');
    list.innerHTML = '';
    if (!window.personTypeList) return;
    window.personTypeList.forEach((type, idx) => {
        const li = document.createElement('li');
        li.className = "list-group-item d-flex justify-content-between align-items-center";
        li.innerHTML = `
            <span>${type.title}</span>
            <span>
                <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="${type.id}"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="${type.id}"><i class="fa fa-trash"></i></button>
            </span>
        `;
        list.appendChild(li);
    });
    // آپدیت select اصلی
    const select = document.getElementById('personTypeSelect');
    if (select) {
        select.innerHTML = '<option value="">انتخاب کنید</option>';
        window.personTypeList.forEach(type => {
            let opt = document.createElement('option');
            opt.value = type.title;
            opt.textContent = type.title;
            select.appendChild(opt);
        });
    }
}

document.addEventListener('DOMContentLoaded', loadPersonTypes);

document.getElementById('addPersonTypeBtn').onclick = function() {
    const val = document.getElementById('newPersonTypeInput').value.trim();
    if(!val) return;
    fetch('/person-types', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
        body: JSON.stringify({ title: val })
    })
    .then(res => {
        if(!res.ok) {alert('خطا در افزودن نوع شخص'); return;}
        return res.json();
    })
    .then(() => {
        document.getElementById('newPersonTypeInput').value = '';
        loadPersonTypes();
    });
};

document.getElementById('personTypeList').onclick = function(e) {
    const id = e.target.closest('button')?.dataset?.id;
    if(!id) return;
    if(e.target.closest('.delete-btn')) {
        if(!confirm('آیا مطمئن هستید؟')) return;
        fetch(`/person-types/${id}`, {
            method: 'DELETE',
            headers: {'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}
        }).then(loadPersonTypes);
    } else if(e.target.closest('.edit-btn')) {
        const old = window.personTypeList.find(pt => pt.id == id);
        const newVal = prompt('ویرایش نوع شخص:', old.title);
        if(newVal && newVal !== old.title) {
            fetch(`/person-types/${id}`, {
                method: 'PUT',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
                body: JSON.stringify({ title: newVal })
            }).then(loadPersonTypes);
        }
    }
};
</script>
