<?php
/**
 * returns the pane for the analysis sample set page
 * @param array $analysis
 * @return string
 */
?>
<?php
echo $this->BootstrapForm->create_horizontal('Msms_compound', ['type' => 'file' ,'action' => 'saveMsmsCompound']);

echo $this->BootstrapForm->input_horizontal('compound_id',
        [
        'type' => 'hidden',
        'default' => $compound['Compound']['id']
        ]
    );

echo $this->BootstrapForm->input_horizontal('id',
        [
        'type' => 'hidden',
        'default' => $id
        ]
    );

echo $this->BootstrapForm->input_horizontal('cas', 
    ['label' => ['text' => $this->String->get_string('cas', 'Compound_form')],
    'readonly',
    'default' => isset($compound['Compound']['cas']) ? $compound['Compound']['cas'] : ''
    ]);

echo $this->BootstrapForm->input_horizontal('compound_name',
    ['label' => $this->String->get_string('compound_name', 'Compound_form'),
    'readonly',
    'default' => isset($compound['Compound']['compound_name']) ? $compound['Compound']['compound_name'] : ''
    ]);

echo $this->BootstrapForm->input_horizontal('msms_title',
    ['label' => $this->String->get_string('msms_title', 'Compound_msms_form'),
    'autocomplete' => 'on',
    'value' => $currentMsms['Msms_compound']['msms_title']
    ]);

echo $this->BootstrapForm->input_horizontal('parent_mz',
    ['label' => $this->String->get_string('parent_mz', 'Compound_msms_form'),
    'autocomplete' => 'on',
    'value' => $currentMsms['Msms_compound']['parent_mz']
    ]);

echo $this->BootstrapForm->input_horizontal('msms_ions',
    ['label' => $this->String->get_string('msms_ions', 'Compound_msms_form'),
    'placeholder' => $this->String->get_string('msms_ions_ph', 'Compound_msms_form'),
    'value' => $currentMsms['Msms_compound']['msms_ions']
    ]);

echo $this->BootstrapForm->input_horizontal('energy_ev',
    ['label' => $this->String->get_string('energy_ev', 'Compound_msms_form'),
    'autocomplete' => 'on',
    'value' => $currentMsms['Msms_compound']['energy_ev']
    ]);

echo $this->BootstrapForm->input_horizontal('charge',
    ['label' => $this->String->get_string('charge', 'Compound_msms_form'),
    'autocomplete' => 'on',
    'value' => $currentMsms['Msms_compound']['charge']
    ]);

echo $this->BootstrapForm->input_horizontal('msms_level',
    ['label' => $this->String->get_string('msms_level', 'Compound_msms_form'),
    'autocomplete' => 'on',
    'value' => $currentMsms['Msms_compound']['msms_level']
    ]);

echo $this->BootstrapForm->input_horizontal('instrument',
    ['label' => $this->String->get_string('instrument', 'Compound_msms_form'),
    'placeholder' => $this->String->get_string('instrument_ph', 'Compound_msms_form'),
    'value' => $currentMsms['Msms_compound']['instrument']
    ]);

echo $this->BootstrapForm->input_horizontal('comment',
    ['label' => $this->String->get_string('comment', 'Compound_msms_form'),
    'placeholder' => $this->String->get_string('comment_ph', 'Compound_msms_form'),
    'rows' => '3',
    'value' => $currentMsms['Msms_compound']['comment']
    ]);


echo $this->BootstrapForm->addActionButtons();
echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();
?>
