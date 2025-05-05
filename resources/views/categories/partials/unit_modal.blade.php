<div class="modal fade" id="modal-unit" tabindex="-1" aria-labelledby="unitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="unitModalLabel">مدیریت واحد اصلی</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group mb-3" id="unitList">
          @foreach($units as $unit)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>{{ $unit }}</span>
              <span>
                <button class="btn btn-sm btn-warning me-1 edit-unit-btn" data-value="{{ $unit }}"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-danger delete-unit-btn" data-value="{{ $unit }}"><i class="fa fa-trash"></i></button>
              </span>
            </li>
          @endforeach
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
