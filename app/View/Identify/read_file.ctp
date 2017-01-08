<p>Read file view</p>
<?php
    echo $this->Form->create('Identify', ['id' => 'fileForm', 'url' => 'SelectFile', 'type' => 'file']);
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