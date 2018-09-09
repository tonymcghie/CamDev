<?php
//$this->assign('title', 'New msms Compound Information');
?>
<header>
<h1><?php echo $this->String->get_string('new_title', 'Compound_msms_form'); ?></h1>
    <h2>Compound ID: <?php echo $compound_id ?></h2>
    <h2>Msms ID: <?php echo $id ?></h2>
</header>

<?= $this->element('Msms_compound/tabs_content', ['titles' => $titles, 'Msms' => $currentMsms]); ?>

<?php
    
    
    echo $this->BootstrapForm->addActionButtons();
    echo $this->BootstrapForm->get_js();
    echo $this->BootstrapForm->end();

?>
