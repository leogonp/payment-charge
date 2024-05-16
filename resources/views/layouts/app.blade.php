<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Charge - Importar</title>
    <!-- Inclua o CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('uploadForm');
        const uploadButton = document.getElementById('uploadButton');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            buttonText.classList.add('d-none');
            buttonSpinner.classList.remove('d-none');
            uploadButton.disabled = true;

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                    'Accept': 'application/json'
                }
            }).then(response => response.json())
                .then(data => {
                    buttonText.classList.remove('d-none');
                    buttonSpinner.classList.add('d-none');
                    uploadButton.disabled = false;

                    if (data.message) {
                        alert(data.message);
                    }
                    location.reload();
                }).catch(error => {
                buttonText.classList.remove('d-none');
                buttonSpinner.classList.add('d-none');
                uploadButton.disabled = false;

                alert('Erro ao enviar arquivo.');
                console.error('Error:', error);
            });
        });
    });
</script>
</body>
</html>
