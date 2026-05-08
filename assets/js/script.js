document.addEventListener('DOMContentLoaded', function () {
    const profileInput = document.getElementById('profileImageInput');
    const profilePreview = document.getElementById('profilePreview');

    if (profileInput && profilePreview) {
        profileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) {
                return;
            }
            const reader = new FileReader();
            reader.onload = function (event) {
                profilePreview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });
    }
});
