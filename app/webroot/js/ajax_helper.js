/**
 * Created by mgoo on 8/01/17.
 */

/**
 * This will do an ajax call that will replace the jquery object with whatever the ajax request resonds with
 * @param url url string
 * @param data object
 * @param replace Jquery object
 */
function ajax_call_replace(url, data, replace){
    $.ajax({
        url: url,
        data: data,
        success: function(response){
            replace.html(response);
        },
        error: function(error, message){
            console.log('There was an ajax error: ' + message);
        }
    })
}

function ajax_call_replace_url(contoller, action, data, replace){
    ajax_call_replace(make_url(contoller, action), data, replace);
}

/**
 * This will do an ajax request and execute the success function when it returns successfully
 * @param url
 * @param data
 * @param success_function
 */
function ajax_call(url, data, success_function){
    $.ajax({
        url: url,
        data: data,
        success: success_function,
        error: function(error, message){
            console.log('There was an ajax error: ' + message);
        }
    })
}

/**
 * This will load a page by passing no data
 * @param url
 * @param load_to
 */
function load_page(url, load_to){
    ajax_call_replace(url, '', load_to);
}


