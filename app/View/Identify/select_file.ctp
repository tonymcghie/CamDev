<header>
<h1>Identify Compound by Matching Accurate Masses</h1>
<?php //echo $this->Html->image('underconstruction.png', array('alt' => 'CAM Logo', 'width' => '140')); ?>
<p id="one">  The process is:</p>
<?php $message = "This is a message - Hello World"; ?>
<input id="myButton" type="button" onclick="displayAlert()" value="Display Message">
<p> 1) Generate a .csv file where the fourth column contains accurate masses.</p>
<p> 2) Select a mass tolerance (eg +/- 10 mDa) and the ion type;  select tyour input data file.</p>
<p> 3) The compounds that are present in the Compounds database, and that match your accurate mass data will be displayed.  This table can be exported.</p>
</header>
<?php
    $mDa = ['5' => '5' , '10' => '10' , '20' => '20', '50' => '50', '100' => '100', '500' => '500'];
    $ions = ['[M-H]-' => '[M-H]-' , '[M+H]+' => '[M+H]+', '[M]' => '[M]'];
    echo $this->Form->create('Upload', array( 'type' => 'file'));
    echo $this->Form->input('mass_tolerance', array('type'=>'select', 'label'=>'Mass Tolerance (+/- mDa): ', 'options'=>$mDa, 'default'=>'10'));
    echo $this->Form->input('ion_type', array('type'=>'select', 'label'=>'Ion Type:', 'options'=>$ions, 'default'=>'[M-H]-'));
    echo $this->Form->input('csv_path', array('type' => 'file','label' => 'CSV Data File (contains accurate masses)'));
    echo $this->Form->end('Search for matching Compounds');
    //next block works but is removed for testing file upload functionality
    /**$mDa = ['5' => '5' , '10' => '10' , '20' => '20', '50' => '50', '100' => '100', '500' => '500'];
    $ions = ['[M-H]-' => '[M-H]-' , '[M+H]+' => '[M+H]+', '[M]' => '[M]'];
    //echo $this->Form->create('Identify', ['id' => 'fileForm', 'url' => 'SearchMasses', 'type' => 'file']);
    echo $this->Form->create('Identify', ['id' => 'fileForm', 'url' => 'SearchMasses', 'type' => 'get']);
    echo $this->Form->input('mass_tolerance', array('type'=>'select', 'label'=>'Mass Tolerance (mDa) ', 'options'=>$mDa, 'default'=>'0'));
    echo $this->Form->input('ion_type', array('type'=>'select', 'label'=>'Ion Type', 'options'=>$ions, 'default'=>'0'));
    echo $this->Form->hidden('MAX_FILE_SIZE', ['value' => '48000000']);
    echo $this->Form->hidden('fileUrl', ['value' => (isset($fileUrl) ? $fileUrl : '') , 'id' => 'fileUrl']);
    echo $this->Form->hidden('fileName', ['value' => (isset($fileName) ? $fileName : '') , 'id' => 'fileName']);
    echo $this->Form->input('csv_file', ['label' => false, 'type' => 'file', 'id' => 'csvFile']);
    echo $this->Form->end();*/
?>
<script>
    function displayAlert(){
      //var content = 'This is a message - Hello World - variable Content';  
      //var content = document.getElementById("one").innerText;
      //window.alert(content);
      window.alert('<?php echo $message ?>');
    }
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>