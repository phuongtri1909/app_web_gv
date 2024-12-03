<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .preview-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin: 5px;
        }
    </style>
</head>
<body>
    <input type="file" id="file-input" multiple>
    <div id="preview-container"></div>

    <script>
        document.getElementById('file-input').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = ''; // Clear previous images

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('preview-img');
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
</body>
</html>