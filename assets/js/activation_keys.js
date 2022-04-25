// check if request came from keys types to filter by type
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

if (urlParams.get('to_redirect')) {
    console.log('redirecting');
    // redirect to add key page
    if (urlParams.get('to_redirect') == 'filter_by_key_type') {
        var templateUrl = get_url;
        jQuery.ajax({
            type:'GET',
            data:{
                page_type: 'activation_keys',
                search_query:urlParams.get('search_query'),
                search_by:'key_type'
            },
            url:templateUrl,
            success: function(value) {
                //console.log(value);
                jQuery('#content').html('');
                jQuery('#content').html(value);
            }
        })
    }
}
// check if request came from keys types to filter by type


jQuery('#search_by').change(function(){
    if (jQuery(this).val() == "") {
        jQuery('#search_query').attr('disabled', true);
    } else {
        jQuery('#search_query').attr('disabled', false);
    }
});

//searching script
jQuery('#search_query').on('keyup',function(){

    var templateUrl = get_url;
    // templateUrl+="get_data.php";
    //console.log($(this).val());
    jQuery.ajax({
        type:'GET',
        data:{
            page_type: 'activation_keys',
            search_query:jQuery("#search_query").val(),
            search_by:jQuery("#search_by").val()
        },
        url:templateUrl,
        success: function(value) {
            //console.log(value);
            jQuery('#content').html('');
            jQuery('#content').html(value);
        }
    })
})


function get_page(id)
{
    var templateUrl = get_url;
    //   templateUrl+="get_data.php";
    var search_query=jQuery("#search_query").val();
    var search_by=jQuery("#search_by").val();
    
    if(search_query==="")
    {
        search_query=null;
    }
    if(search_by==="")
    {
        search_by=null;
    }
    jQuery.ajax({
            type:'GET',
            data:{
                page_type: 'activation_keys',
                page_no:id,
                search_query:search_query,
                search_by:search_by
            },
            url:templateUrl,
            success: function(value) {
                //console.log(value);
                jQuery('#content').html('');
                jQuery('#content').html(value);
            }
    })
}


// functions to edit and save
function edit_key(id)
{
    let count_text = document.getElementById('key-count-text-'+id)
    let count_input = document.getElementById('key-count-input-'+id)
    let used_text = document.getElementById('key-used-text-'+id)
    let used_input = document.getElementById('key-used-input-'+id)

    let save_button = document.getElementById('save-button-'+id)
    let edit_button = document.getElementById('edit-button-'+id)
    let cancel_button = document.getElementById('cancel-button-'+id)

    count_text.style.display = 'none';
    count_input.style.display = 'block';
    used_text.style.display = 'none';
    used_input.style.display = 'block';

    edit_button.style.display = 'none';
    save_button.style.display = 'block';
    cancel_button.style.display = 'block';


}

function cancel_key(id)
{
    let count_text = document.getElementById('key-count-text-'+id)
    let count_input = document.getElementById('key-count-input-'+id)
    let used_text = document.getElementById('key-used-text-'+id)
    let used_input = document.getElementById('key-used-input-'+id)

    let save_button = document.getElementById('save-button-'+id)
    let edit_button = document.getElementById('edit-button-'+id)
    let cancel_button = document.getElementById('cancel-button-'+id)

    count_text.style.display = 'block';
    count_input.style.display = 'none';
    used_text.style.display = 'block';
    used_input.style.display = 'none';

    edit_button.style.display = 'block';
    save_button.style.display = 'none';
    cancel_button.style.display = 'none';

}

function save_key(id)
{

    let count_text = document.getElementById('key-count-text-'+id)
    let count_input = document.getElementById('key-count-input-'+id)
    let used_text = document.getElementById('key-used-text-'+id)
    let used_input = document.getElementById('key-used-input-'+id)
    let cancel_button = document.getElementById('cancel-button-'+id)

    if (count_input.value == "") {
        alert('Please enter key count (type in -1 to use it with no count limit)');
        return;
    }
    if (used_input.value == "") {
        alert('Please chose the state of the key');
        return;
    } else if (used_input.value == "0") {
        $used = 0;
    } else if (used_input.value == "1") {
        $used = 1;
    }

    let save_button = document.getElementById('save-button-'+id)
    let edit_button = document.getElementById('edit-button-'+id)

    console.log(count_input.value);
    console.log(used_input.value);
    console.log($used);


    count_input.style.display = 'none';
    used_input.style.display = 'none';
    save_button.style.display = 'none';


    let formData = new FormData();
    formData.append('form_type', 'edit_key');
    formData.append('key_id', id);
    formData.append('used', $used);
    formData.append('count', count_input.value);
    jQuery.ajax({
        type:'POST',
        data:formData,
        url:post_url,
        processData: false,
        contentType: false,
        success:function(data) {
            console.log(data);
            if (data.includes('success')) {
                alert('Key updated successfully');
            } else {
                document.getElementById('error').innerHTML = data;
            }
        }
    });

    count_text.innerText = count_input.value;

    if ($used == 0) {
        used_text.innerText = 'No';
        // set class name to parent of parent of used_text
        used_text.parentElement.parentElement.className = 'available_key';
        used_text.parentElement.parentElement.style = '';
    } else {
        used_text.innerText = 'Yes';
        used_text.parentElement.parentElement.className = 'used_key';
        used_text.parentElement.parentElement.style = 'background-color: #fad7d7;';
    }

    count_text.style.display = 'block';
    used_text.style.display = 'block';
    edit_button.style.display = 'block';
    cancel_button.style.display = 'none';

}