<div>
    <h1>Add new key type</h1>
    <form action="<?= plugin_dir_url( __FILE__ ); ?>post_data.php" method="post" id="add_key_type">
        <input type="hidden" name="form_type"  value="add_key_type">
        <label for="title">Title</label>
        <br>
        <input type="text" name="title" id="title" required>
        <br><br>
        <input type="submit" value="Add key">
    </form>
    <div id="error" style="color: red;"></div>
</div>


<script>

    let form = document.getElementById('add_key_type');
    form.addEventListener('submit', function(e) {
        document.getElementById('error').innerHTML = "";
        e.preventDefault();
        let title = document.getElementById('title').value;
        let formData = new FormData(form);
        formData.append('form_type', 'add_key_type');
        formData.append('title', title);
        jQuery.ajax({
            type:'POST',
            data:formData,
            url:'<?= plugin_dir_url( __FILE__ ); ?>post_data.php',
            processData: false,
            contentType: false,
            success:function(data) {
                console.log(data);
                if (data.includes('success')) {
                    window.location.href = 'admin.php?page=keys-types';
                } else {
                    document.getElementById('error').innerHTML = data;
                }
            }
        });
    });

</script>