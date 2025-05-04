document.addEventListener('DOMContentLoaded', function () {
    // تصویر دسته‌بندی - درگ و دراپ و ویرایش
    const dropzone = document.getElementById('category-dropzone');
    const imgInput = document.getElementById('category-img-input');
    const imgPreview = document.getElementById('category-img-preview');

    dropzone.addEventListener('click', e => {
        imgInput.click();
    });
    dropzone.addEventListener('dragover', e => {
        e.preventDefault();
        dropzone.classList.add('dragover');
    });
    dropzone.addEventListener('dragleave', e => {
        dropzone.classList.remove('dragover');
    });
    dropzone.addEventListener('drop', e => {
        e.preventDefault();
        dropzone.classList.remove('dragover');
        if(e.dataTransfer.files && e.dataTransfer.files[0]) {
            imgInput.files = e.dataTransfer.files;
            showPreview(e.dataTransfer.files[0]);
        }
    });
    imgInput.addEventListener('change', function(e) {
        if(this.files && this.files[0]) {
            showPreview(this.files[0]);
        }
    });
    function showPreview(file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            imgPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
