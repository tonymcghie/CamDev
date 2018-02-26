<header>
<h1>Upload Document for an Unknown Compound</h1>
<br>
<p style="display:inline">Unknown Compound: <?php echo $metabolite['Metabolite']['id'] ?></p><br><br>
</header>
<?php
    //echo $this->Form->create('Upload', array( 'type' => 'file'));
    //echo $this->Form->input('doc_path', array('type' => 'file','label' => 'Select document to Upload'));
    //echo $this->Form->end('Upload');
    echo $this->BootstrapForm->create_horizontal('Document', ['type' => 'file']);                   
    echo $this->BootstrapForm->fileUpload('document', [
        'label' => $this->String->get_string('document', 'Metabolite'),
        'url' => $this->Html->url(['action' => 'uploadDocument'], true),
        'value' => $metabolite['Metabolite']['document']]);
    
    echo $this->BootstrapForm->addActionButtons();

    echo $this->BootstrapForm->get_js();
    echo $this->BootstrapForm->end();
    
?>
<script>
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>



