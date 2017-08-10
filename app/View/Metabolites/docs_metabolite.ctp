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
</header>
<script>
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>

<div class="unknown-compounds">
<?php
if (!isset($meta)){
    echo '<h2>Unknown Compound Not found</h2>';
} else {
    $results['Metabolite'] = $meta;
    echo $this->My->makeResultsTable($results, array(
            'names' => array('ID', 'Exact Mass', 'Ion Type', 'Retention Value', 'Retention Description','Sources','Tissue','Chemist','Experiment Reference'),
            'cols' => array('id', 'exact_mass', 'ion_type', 'rt_value', 'rt_description','sources','tissue','chemist','experiment_ref'),
            'model' => 'Metabolite',),
            'Metabolite');
}
?>


