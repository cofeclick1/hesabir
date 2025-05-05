<div class="modal fade" id="modal-personType" tabindex="-1" aria-labelledby="personTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="personTypeModalLabel">مدیریت نوع اشخاص</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group mb-3" id="personTypeList">
          @foreach($personTypes as $pt)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>{{ $pt->title }}</span>
              <span>
                <button class="btn btn-sm btn-warning me-1 edit-personType-btn" data-id="{{ $pt->id }}"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-danger delete-personType-btn" data-id="{{ $pt->id }}"><i class="fa fa-trash"></i></button>
              </span>
            </li>
          @endforeach
        </ul>
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
