<?php
$this->assign('title', 'New Unknown msms');
?>
<header>
<h1><?php echo $this->String->get_string('title', 'Msms_Metabolite_form'); ?></h1>
<p><?php echo $this->String->get_string('sub_title', 'Msms_Metabolite_form'); ?></p>
</header>
<?php

echo $this->BootstrapForm->create_horizontal('Metabolite', ['action' => 'addMsms']);
echo $this->BootstrapForm->input_horizontal('metabolite_id', ['label' => ['text' => $this->String->get_string('metabolite_id', 'Msms_Metabolite_form')],
    'readonly']);
echo $this->BootstrapForm->input_horizontal('name', ['label' => ['text' => $this->String->get_string('name', 'Msms_Metabolite_form')],
    'required']);
echo $this->BootstrapForm->input_horizontal('parent_mz', ['label' => ['text' => $this->String->get_string('parent_mz', 'Msms_Metabolite_form')],
    'required']);
echo $this->BootstrapForm->input_horizontal('energy_ev', ['label' => ['text' => $this->String->get_string('energy_ev', 'Msms_Metabolite_form')],
    'required']);
echo $this->BootstrapForm->input_horizontal('charge', ['label' => $this->String->get_string('charge', 'Msms_Metabolite_form'), 
    'placeholder' => $this->String->get_string('charge_ph', 'Msms_Metabolite_form'),
    'required']);
echo $this->BootstrapForm->input_horizontal('msms_level', ['label' => ['text' => $this->String->get_string('msms_level', 'Msms_Metabolite_form')],
    'required']);
echo $this->BootstrapForm->input_horizontal('spectra_msms', ['label' => ['text' => $this->String->get_string('spectra_msms', 'Msms_Metabolite_form')],
    'required']);
echo $this->BootstrapForm->input_horizontal('comment', ['label' => ['text' => $this->String->get_string('comment', 'Msms_Metabolite_form')]]);

echo $this->BootstrapForm->addActionButtons();

//$this->BootstrapForm->add_validator('requires', 'short_name');
//$this->BootstrapForm->add_validator('requires', 'code');

echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();
?>  

<script>
    $(function() {
        $('#MetaboliteChemist').autocomplete({
            source: Object.values(JSON.parse('<?php echo json_encode($names); ?>')),
            appendTo: $('#MetaboliteChemist').closest('div')
        });
    });
</script>

