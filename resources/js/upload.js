document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);

        axios.post('/upload', formData)
            .then(response => {
                alert('Upload successful!');
                // Optionally, handle response data here
            })
            .catch(error => {
                const message = error?.response?.data?.error || "An error occurred";
                alert(message);
            });
    });
});