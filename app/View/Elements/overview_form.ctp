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

<h1><?= $this->String->get_string('overviewTitle', $model);?></h1>

<?= $this->BootstrapForm->create($model, ['action' => 'search', 'type' => 'get', 'class' => 'search-form']); ?>

<div class="search-set form-group row">
    <div class="col-lg-3"><?= $this->String->get_string('by', 'Overview_form')?></div> <!--TODO use get string-->
    <div class="col-lg-3"><?= $this->String->get_string('value', 'Overview_form')?></div>
    <div class="col-lg-3"><?= $this->String->get_string('match', 'Overview_form')?></div>
    <div class="col-lg-2"><?= $this->String->get_string('for', 'Overview_form')?></div>
</div>
<?php if (!isset($data)): ?>
    <?= $this->Mustache->render('form/search_form_row', [
            'criteriaOptions' => $criteria_options,
            'matchOptions' => $match_options,
            'logicOptions' => $criteria_options,
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


<?= $this->BootstrapForm->addOverviewButton('Go -> Overview'); ?>

<?= $this->BootstrapForm->get_js(); ?>

<?= $this->Html->script('lib/mustache.min'); ?>

<script>
    var rowTemplate = <?= $this->Mustache->getJSONPTemplates('form/search_form_row') ?>;
    var options = <?= json_encode(['criteriaOptions' => $criteria_options,
        'matchOptions' => $match_options,
        'logicOptions' => $logic_options,
        'closeable' => true]) ?>;

    options.index = <?= $index ?>;
</script>