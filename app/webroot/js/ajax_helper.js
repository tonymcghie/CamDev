/**
 * Created by mgoo on 8/01/17.
 */

/**
 * This will do an ajax call that will replace the jquery object with whatever the ajax request resonds with
 * @param url
 * @param data
 * @param replaceid
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
function ajax_call_url(contoller, action, data, success_function){
    ajax_call_replace(make_url(contoller, action), data, success_function);
}

/**
 * Makes a url from a controller and action so it can be used in an ajax request
 * @param contoller
 * @param action
 * @returns {string}
 */
function make_url(contoller, action){
    return '/'+contoller+'/'+action;
}