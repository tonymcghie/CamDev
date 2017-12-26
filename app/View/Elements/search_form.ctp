<?php
$logic_options = [
    ['value' => 'AND', 'text' => 'and'],
    ['value' => 'OR', 'text' => 'or'],
    ['value' => 'XOR', 'text' => 'xor'],
    ['value' => 'NOT', 'text' => 'not']];
$match_options = [
    ['value' => 'contains', 'text' => 'Contains'],
    ['value' => 'exact', 'text' => 'Exactly'],
    ['value' => 'starts', 'text' => 'Starts with']];
$index = 0;
assert(isset($criteria_options),
    'You must set the array variable \'criteria_options\' in the view calling this element');
assert(isset($model),
    'The Model that this form is for must be passed in as \'model\' variable');

?>

<h1><?= $this->String->get_string('searchTitle', $model);?></h1>

<?= $this->BootstrapForm->create($model, ['action' => 'search', 'type' => 'get', 'class' => 'search-form']); ?>

<div class="search-set form-group row">
    <div class="col-lg-3"><?= $this->String->get_string('criteria', 'Search_form')?></div> <!--TODO use get string-->
    <div class="col-lg-3"><?= $this->String->get_string('value', 'Search_form')?></div>
    <div class="col-lg-3"><?= $this->String->get_string('match', 'Search_form')?></div>
    <div class="col-lg-2"><?= $this->String->get_string('logic', 'Search_form')?></div>
</div>
<?php if (!isset($data)): ?>
    <?= $this->Mustache->render('form/search_form_row', [
            'criteriaOptions' => $criteria_options,
            'matchOptions' => $match_options,
            'logicOptions' => $logic_options,
            'closeable' => false,
            'index' => $index]); ?>
    <?php $index = $index + 1; ?>
<?php else:
    for ($index = 0; $index < count($data['criteria']); $index++): ?>
        <?= $this->Mustache->render('form/search_form_row', [
            'criteriaOptions' => $this->BootstrapForm->setSelectedValue($criteria_options, $data['criteria'][$index]),
            'matchOptions' => $this->BootstrapForm->setSelectedValue($match_options, $data['match'][$index]),
            'logicOptions' => $this->BootstrapForm->setSelectedValue($logic_options, $data['logic'][$index]),
            'valueDefault' => $data['value'][$index],
            'closeable' => $index != 0,
            'index' => $index]); ?>
    <?php endfor; ?>
<?php endif;?>

<?= $this->BootstrapForm->start_group(['id' => 'action-buttons', 'class' => 'action-buttons']); ?>
<div>
    <span onclick="add_search_set();" class="btn btn-success offset-lg-9 col-lg-1 form-control" type="submit">Add Set</span>
</div>
<?= $this->BootstrapForm->single_button('Find', [], ['class' => 'btn-primary col-lg-1']); ?>
<?= $this->BootstrapForm->end_group(); ?>
<?= $this->BootstrapForm->end(); ?>

<?= $this->BootstrapForm->get_js(); ?>

<?= $this->Html->script('lib/mustache.min'); ?>

<script>
    var rowTemplate = <?= $this->Mustache->getJSONPTemplates('form/search_form_row') ?>;
    var options = <?= json_encode(['criteriaOptions' => $criteria_options,
        'matchOptions' => $match_options,
        'logicOptions' => $logic_options,
        'closeable' => true]) ?>;

    options.index = <?= $index ?>;

    /**
     * This will add a form row to the search form
     */
    function add_search_set() {
        let newRow = $(Mustache.render(rowTemplate["form/search_form_row"], options));
        newRow.hide();
        newRow.insertBefore($('#action-buttons'));
        newRow.slideDown(400);
        options.index = options.index + 1;
    }

    /**
     * This will remove a form row to the search form. The closest one to the element passed in
     */
    function remove_search_set(element){
        $(element).closest('.search-set').slideUp(400, function(){
            $(this).remove();
        });
    }
</script>