// function to show the preview of the template
function preview(element, key_type) {
    console.log(element);
    console.log(key_type);
    var template = document.getElementById(`${key_type}`).value;
    var preview = document.getElementById("preview_" + key_type);

    if (template.indexOf("'") != -1) {
        preview.innerHTML = "Please do not use single quotes (') in the text, it will break the email.";
    } else {
        preview.innerHTML = template;
    }

    preview.style.display = "block";

    // transform the element to hide the preview
    element.innerHTML = "Hide preview";
    element.className = "hide_preview_button";
    element.setAttribute("onClick", `hide_preview(this,'${key_type}')`);
}

// function to hide the preview of the template
function hide_preview(element, key_type) {
    var preview = document.getElementById("preview_" + key_type);
    preview.style.display = "none";

    // transform the element to show the preview
    element.innerHTML = "Preview template";
    element.className = "preview_button";
    element.setAttribute("onClick", `preview(this,'${key_type}')`);
}

let form = document.getElementById('add_templates_form');
form.addEventListener('submit', function (e) {
    e.preventDefault();

    let values = {};
    let inputs = document.getElementsByClassName('template_input');
    // check if the textinput value is different from the previous_value attribute
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value != inputs[i].getAttribute('previous_value')) {
            // check if the new value contains the placeholder ([THE_KEYS])
            if (inputs[i].value.indexOf('[THE_KEYS]') == -1) {
                // ask the user if they want to proceed
                if (!confirm(`The template for ${inputs[i].getAttribute('id')} does not contain the "[THE_KEYS]" placeholder. Do you want to proceed?`)) {
                    return;
                }
            }
            if (inputs[i].value.indexOf('[THE_PRODUCT]') == -1) {
                // ask the user if they want to proceed
                if (!confirm(`The template for ${inputs[i].getAttribute('id')} does not contain the "[THE_PRODUCT]" placeholder. Do you want to proceed?`)) {
                    return;
                }
            }
            let template = inputs[i].value
            values[inputs[i].getAttribute('id')] = template;
        }
    }

    console.log(values);
    // log length of values
    console.log(Object.keys(values).length);
    if (Object.keys(values).length > 0) {
        jQuery.ajax({
            url: post_url,
            type: 'POST',
            data: {
                "templates": values,
                "form_type": 'add_templates'
            },
            success: function (data) {
                console.log(data);
                if (data.includes('success')) {
                    alert('Successfully saved');
                    for (let i = 0; i < inputs.length; i++) {
                        inputs[i].setAttribute('previous_value', inputs[i].value);
                    }
                } else {
                    document.getElementById('error').innerHTML = data;
                }
            }
        });
    }
});