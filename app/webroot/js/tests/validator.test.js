/**
 * Created by mgoo on 2/03/17.
 */
QUnit.test('requires_validator', function(assert) {
    let name = 'input_test_requires';
    let validator = new requires(name);
    // Check empty is false
    assert.equal(validator.validate(), false);
    // Check when there is text
    $(':input[name="'+name+'"]').val('sometext');
    assert.equal(validator.validate(),true);
});
QUnit.test('number_validator', function(assert) {
    let name = 'input_test_number';
    let input = $(':input[name="'+name+'"]');
    let validator = new number_validator(name);

    // Check that empty is not valid
    assert.equal(validator.validate(), false);

    // Check no numeric value is false
    input.val('awd');
    assert.equal(validator.validate(), false);

    // Check to small is false
    input.val(1);
    assert.equal(validator.validate(), false);

    // Check to big is false
    input.val(5);
    assert.equal(validator.validate(), false);

    // Check numeric value ok
    input.val(2);
    assert.equal(validator.validate(), true);

    // Check deciaml ok
    input.val(2.2);
    assert.equal(validator.validate(), true);
});
QUnit.test('match_validator', function(assert){
   let name = 'input_test_match';
   let input = $(':input[name="'+name+'"]');
   let validator = new match_validator(name,JSON.stringify({data: ['value1', 'value2']}));
   // Check that it doesnt match empty
   assert.equal(validator.validate(), false);
    // Check that it doesnt match a value not in array
    input.val('value3');
    assert.equal(validator.validate(), false);
    // Check that it correctly mataches all values
    input.val('value2');
    assert.equal(validator.validate(), true);
    input.val('value1');
    assert.equal(validator.validate(), true);
});