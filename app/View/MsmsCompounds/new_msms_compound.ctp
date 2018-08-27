<?php
$this->assign('title', 'Edit msms Compound Information');

?>
<header>
<h1><?php echo $this->String->get_string('add_title', 'Compound_msms_form'); ?></h1>
<p><?php echo $this->String->get_string('add_sub_title', 'Compound_msms_form'); ?></p>
<p><?php echo 'Compound ID = ', $compound_id; ?></p><br>
</header>

<?= $this->element('Msms_compound/tabs', ['titles' => $titles, 'currentMsms' => null]); ?>

<?php
    echo $this->BootstrapForm->create_horizontal('Msms_compound', ['action' => 'newMsmsCompound']);
    
    echo $this->BootstrapForm->input_horizontal('compound_id',
        [
        'type' => 'hidden',
        'default' => $compound_id
        ]
    );

    echo $this->BootstrapForm->input_horizontal('msms_title', ['type' => 'text',
        'placeholder' => 'e.g. polarity and eV value',
        'label' => $this->String->get_string('msms_title', 'Compound_msms_form')]);
    
    echo $this->BootstrapForm->addActionButtons();
    echo $this->BootstrapForm->get_js();
    echo $this->BootstrapForm->end();

?>
