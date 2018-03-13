<?php
$this->assign('title', 'New Sample Set');
?>
<header>
<h1><?php echo $this->String->get_string('title', 'SampleSet_form'); ?></h1>

<?php
if (isset($set_code)){
    echo '<h2>The Set code for this sample set is: '.$set_code.'</h2>';
}
?>

<p><?php echo $this->String->get_string('sub_title', 'SampleSet_form'); ?></p>
	</header>
<?php
echo $this->BootstrapForm->create_horizontal('SampleSet', ['type' => 'file' ,'action' => 'createSampleSet']);
//to do make a clone button in the table
echo $this->BootstrapForm->input_horizontal('confidential', ['type' => 'checkbox',
    'label' => $this->String->get_string('confidential', 'SampleSet_form')]);

echo $this->BootstrapForm->input_horizontal('submitter', ['label' => ['text' => $this->String->get_string('submitter', 'SampleSet_form')],
    'value' => (isset($user['name']) ? $user['name'] : ''),
    'required',]);

echo $this->BootstrapForm->input_horizontal('p_name', ['label' => $this->String->get_string('p_name', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('p_name_ph', 'SampleSet_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('p_code', ['label' => $this->String->get_string('p_code', 'SampleSet_form'),
    'autocomplete' => 'off']);

echo $this->BootstrapForm->input_horizontal('exp_reference', ['label' => $this->String->get_string('exp_reference', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('exp_reference_ph', 'SampleSet_form')]);

echo $this->BootstrapForm->input_horizontal('chemist', ['label' => $this->String->get_string('chemist_name', 'SampleSet_form'),
    'autocomplete' => 'on']);

echo $this->BootstrapForm->input_horizontal('crop', ['label' => $this->String->get_string('crop', 'SampleSet_form'),
    'required', 'options' => $this->My->getCropOptions()]);

echo $this->BootstrapForm->input_horizontal('type', ['label' => $this->String->get_string('sample_type', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('sample_type_ph', 'SampleSet_form')]);

echo $this->BootstrapForm->input_horizontal('number', ['label' => $this->String->get_string('sample_number', 'SampleSet_form'),
    'required']);

echo $this->BootstrapForm->input_horizontal('sample_loc', ['label' => $this->String->get_string('transport', 'SampleSet_form')]);
echo $this->BootstrapForm->input_horizontal('set_reason', ['label' => $this->String->get_string('reason', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('reason_ph', 'SampleSet_form'),
    'rows' => '3']);

echo $this->BootstrapForm->input_horizontal('compounds', ['label' => $this->String->get_string('compounds', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('compounds_ph', 'SampleSet_form'),
    'rows' => '3',
    'required']);

echo $this->BootstrapForm->input_horizontal('containment', ['type' => 'checkbox',
    'label' => $this->String->get_string('containment', 'SampleSet_form')]);

echo $this->BootstrapForm->input_horizontal('containment_details', ['label' => $this->String->get_string('containment_detils', 'SampleSet_form'),
    'rows' => '3']);

echo $this->BootstrapForm->input_horizontal('comments', ['label' => $this->String->get_string('comments', 'SampleSet_form'),
    'placeholder' => $this->String->get_string('comments_ph', 'SampleSet_form'),
    'rows' => '3']);

echo $this->BootstrapForm->input_horizontal('metadataFile', ['label' => $this->String->get_string('metaFile', 'SampleSet_form'),
    'type' => 'file']);

echo $this->BootstrapForm->addActionButtons();

$this->BootstrapForm->add_validator('requires', 'submitter');
$this->BootstrapForm->add_validator('requires', 'chemist');
$this->BootstrapForm->add_validator('requires', 'number');
$this->BootstrapForm->add_validator('requires', 'compounds');
$this->BootstrapForm->add_validator('match_validator', 'chemist', ['data' => $names]);

$this->BootstrapForm->new_rule('display_if_checked', 'containment_details', 'containment' , null, ['transition' => 'slide_down']);

echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();
?>
<script>
    $(function() {
        $('#SampleSetChemist').autocomplete({
            source: Object.values(JSON.parse('<?php echo json_encode($names); ?>')),
            appendTo: $('#SampleSetChemist').closest('div')
        });
        $('#SampleSetPName').autocomplete({
            source: Object.values(JSON.parse('<?php echo json_encode($p_names); ?>')),
            appendTo: $('#SampleSetPName').closest('div')
        });
    });
</script>

