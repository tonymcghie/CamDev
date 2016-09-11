<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('tabs_'.getenv('CSS_VERSION'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
<h1>Sample Upload Workspace</h1>
<h2>Set Code: <?php echo $info['SampleSet']['set_code'] ?></h2>
<p>Crop: <?php echo $info['SampleSet']['crop'] ?></p>
<p>Type: <?php echo $info['SampleSet']['type'] ?></p>

</header>

<table class="noFormat">
    <tr>
        <td style="width: 92%;">
            <iframe id="csvFileFrame" class="iframeNoformat" src="<?php echo $this->Html->url(['controller' => 'CompoundpfrData', 'action' => 'getCsv']);?>"></iframe>
        </td>
        <td style="width: 20%;">
            <span id="importData" class="find-button anySizeButton green-button">Import</span>
        </td>
    </tr>
</table>

<div id="csvTableDiv">    
    <?php
    if (isset($message)){
        echo '<h2>'.$message.'</h2>';
    }
    echo $this->Form->create('CompoundpfrData', ['id' => 'csvForm']);
    echo $this->Form->hidden('fileName', ['id' => 'fileName']);
    echo $this->Form->hidden('fileUrl', ['id' => 'fileUrl']);
    ?>
<table id="csvTable">
    <thead>
        <tr id="csvTableSelects">            
        </tr>
        <tr id="csvTableTitles">            
        </tr>
    </thead>
    <tbody id="csvTableBody">
        
    </tbody>    
</table>
    <?php
    echo $this->Form->end();
    ?>
</div>
