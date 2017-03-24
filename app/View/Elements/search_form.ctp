<?php
$logic_options = ['AND' => 'and', 'OR' => 'or', 'XOR' => 'xor', 'NOT' => 'not'];
$match_options = ['contains' => 'Contains', 'exact' => 'exactly', 'starts' => 'Start with'];
if (!empty($title))echo '<h1>'.$title.'</h1>';?>

<?= $this->BootstrapForm->create($model, ['action' => 'search', 'class' => 'search-form']); ?>

<?= $this->BootstrapForm->start_group(['id' => 'search-set', 'class' => 'search-set']); ?>
<?= $this->BootstrapForm->input_maker('criteria', ['type' => 'select', 'options' => $category_options, 'div' => ['class' => 'col-lg-3']]); ?>
<?= $this->BootstrapForm->input_maker('value', ['type' => 'text', 'div' => ['class' => 'col-lg-3']]); ?>
<?= $this->BootstrapForm->input_maker('match', ['type' => 'select', 'options' => $match_options, 'div' => ['class' => 'col-lg-3']]); ?>
<?= $this->BootstrapForm->input_maker('logic', ['type' => 'select', 'options' => $logic_options, 'div' => ['class' => 'col-lg-2']]); ?>
<?= $this->BootstrapForm->single_button('x', ['onclick' => 'remove_search_set(this);return false;', 'div' => ['class' => 'col-lg-1']], ['class' => 'btn-danger']); ?>
<?= $this->BootstrapForm->end_group(); ?>

<?= $this->BootstrapForm->start_group(['id' => 'action-buttons', 'class' => 'search-action-buttons']); ?>
<?= $this->BootstrapForm->single_button('Add Set', ['onclick' => 'add_search_set();return false;'], ['class' => 'btn-success col-lg-1']); ?>
<?= $this->BootstrapForm->single_button('Search', ['onclick' => 'submit_first_form(\'search-results\'); return false;'], ['class' => 'btn-primary col-lg-1']); ?>
<?= $this->BootstrapForm->end_group(); ?>
<?= $this->BootstrapForm->end(); ?>
<script>set_listeners();</script>