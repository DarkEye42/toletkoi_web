// Image Uploader Script
document.addEventListener('DOMContentLoaded', () => {
    const dropArea = document.getElementById('dropArea');
    const imagePreview = document.getElementById('imagePreview');
    const selectedItemsTitle = document.getElementById('selectedItemsTitle');

    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('drag-over');
    });

    dropArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropArea.classList.remove('drag-over');
    });

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        handleFiles(files);
    });

    const fileInput = document.getElementById('fileInput');
    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        imagePreview.style.display = 'inline-flex';
        selectedItemsTitle.style.display = 'flex';
        handleFiles(files);
    });

    function handleFiles(files) {
        const imageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        const validFiles = Array.from(files).filter(file => imageTypes.includes(file.type));

        if (validFiles.length + imagePreview.children.length <= 6) {
            for (const file of validFiles) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const image = new Image();
                    image.src = event.target.result;
                    image.width = 90;
                    image.height = 90;

                    const removeButton = document.createElement('button');
                    removeButton.innerHTML = '<i class="bi bi-trash"></i>';
                    removeButton.classList.add('remove-button');
                    removeButton.addEventListener('click', () => removeImage(image));

                    const previewImage = document.createElement('div');
                    previewImage.classList.add('preview-image');
                    previewImage.appendChild(image);
                    previewImage.appendChild(removeButton);

                    imagePreview.appendChild(previewImage);
                };
                reader.readAsDataURL(file);
            }
        } else {
            alert('You can only select up to 6 images.');
        }
    }

    function removeImage(image) {
        const previewImage = image.parentElement;
        imagePreview.removeChild(previewImage);
    }
});  