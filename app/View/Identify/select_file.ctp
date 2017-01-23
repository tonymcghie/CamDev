<header>
<h1>Identify Compound by Matching Accurate Masses</h1>
<?php echo $this->Html->image('underconstruction.png', array('alt' => 'CAM Logo', 'width' => '140')); ?>
<p> The process is:</p>
<p> 1) Generate a .csv file where the third column contains accurate masses.</p>
<p> 2) Select a mass tolerance (eg +/- 10 mDa) and the ion type, then select the location of your input file.</p>
<p> 3) The compounds that are present in the Compounds database, and that match your accurate mass data will be displayed.  This table can be exported.</p>
</header>
<?php
    $mDa = ['5' => '5' , '10' => '10' , '20' => '20', '50' => '50', '100' => '100', '500' => '500'];
    $ions = ['[M-H]-' => '[M-H]-' , '[M+H]+' => '[M+H]+', '[M]' => '[M]'];
    //echo $this->Form->create('Identify', ['id' => 'fileForm', 'url' => 'SearchMasses', 'type' => 'file']);
    echo $this->Form->create('Identify', ['id' => 'fileForm', 'url' => 'SearchMasses', 'type' => 'get']);
    echo $this->Form->input('mass_tolerance', array('type'=>'select', 'label'=>'Mass Tolerance (mDa) ', 'options'=>$mDa, 'default'=>'0'));
    echo $this->Form->input('ion_type', array('type'=>'select', 'label'=>'Ion Type', 'options'=>$ions, 'default'=>'0'));
    echo $this->Form->hidden('MAX_FILE_SIZE', ['value' => '48000000']);
    echo $this->Form->hidden('fileUrl', ['value' => (isset($fileUrl) ? $fileUrl : '') , 'id' => 'fileUrl']);
    echo $this->Form->hidden('fileName', ['value' => (isset($fileName) ? $fileName : '') , 'id' => 'fileName']);
    echo $this->Form->input('csv_file', ['label' => false, 'type' => 'file', 'id' => 'csvFile']);
    echo $this->Form->end();
?>
<script>
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>