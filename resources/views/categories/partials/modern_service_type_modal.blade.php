<div class="modal-popup-bg" id="modal-serviceType" style="display:none;">
    <div class="modal-popup">
        <button class="close-btn" type="button">&times;</button>
        <h5 class="mb-3 fw-bold">مدیریت انواع خدمت</h5>
        <div class="mb-2 d-flex">
            <input type="text" id="serviceType-new" class="form-control" placeholder="افزودن نوع جدید...">
            <button class="btn btn-success ms-2" onclick="addPopupItem('serviceType')"><i class="fa fa-plus"></i> افزودن</button>
        </div>
        <div class="table-responsive">
            <table class="table modal-popup-table">
                <thead>
                    <tr>
                        <th>عنوان نوع</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody id="serviceType-list"></tbody>
            </table>
        </div>
    </div>
</div>
