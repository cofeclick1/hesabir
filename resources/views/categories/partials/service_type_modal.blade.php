<div class="modal fade" id="modal-serviceType" tabindex="-1" aria-labelledby="serviceTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="serviceTypeModalLabel">مدیریت نوع خدمت</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group mb-3" id="serviceTypeList">
          @foreach($serviceTypes as $st)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>{{ $st->title }}</span>
              <span>
                <button class="btn btn-sm btn-warning me-1 edit-serviceType-btn" data-id="{{ $st->id }}"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-danger delete-serviceType-btn" data-id="{{ $st->id }}"><i class="fa fa-trash"></i></button>
              </span>
            </li>
          @endforeach
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
