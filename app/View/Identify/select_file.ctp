<p>Select file view</p>
<?php
    echo $this->Form->create('Identify', ['id' => 'fileForm', 'url' => 'SearchMasses', 'type' => 'file']);
    echo $this->Form->select('mass_window', [10, 20, 50,100,500], ['value'=> 10]);
    echo $this->Form->select('ion_type', ["[M-H]-", "[M]", "[M+H]+"]);
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