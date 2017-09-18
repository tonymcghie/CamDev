/**
 * Created by mgoo on 1/03/17.
 */
QUnit.test('search_helper', function(assert){
    assert.equal($('#search-set').length, true);
    assert.equal($('input[name="cri"]').length, true);
    set_listeners();
    assert.equal($('#search-set').length, false);
    assert.equal($('input[name="cri[0]"]').length, true);
    add_search_set();
    assert.equal($('input[name="cri[1]"]').length, true);
    add_search_set();
    assert.equal($('input[name="cri[2]"]').length, true);
    add_search_set();
    assert.equal($('input[name="cri[3]"]').length, true);
});