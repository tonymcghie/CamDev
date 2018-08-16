<?php
$this->assign('title', 'Edit msms Compound Information');

?>
<header>
<h1><?php echo $this->String->get_string('edit_title', 'Compound_msms_form'); ?></h1>
<p><?php echo $this->String->get_string('edit_sub_title', 'Compound_msms_form'); ?></p><br>
</header>

<?php
echo $this->BootstrapForm->create_horizontal('Compound', ['type' => 'file' ,'action' => 'editCompound']);
//to do make a clone button in the table

echo $this->BootstrapForm->input_horizontal('cas', ['label' => ['text' => $this->String->get_string('cas', 'Compound_form')],
    'required',]);

echo $this->BootstrapForm->input_horizontal('compound_name', ['label' => $this->String->get_string('compound_name', 'Compound_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('parent_mz', ['label' => $this->String->get_string('parent_mz', 'Compound_msms_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('msms_ions', ['label' => $this->String->get_string('msms_ions', 'Compound_msms_form'),
    'placeholder' => $this->String->get_string('msms_ions_ph', 'Compound_msms_form')]);

echo $this->BootstrapForm->input_horizontal('energy_ev', ['label' => $this->String->get_string('energy_ev', 'Compound_msms_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('charge', ['label' => $this->String->get_string('charge', 'Compound_msms_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('msms_level', ['label' => $this->String->get_string('msms_level', 'Compound_msms_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('instrument', ['label' => $this->String->get_string('instrument', 'Compound_msms_form'),
    'placeholder' => $this->String->get_string('instrument_ph', 'Compound_msms_form')]);

echo $this->BootstrapForm->input_horizontal('comment', ['label' => $this->String->get_string('comment', 'Compound_msms_form'),
    'placeholder' => $this->String->get_string('comment_ph', 'Compound_msms_form'),
    'rows' => '3']);

echo $this->BootstrapForm->addActionButtons();

$this->BootstrapForm->add_validator('requires', 'compound_name');
$this->BootstrapForm->add_validator('requires', 'sys_name');
$this->BootstrapForm->add_validator('requires', 'formula');
$this->BootstrapForm->add_validator('requires', 'exact_mass');

echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();

?>