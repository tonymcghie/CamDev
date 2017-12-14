<?php
$this->assign('title', 'New Proposed Unknown ID');
?>
<header>
<h1><?php echo $this->String->get_string('title', 'Proposed_Metabolite_form'); ?></h1>
<p><?php echo $this->String->get_string('sub_title', 'Proposed_Metabolite_form'); ?></p>
</header>
<?php

echo $this->BootstrapForm->create_horizontal('Proposed_Metabolite', ['action' => 'addProposedid']);
echo $this->BootstrapForm->input_horizontal('name', ['label' => ['text' => $this->String->get_string('name', 'Proposed_Metabolite_form')],
    'required']);
echo $this->BootstrapForm->input_horizontal('formula', ['label' => ['text' => $this->String->get_string('formula', 'Proposed_Metabolite_form')],
    'placeholder' => $this->String->get_string('formula_ph', 'Proposed_Metabolite_form'),
    'required']);
echo $this->BootstrapForm->input_horizontal('mass_diff', ['label' => ['text' => $this->String->get_string('mass_diff', 'Proposed_Metabolite_form')], 
    'placeholder' => $this->String->get_string('mass_diff_ph', 'Proposed_Metabolite_form'),
    'required']);
echo $this->BootstrapForm->input_horizontal('msigma', ['label' => ['text' => $this->String->get_string('msigma', 'Proposed_Metabolite_form')],
    'placeholder' => $this->String->get_string('msigma_ph', 'Proposed_Metabolite_form'),
    'required']);
echo $this->BootstrapForm->input_horizontal('data_file', ['label' => $this->String->get_string('data_file', 'Proposed_Metabolite_form')]);
echo $this->BootstrapForm->input_horizontal('comment', ['label' => ['text' => $this->String->get_string('comment', 'Proposed_Metabolite_form')],
    'required']);

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
