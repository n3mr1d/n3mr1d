
window.addEventListener('DOMContentLoaded', function() {
    // Preview images before upload
    const imageInput = document.getElementById('project_images');
    const imagePreview = document.getElementById('imagePreview');
    
    imageInput.addEventListener('change', function() {
        imagePreview.innerHTML = '';
        
        if (this.files.length > 0) {
            const file = this.files[0]; 
            if (file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const div = document.createElement('div');
                    div.className = 'preview-item';
                    div.innerHTML = `
                        <img src="${event.target.result}" alt="Preview" class="preview-image">
                        <span class="remove-preview">&times;</span>
                    `;
                    imagePreview.appendChild(div);
                }
                reader.readAsDataURL(file);
            }
        }
    });

});