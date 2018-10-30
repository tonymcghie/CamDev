<?php
$this->assign('title', 'New Unknown Compound');
?>
<header>
<h1><?php echo $this->String->get_string('title', 'Metabolite_form'); ?></h1>
<p><?php echo $this->String->get_string('sub_title', 'Metabolite_form'); ?></p>
</header>
<?php

echo $this->BootstrapForm->create_horizontal('Metabolite', ['url' => array('controller' => 'Metabolites', 'action' => 'createMetabolite')]);
echo $this->BootstrapForm->input_horizontal('exact_mass', ['label' => ['text' => $this->String->get_string('exact_mass', 'Metabolite_form')],
    'required',]);
echo $this->BootstrapForm->input_horizontal('ion_type', ['label' => $this->String->get_string('ion_type', 'Metabolite_form'),
    'required', 'options' => $this->My->getIonTypeOptions()]);
echo $this->BootstrapForm->input_horizontal('rt_value', ['label' => ['text' => $this->String->get_string('rt_value', 'Metabolite_form')],
    'required',]);
echo $this->BootstrapForm->input_horizontal('rt_description', ['label' => ['text' => $this->String->get_string('rt_description', 'Metabolite_form')],
    'required',]);
echo $this->BootstrapForm->input_horizontal('sources', ['label' => ['text' => $this->String->get_string('sources', 'Metabolite_form')],
    'required',]);
echo $this->BootstrapForm->input_horizontal('tissue', ['label' => ['text' => $this->String->get_string('tissue', 'Metabolite_form')],
    'required',]);
//echo $this->BootstrapForm->input_horizontal('chemist', ['label' => ['text' => $this->String->get_string('chemist', 'Metabolite_form')],
    //'required',]);
echo $this->BootstrapForm->input_horizontal('chemist', ['label' => $this->String->get_string('chemist_name', 'SampleSet_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('experiment_ref', ['label' => ['text' => $this->String->get_string('experiment_ref', 'Metabolite_form')],
    'required',]);
echo $this->BootstrapForm->input_horizontal('spectra_uv', ['label' => ['text' => $this->String->get_string('spectra_uv', 'Metabolite_form')]]);
echo $this->BootstrapForm->input_horizontal('spectra_nmr', ['label' => ['text' => $this->String->get_string('spectra_nmr', 'Metabolite_form')]]);

echo $this->BootstrapForm->addActionButtons();

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


