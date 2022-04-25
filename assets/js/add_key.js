let form = document.getElementById('add_key');
form.addEventListener('submit', function (e) {
    document.getElementById('error').innerHTML = "";
    e.preventDefault();
    let key_type = document.getElementById('key_type').value;
    let activation_key = document.getElementById('activation_key').value;
    let key_count = document.getElementById('key_count').value;
    if (key_count == "") {
        key_count = null;
    }
    let is_microsoft_key_checked = document.getElementById('is_microsoft_key').checked;
    let is_microsoft_key;
    if (is_microsoft_key_checked) {
        is_microsoft_key = 1;
    } else {
        is_microsoft_key = 0;
    }
    let formData = new FormData(form);
    formData.append('form_type', 'add_key');
    formData.append('key_type', key_type);
    formData.append('activation_key', activation_key);
    formData.append('key_count', key_count);
    formData.append('is_microsoft_key', is_microsoft_key);
    jQuery.ajax({
        type: 'POST',
        data: formData,
        url: post_url,
        processData: false,
        contentType: false,
        success: function (data) {
            console.log(data);
            if (data.includes('success')) {
                window.location.href = 'admin.php?page=activation-keys';
            } else {
                document.getElementById('error').innerHTML = data;
            }
        }
    });
});