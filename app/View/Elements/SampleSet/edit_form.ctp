<?php

/**
 * Fields in the database that should be passed through but not edited or displayed.
 * @var array $hiddenFields
 */
$hiddenFields = ['id', 'set_code', 'submitter_email', 'date', 'team', 'p_code'];

foreach ($hiddenFields as $hiddenField) {
    echo $this->BootstrapForm->input_horizontal($hiddenField,
        [
            'type' => 'hidden',
            'default' => $item['SampleSet'][$hiddenField]
        ]
    );
}
echo $this->BootstrapForm->input_horizontal('version',
    [
        'label' => $this->String->get_string('version', 'SampleSet_form'),
        'readonly',
        'type' => 'text',
        'default' => $item['SampleSet']['version']
    ]
);
echo $this->BootstrapForm->input_horizontal('confidential',
    [
        'type' => 'checkbox',
        'label' => $this->String->get_string('confidential', 'SampleSet_form'),
        'default' => isset($item['SampleSet']['confidential']) ? $item['SampleSet']['confidential'] : false
    ]
);
echo $this->BootstrapForm->input_horizontal('submitter',
    [
        'label' => ['text' => $this->String->get_string('submitter', 'SampleSet_form')],
        'default' => isset($item['SampleSet']['submitter']) ? $item['SampleSet']['submitter'] : ''
    ]
);
echo $this->BootstrapForm->input_horizontal('p_name',
    [
        'label' => $this->String->get_string('p_name', 'SampleSet_form'),
        'placeholder' => $this->String->get_string('p_name_ph', 'SampleSet_form'),
        'autocomplete' => 'off',
        'default' => isset($item['SampleSet']['p_name']) ? $item['SampleSet']['p_name'] : '',
        'id' => 'SampleSetPName'
    ]
);
echo $this->BootstrapForm->input_horizontal('exp_reference',
    [
        'label' => $this->String->get_string('exp_reference', 'SampleSet_form'),
        'placeholder' => $this->String->get_string('exp_reference_ph', 'SampleSet_form'),
        'default' => isset($item['SampleSet']['exp_reference']) ? $item['SampleSet']['exp_reference'] : ''
    ]
);
echo $this->BootstrapForm->input_horizontal('chemist',
    [
        'label' => $this->String->get_string('chemist_name', 'SampleSet_form'),
        'readonly',
        'default' => isset($item['SampleSet']['chemist']) ? $item['SampleSet']['chemist'] : ''
    ]
);
echo $this->BootstrapForm->input_horizontal('associate_analyst',
    [
        'label' => $this->String->get_string('associate_analyst_name', 'SampleSet_form'),
        'placeholder' => $this->String->get_string('chemist_name_ph', 'SampleSet_form'),
        'autocomplete' => 'off',
        'default' => isset($item['SampleSet']['associate_analyst']) ? $item['SampleSet']['associate_analyst'] : '',
        'id' => 'SampleSetAssociateAnalyst'
    ]
);
echo $this->BootstrapForm->input_horizontal('crop',
    [
        'type' => 'text',
        'label' => $this->String->get_string('crop', 'SampleSet_form'),
        'default' => isset($item['SampleSet']['crop']) ? $item['SampleSet']['crop'] : '',
        'id' => 'SampleSetCrop'
    ]
);
echo $this->BootstrapForm->input_horizontal('type',
    [
        'label' => $this->String->get_string('sample_type', 'SampleSet_form'),
        'placeholder' => $this->String->get_string('sample_type_ph', 'SampleSet_form'),
        'default' => isset($item['SampleSet']['type']) ? $item['SampleSet']['type'] : ''
    ]
);

echo $this->BootstrapForm->input_horizontal('number',
    [
        'label' => $this->String->get_string('sample_number', 'SampleSet_form'),
        'required',
        'value' => isset($item['SampleSet']['number']) ? $item['SampleSet']['number'] : ''
    ]
);
echo $this->BootstrapForm->input_horizontal('sample_loc',
    [
        'label' => $this->String->get_string('transport', 'SampleSet_form'),
        'default' => isset($item['SampleSet']['sample_loc']) ? $item['SampleSet']['sample_loc'] : ''
    ]
);
echo $this->BootstrapForm->input_horizontal('set_reason',
    [
        'label' => $this->String->get_string('reason', 'SampleSet_form'),
        'placeholder' => $this->String->get_string('reason_ph', 'SampleSet_form'),
        'rows' => '3',
        'default' => isset($item['SampleSet']['set_reason']) ? $item['SampleSet']['set_reason'] : ''
    ]
);
echo $this->BootstrapForm->input_horizontal('compounds',
    [
        'label' => $this->String->get_string('compounds', 'SampleSet_form'),
        'placeholder' => $this->String->get_string('compounds_ph', 'SampleSet_form'),
        'rows' => '3',
        'required',
        'default' => isset($item['SampleSet']['compounds']) ? $item['SampleSet']['compounds'] : ''
    ]
);
echo $this->BootstrapForm->input_horizontal('containment',
    [
        'type' => 'checkbox',
        'label' => $this->String->get_string('containment', 'SampleSet_form'),
        'default' => isset($item['SampleSet']['containment']) ? $item['SampleSet']['containment'] : false
    ]
);
echo $this->BootstrapForm->input_horizontal('containment_details',
    [
        'label' => $this->String->get_string('containment_details', 'SampleSet_form'),
        'rows' => '3',
        'default' => isset($item['SampleSet']['containment_details']) ? $item['SampleSet']['containment_details'] : 0
    ]
);
echo $this->BootstrapForm->input_horizontal('comments',
    [
        'label' => $this->String->get_string('comments', 'SampleSet_form'),
        'placeholder' => $this->String->get_string('comments_ph', 'SampleSet_form'),
        'rows' => '3',
        'default' => isset($item['SampleSet']['comments']) ? $item['SampleSet']['comments'] : ''
    ]
);
echo $this->BootstrapForm->input_horizontal('status',
    [
        'label' => $this->String->get_string('status', 'SampleSet_form'),
        'options' => $this->My->getSampleSetStatusOptions(),
        'default' => isset($item['SampleSet']['status']) ? $item['SampleSet']['status'] : ''
    ]
);
echo $this->BootstrapForm->input_horizontal('metaFile',
    [
        'label' => $this->String->get_string('metaFile_current', 'SampleSet_form'),
        'readonly',
        'default' => isset($item['SampleSet']['metaFile']) ? $item['SampleSet']['metaFile'] : ''
    ]
);

//echo $this->BootstrapForm->input_horizontal('metadataFile', ['label' => $this->String->get_string('metaFile', 'SampleSet_form'),
//    'type' => 'file']);
// pasted form the new_set view for reference becasue the code below does not provide an array for file upload

echo $this->BootstrapForm->input_horizontal('metadataFile',
    [
        'label' => $this->String->get_string('metaFile_new', 'SampleSet_form'),
        'type' => 'file'
    ]
);
//echo $item['SampleSet']['metaFile'];
//var_dump($item);

$this->BootstrapForm->add_validator('requires', 'submitter');
$this->BootstrapForm->add_validator('requires', 'chemist');
$this->BootstrapForm->add_validator('requires', 'number');
$this->BootstrapForm->add_validator('requires', 'compounds');
$this->BootstrapForm->add_validator('match_validator', 'chemist', ['data' => $names]);

$this->BootstrapForm->new_rule('display_if_checked', 'containment_details', 'containment' , null, ['transition' => 'slide_down']);


