<header>
    <h1>Sample Set Analysis Workspace</h1>
    <h2>Set Code: <?php echo $set_code ?></h2>
</header>
<?= $this->element('Analysis/tabs', ['titles' => $titles, 'currentAnalysis' => null]); ?>

<?php
    echo $this->BootstrapForm->create_horizontal('Analysis', ['url' => array('controller' => 'Analyses', 'action' => 'newAnalysis')]);
    echo $this->BootstrapForm->input_horizontal('set_code', ['type' => 'hidden', 'value' => $set_code]);

    echo $this->BootstrapForm->input_horizontal('title', ['type' => 'text',
        'placeholder' => 'New Analysis title',
        'label' => $this->String->get_string('title', 'Analysis')]);
    echo $this->BootstrapForm->input_horizontal('workflow', ['label' => $this->String->get_string('workflow', 'Analysis'),
        'options' => [
            'chem_everything' => 'Chem: all sections',
            'chem_details' => 'Chem: analysis details only',
            'chem_files' => 'Chem: files only',
            'chem_pictures' => 'Chem: images only'
            //'bio_everything' => 'Bio: all sections',
            //'bio_details' => 'Bio: analysis details only',
            //'bio_files' => 'Bio: files only',
            //'bio_pictures' => 'Bio: pictures only'
        ]]);
    echo $this->BootstrapForm->addActionButtons();
    echo $this->BootstrapForm->get_js();
    echo $this->BootstrapForm->end();
?>