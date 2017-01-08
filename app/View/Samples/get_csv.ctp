<style>
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
</style>
<?php
    echo $this->Form->create('Samples', ['id' => 'fileForm', 'url' => 'getCsv', 'type' => 'file']);
    echo $this->Form->hidden('MAX_FILE_SIZE', ['value' => '48000000']);
    echo $this->Form->hidden('fileUrl', ['value' => (isset($fileUrl) ? $fileUrl : '') , 'id' => 'fileUrl']);
    echo $this->Form->hidden('fileName', ['value' => (isset($fileName) ? $fileName : '') , 'id' => 'fileName']);
    ?>
<label class="btn btn-default btn-file">
    Browse <input type="file" style="display: none;" name="data[Samples][csv_file]">
</label>
<?php
   // echo $this->Form->input('csv_file', ['label' => 'Upload File', 'type' => 'file', 'id' => 'csvFile', 'class' => 'btn btn-file']);
    echo $this->Form->end();
?>
<script>
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });


</script>
