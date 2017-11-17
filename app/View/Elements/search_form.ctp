<?php
$logic_options = ['AND' => 'and', 'OR' => 'or', 'XOR' => 'xor', 'NOT' => 'not'];
$match_options = ['contains' => 'Contains', 'exact' => 'Exactly', 'starts' => 'Starts with'];
if (!empty($title))echo '<h1>'.$title.'</h1>';?>

<?= $this->BootstrapForm->create($model, ['action' => 'searchSet', 'type' => 'get', 'class' => 'search-form']); ?>

<?= $this->BootstrapForm->start_group(['id' => 'search-set', 'class' => 'search-set']); ?>
<?= $this->BootstrapForm->input_maker('criteria', ['label' => 'Criteria','type' => 'select', 'options' => $category_options, 'div' => ['class' => 'col-lg-3']]); ?>
<?= $this->BootstrapForm->input_maker('value', ['label' => 'Value', 'type' => 'text', 'div' => ['class' => 'col-lg-3']]); ?>
<?= $this->BootstrapForm->input_maker('match', ['label' => 'Match','type' => 'select', 'options' => $match_options, 'div' => ['class' => 'col-lg-3']]); ?>
<?= $this->BootstrapForm->input_maker('logic', ['label' => 'Logic','type' => 'select', 'options' => $logic_options, 'div' => ['class' => 'col-lg-2']]); ?>
<?= $this->BootstrapForm->single_button('x', ['onclick' => 'remove_search_set(this);return false;', 'div' => ['class' => 'col-lg-1']], ['class' => 'btn-danger']); ?>
<?= $this->BootstrapForm->end_group(); ?>

<?= $this->BootstrapForm->start_group(['id' => 'action-buttons', 'class' => 'action-buttons']); ?>
<?= $this->BootstrapForm->single_button('Add Set', ['onclick' => 'add_search_set();return false;'], ['class' => 'btn-success offset-lg-9 col-lg-1']); ?>
<?= $this->BootstrapForm->single_button('Find', [], ['class' => 'btn-primary col-lg-1']); ?>
<?= $this->BootstrapForm->end_group(); ?>
<?= $this->BootstrapForm->end(); ?>

<?= $this->BootstrapForm->get_js(); ?>

<?= $this->Html->script('search_helper.min', ['inline' => false, 'async' => 'async']); ?>
<script>set_listeners();</script>