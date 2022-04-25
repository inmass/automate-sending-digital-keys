let form = document.getElementById('add_key_type');
form.addEventListener('submit', function (e) {
    document.getElementById('error').innerHTML = "";
    e.preventDefault();
    let title = document.getElementById('title').value;
    let formData = new FormData(form);
    formData.append('form_type', 'add_key_type');
    formData.append('title', title);
    jQuery.ajax({
        type: 'POST',
        data: formData,
        url: post_url,
        processData: false,
        contentType: false,
        success: function (data) {
            console.log(data);
            if (data.includes('success')) {
                window.location.href = 'admin.php?page=keys-types';
            } else {
                document.getElementById('error').innerHTML = data;
            }
        }
    });
});