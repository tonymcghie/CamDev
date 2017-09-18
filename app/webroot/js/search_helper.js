/**
 * Created by mgoo on 27/02/17.
 */
let base_search_set;
let num_boxes = 0;
let animation_speed = 400;

/**
 * Sets up the functionality for the search forms
 */
function set_listeners(){
    base_search_set = $('#search-set').detach().removeAttr('id').clone();
    get_new_search_set().insertBefore($('#action-buttons').closest('div.form-group'));
}

/**
 * Adds a new search set to the form
 */
function add_search_set() {
    let div = $('#action-buttons').closest('div.form-group');
    let new_search_set = get_new_search_set();
    new_search_set.hide();
    new_search_set.insertBefore(div);
    new_search_set.slideDown(animation_speed);
}

/**
 * clones the base search set and adds the index to the end of the name so they can be submitted properly
 * @return JQuery the search set element
 */
function get_new_search_set(){
    let search_set = base_search_set.clone();
    search_set.find('select, input, button').each(function(){
        $(this).attr('name', $(this).attr('name') + '[' + num_boxes + ']');
    });
    num_boxes++;
    return search_set;
}

/**
 * This will remove the closest search set to the element passed
 * @param event
 */
function remove_search_set(element){
    $(element).closest('.search-set').slideUp(animation_speed, function(){
        $(this).remove();
    });
}
