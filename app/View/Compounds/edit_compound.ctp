<?php
$this->assign('title', 'Edit Compound Information');

?>
<header>
<h1><?php echo $this->String->get_string('edit_title', 'Compound_form'); ?></h1>
<p><?php echo $this->String->get_string('edit_sub_title', 'Compound_form'); ?></p><br>
</header>

<?php
echo $this->BootstrapForm->create_horizontal('Compound', ['type' => 'file' ,'action' => 'editCompound']);
//to do make a clone button in the table

echo $this->BootstrapForm->input_horizontal('cas', ['label' => ['text' => $this->String->get_string('cas', 'Compound_form')],
    'required',]);

echo $this->BootstrapForm->input_horizontal('compound_name', ['label' => $this->String->get_string('compound_name', 'Compound_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('pseudonyms', ['label' => $this->String->get_string('pseudonyms', 'Compound_form'),
    'placeholder' => $this->String->get_string('pseudonyms_ph', 'Compound_form')]);

echo $this->BootstrapForm->input_horizontal('sys_name', ['label' => $this->String->get_string('sys_name', 'Compound_form'),
    'required']);

echo $this->BootstrapForm->input_horizontal('formula', ['label' => $this->String->get_string('formula', 'Compound_form'),
    'placeholder' => $this->String->get_string('formula_ph', 'Compound_form'), 'required']);

echo $this->BootstrapForm->input_horizontal('exact_mass', ['label' => $this->String->get_string('exact_mass', 'Compound_form')]);

echo $this->BootstrapForm->input_horizontal('pub_chem', ['label' => $this->String->get_string('pub_chem', 'Compound_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('chemspider_id', ['label' => $this->String->get_string('chemspider_id', 'Compound_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('canonical_smiles', ['label' => $this->String->get_string('canonical_smiles', 'Compound_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('metlin_id', ['label' => $this->String->get_string('metlin_id', 'Compound_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('compound_type', ['label' => $this->String->get_string('compound_type', 'Compound_form'),
    'required', 'options' => $this->My->getChemicalClassOptions()]);

echo $this->BootstrapForm->input_horizontal('chemfinder_ref', ['label' => $this->String->get_string('chemfinder_ref', 'Compound_form')]);

echo $this->BootstrapForm->input_horizontal('comment', ['label' => $this->String->get_string('comment', 'Compound_form'),
    'placeholder' => $this->String->get_string('comment_ph', 'Compound_form'),
    'rows' => '3']);

echo $this->BootstrapForm->addActionButtons();

$this->BootstrapForm->add_validator('requires', 'compound_name');
$this->BootstrapForm->add_validator('requires', 'sys_name');
$this->BootstrapForm->add_validator('requires', 'formula');
$this->BootstrapForm->add_validator('requires', 'exact_mass');

echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();

?>
