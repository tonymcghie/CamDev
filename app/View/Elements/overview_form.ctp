<?php
$logic_options = ['AND' => 'and', 'OR' => 'or', 'XOR' => 'xor', 'NOT' => 'not'];
$match_options = ['contains' => 'Contains', 'exact' => 'Exactly', 'starts' => 'Starts with'];
if (!empty($title))echo '<h1>'.$title.'</h1>';?>

<?= $this->BootstrapForm->create($model, ['action' => 'overview', 'class' => 'search-form']); ?>

<?= $this->BootstrapForm->start_group(['id' => 'search-set', 'class' => 'search-set']); ?>
<?= $this->BootstrapForm->input_maker('by', ['label' => 'Review','type' => 'select', 'options' => $by_options, 'div' => ['class' => 'col-lg-3']]); ?>
<?= $this->BootstrapForm->input_maker('value', ['label' => 'By (enter value)', 'type' => 'text', 'div' => ['class' => 'col-lg-3']]); ?>
<?= $this->BootstrapForm->input_maker('match', ['label' => 'Match','type' => 'select', 'options' => $match_options, 'div' => ['class' => 'col-lg-3']]); ?>
<?= $this->BootstrapForm->input_maker('for', ['label' => 'For','type' => 'select', 'options' => $for_options, 'div' => ['class' => 'col-lg-2']]); ?>
<?= $this->BootstrapForm->single_button('x', ['onclick' => 'remove_search_set(this);return false;', 'div' => ['class' => 'col-lg-1']], ['class' => 'btn-danger']); ?>
<?= $this->BootstrapForm->end_group(); ?>

<?= $this->BootstrapForm->start_group(['id' => 'action-buttons', 'class' => 'action-buttons']); ?>
<?= $this->BootstrapForm->single_button('Review Data', ['onclick' => 'submit_first_form(\'search-results\'); return false;'], ['class' => 'btn-primary col-lg-6']); ?>
<?= $this->BootstrapForm->end_group(); ?>
<?= $this->BootstrapForm->end(); ?>

<?= $this->BootstrapForm->get_js(); ?>

<?= $this->Html->script('ajax_helper.min', ['inline' => false, 'async' => 'async']); ?>
<?= $this->Html->script('search_helper.min', ['inline' => false, 'async' => 'async']); ?>
<script>set_listeners();</script>