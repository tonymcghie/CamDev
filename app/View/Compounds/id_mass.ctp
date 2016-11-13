<header>
<h1>Identify Compound by Matching Accurate Masses</h1>
<?php echo $this->Html->image('underconstruction.png', array('alt' => 'CAM Logo', 'width' => '140')); ?>
<p> The intention here is to match a list of accurate masses with compounds present in the Compounds Table.</p>
</header>
<div>
    <?php    
    //$this->start('$get_file');
    echo $this->Form->start('MyInputData');
    echo $this->Form->input('Mass data file', ['type' => 'text']);
    //echo 'My input data.';
    echo $this->Form->button('Open');
    echo $this->Form->end();
    //$this->end();
    ?>
</div>
<div>
    <p style="display:inline">File to Open: <?php echo $data ?></p>
</div>



