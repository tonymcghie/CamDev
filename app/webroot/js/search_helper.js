/**
 * Created by mgoo on 27/02/17.
 */
let base_search_set;
let num_boxes = 0;

/**
 * Sets up the functionality for the search forms
 */
function set_listeners(){
    base_search_set = $('#search-set').detach().removeAttr('id').clone();
    add_search_set();
}

/**
 * Adds a new search set to the form
 */
function add_search_set() {
    let div = $('#action-buttons').closest('div.form-group');
    get_new_search_set().insertBefore(div);
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
