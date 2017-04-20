<header>
<?php
$title = "Search PFR Bioactivity Data";
$model = "Bioactivitypfr_data";
$options = array(
    'empty' => 'Select Criteria',
    'all' => 'All',
    'bioactivity_name' => 'Bioactivity Name',
    'value' => 'Value',
    'unit_description' => 'Units',
    'bioassay_description' => 'Bioassay Description',
	'bioassay_red' => 'Bioassay ref.',
    'sample_ref' => 'Sample ref.',
    'sample_description' => 'Sample Description',
    'crop' => 'Crop',
    'species' => 'Species',
    'tissue' => 'Tissue',
    'genotype' => 'Genotype',
    'analyst' => 'Analyst',
    'file' => 'File',
    'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data[$model]['start_date'] : '2000-01-01')
);

$this->Html->script('HelperScripts_'.getenv('CSS_VERSION').'.min', array('inline' => false));
if (!isset($box_nums)){$box_nums=1;} //sets the box nums for the first time
//echo $this->My->makeSearchForm($title, $model, $options, $box_nums)
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
    echo '<div  id="resultsTable">';
    if (isset($results[0]['Bioactivitypfr_data'])){
       $names = array($this->Paginator->sort('bioactivity_name', 'Name', ['data' => $data]),
           $this->Paginator->sort('sample_ref', 'Sample Reference',['data' => $data]),
           $this->Paginator->sort('reference', 'Experiment Reference',['data' => $data]),
           $this->Paginator->sort('value','Value', ['data' => $data]),
           $this->Paginator->sort('unit_description', 'Units', ['data' => $data]),
           $this->Paginator->sort('bioassay_description', 'Bioassay', ['data' => $data]),
           $this->Paginator->sort('crop', 'Crop',['data' => $data]),
           $this->Paginator->sort('genotype', 'Genotype', ['data' => $data]),
           $this->Paginator->sort('tissue', 'Tissue', ['data' => $data]));
       $cols = array('bioactivity_name', 'sample_ref', 'reference', 'value', 'unit_description', 'bioassay_description', 'crop', 'genotype','tissue');
       $type = 'none';
       echo $this->element('results_table', ['results' => $results, 'names' => $names, 'cols' => $cols, 'model' => $model, 'type' => $type, 'data' => $data, 'num' => $num]);
    } else if (isset($results)){
        echo "No Data found";
    }
    echo '</div>';

