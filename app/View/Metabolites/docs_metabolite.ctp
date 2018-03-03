<header>
<h1>Upload/Download Document for an Unknown Compound</h1>
<br>
<p style="display:inline">Unknown Compound: <?php echo $metabolite['Metabolite']['id'] ?></p><br><br>
</header>
<?php
    echo $this->BootstrapForm->create_horizontal('Document', ['type' => 'file']);                   
    echo $this->BootstrapForm->fileUpload('document', [
        'label' => $this->String->get_string('document', 'Metabolite'),
        'url' => $this->Html->url(['action' => 'uploadDocument'.'/'.$metabolite['Metabolite']['id']], true),
        //pass the metabolite ID  in the url
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



