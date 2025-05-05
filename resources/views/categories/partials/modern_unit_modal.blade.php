<div class="modal-popup-bg" id="modal-unit" style="display:none;">
    <div class="modal-popup">
        <button class="close-btn" type="button">&times;</button>
        <h5 class="mb-3 fw-bold">مدیریت واحدها</h5>
        <div class="mb-2 d-flex">
            <input type="text" id="unit-new" class="form-control" placeholder="افزودن واحد جدید...">
            <button class="btn btn-success ms-2" onclick="addPopupItem('unit')"><i class="fa fa-plus"></i> افزودن</button>
        </div>
        <div class="table-responsive">
            <table class="table modal-popup-table">
                <thead>
                    <tr>
                        <th>عنوان واحد</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody id="unit-list"></tbody>
            </table>
        </div>
    </div>
</div>
