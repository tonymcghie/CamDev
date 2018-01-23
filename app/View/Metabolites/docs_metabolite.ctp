<header>
<h1>Upload Document for an Unknown Compound</h1>
<br>
<p style="display:inline">Unknown Compound: <?php echo $meta['Metabolite']['id'] ?></p><br><br>
</header>
<?php
    echo $this->Form->create('Upload', array( 'type' => 'file'));
    echo $this->Form->input('doc_path', array('type' => 'file','label' => 'Select document to Upload'));
    echo $this->Form->end('Upload');
    
?>
<script>
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>



