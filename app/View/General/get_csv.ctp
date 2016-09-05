<?php
    echo $this->Form->create('General', ['id' => 'fileForm', 'url' => 'getCsv', 'type' => 'file']);
    echo $this->Form->hidden('MAX_FILE_SIZE', ['value' => '48000000']);
    echo $this->Form->hidden('fileUrl', ['value' => (isset($fileUrl) ? $fileUrl : '') , 'id' => 'fileUrl']);
    echo '<table>';
    echo $this->Html->tableCells([$this->Form->input('csv_file', ['label' => false, 'type' => 'file', 'id' => 'csvFile']),
        $this->Form->input('fileName', ['value' => (isset($fileName) ? $fileName : '') , 'id' => 'fileName', 'label' => false, 'disabled' => 'disabled'])]);
    echo '</table>';
    echo $this->Form->end();
?>
<script>
    /**
     * If a file is selected then submit the form
     */
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>
