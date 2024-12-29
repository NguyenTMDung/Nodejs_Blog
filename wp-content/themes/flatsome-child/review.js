
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function () {
            const previewContainer = document.getElementById('preview_' + this.id.split('_')[2]); // Tạo preview ID dựa trên product_id
            previewContainer.innerHTML = ''; // Xóa nội dung cũ

            const files = this.files;
            Array.from(files).forEach(file => {
                const fileReader = new FileReader();
                fileReader.onload = function (e) {
                    const fileURL = e.target.result;

                    // Tạo thẻ img hoặc video
                    let mediaElement;
                    if (file.type.startsWith('image/')) {
                        mediaElement = document.createElement('img');
                    } else if (file.type.startsWith('video/')) {
                        mediaElement = document.createElement('video');
                        mediaElement.controls = true; // Hiện nút điều khiển cho video
                    }
                    mediaElement.src = fileURL;
                    previewContainer.appendChild(mediaElement);
                };
                fileReader.readAsDataURL(file);
            });
        });
    });
});

