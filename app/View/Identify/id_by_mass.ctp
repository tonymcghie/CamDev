<header>
<h1>Identify Compound by Matching Accurate Masses</h1>
<?php echo $this->Html->image('underconstruction.png', array('alt' => 'CAM Logo', 'width' => '140')); ?>
<p>Select data file (.csv) containing accurate masses.</p>
</header>

<table class="noFormat">
    <tr>
        <td style="width: 92%;">
            <iframe id="csvFileFrame" class="iframeNoformat" src="<?php echo $this->Html->url(['controller' => 'Identify', 'action' => 'getCsv']);?>"></iframe>
        </td>
        <td style="width: 50%;">
            <span id="importData" class="find-button anySizeButton green-button">Read File</span>
        </td>
    </tr>
</table>

<div id="csvMassDataDiv">    
    <?php
    echo $this->Form->create('CompoundpfrData', ['id' => 'csvForm']);
    echo $this->Form->hidden('fileName', ['id' => 'fileName']);
    echo $this->Form->hidden('fileUrl', ['id' => 'fileUrl']);
    ?>
</div>




echo $this->Form->create('Whatever', array('type' => 'file'));
echo $this->Form->file('csv');
echo $this->Form->end('upload');

