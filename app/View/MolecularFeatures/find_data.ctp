<header>
<?php
$title = "Find Metabolomic Data";
$model = "Molecular_feature";
$options = array(
    'experiment_reference' => 'Experiment Reference',
    'all' => 'All',
    'feature_tag' => 'Metabolite Tag',
    'mz' => 'Exact m/z',
    'exact_mass_10mDa' => 'Exact Mass +- 10 mDa',
    'exact_mass_50mDa' => 'Exact Mass +- 50 mDa',
    'ms_instrument_loc' => 'MS Instrument',
    'sample_reference' => 'Sample Reference',
    'sample_description' => 'Sample Description',
    'crop' => 'Crop',
    'genus_species' => 'Species',
    'tissue' => 'Tissue',
    'genotype' => 'Genotype',
    'analyst' => 'Analyst',
    'file' => 'File',
    'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data[$model]['start_date'] : '2000-01-01')
);

$this->Html->script('HelperScripts_'.getenv('CSS_VERSION'), array('inline' => false));
if (!isset($box_nums)){$box_nums=1;} //sets the box nums for the first time
echo $this->element('search_form', ['title' => $title, 'model' => $model, 'options' => $options, 'box_nums' => $box_nums]);
?>
<script>
    var boxnum=<?php echo $box_nums; ?>;    
    var cols =<?php echo json_encode(array_keys($options)); ?>;
    var names = <?php echo json_encode(array_values($options)); ?>;
    cols.splice(cols.length-1,1);  //removes the date option
    names.splice(names.length-1,1); //removes the date option
    /**
     * adds another input pair    
     */
    function add(){
        $('#boxes').append(getNewBox(boxnum, cols,names,'<?php echo $model; ?>')); //adds the new boxes the the section
        boxnum++; //increases the number of boxes passed to and from the view and controller
        $('#box_nums').val(boxnum); //updates the hidden input
    }
 </script>
</header>
 <?php    
$this->Paginator->settings['limit'] = 30;
    echo '<div  id="resultsTable">';
    if (isset($results[0]['Molecular_feature'])){
	   $names = array( $this->Paginator->sort('feature_tag', 'Metabolite Tag', ['data' => $data]),
           array('Actions' => ['class' => 'Buttons']),
           $this->Paginator->sort('sample_reference', 'Sample Ref.',['data' => $data]),
           $this->Paginator->sort('experiment_reference', 'Experiment Ref.',['data' => $data]),
           $this->Paginator->sort('mz','Exact Mass', ['data' => $data]),
           $this->Paginator->sort('ion_polarity','Polarity', ['data' => $data]),    
           $this->Paginator->sort('intensity', 'Intensity', ['data' => $data]),
           $this->Paginator->sort('crop', 'Crop',['data' => $data]),
           $this->Paginator->sort('genotype', 'Genotype', ['data' => $data]),
           $this->Paginator->sort('tissue', 'Tissue', ['data' => $data]),
           $this->Paginator->sort('analyst', 'Analyst', ['data' => $data]));
       $cols = array('feature_tag', 'Actions', 'sample_reference', 'experiment_reference', 'mz', 'ion_polarity','intensity', 'crop', 'genotype','tissue', 'analyst');	
       $type = 'Molecular_feature';
       echo $this->element('results_table', ['results' => $results, 'names' => $names, 'cols' => $cols, 'model' => $model, 'type' => $type, 'data' => $data, 'num' => $num]);
    } else if (isset($results)){
        echo "No Data found";
    }
    echo '</div>';

