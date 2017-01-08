<header>
<h1>Identify Compound by Matching Accurate Masses</h1>
<?php echo $this->Html->image('underconstruction.png', array('alt' => 'CAM Logo', 'width' => '140')); ?>
<p> The intention here is to match a list of accurate masses with compounds present in the Compounds Table.</p>
<p> The process would be something like:</p>
<p> 1) Using your MS data, generate a .csv file containing a column of accurate masses</p>
<p> 2) Read each mass and assign an identity by matching the accurate mass of the unknown with compounds in the Compounds Table using +- a specified mass tolerance (eg +/- 10 mDa)</p>
<p> 3) Write compounds hits to a .csv file and export</p>
<p> Any suggestions on how best to develop this process would be welcome. Thanks, Tony (ext 7684)</p>
</header>

<div id="csvMassDataDiv">    
    <?php
    if (isset($message)){
        echo '<h2>'.$message.'</h2>';
    }
    echo $this->Form->create('CompoundpfrData', ['id' => 'csvForm']);
    echo $this->Form->hidden('fileName', ['id' => 'fileName']);
    echo $this->Form->hidden('fileUrl', ['id' => 'fileUrl']);
    ?>
</div>

