<header>
<?php
$title = "Search PFR Compound Data";
$model = "Compoundpfr_data";
$options = ['empty' => 'Select Criteria',
    'all' => 'All',
    'assigned_name' => 'Compound Name',
    'assigned_confid' => 'Id Confidence (1-5)',
    'exact_mass' => 'Exact Mass',
    'exact_mass_10mDa' => 'Exact Mass +- 10 mDa',
    'exact_mass_50mDa' => 'Exact Mass +- 50 mDa',
    'intensity_description' => 'Units',
    'reference' => 'Experiment Ref.',
    'sample_ref' => 'Sample Ref.',
    'sample_description' => 'Sample Description',
    'crop' => 'Crop',
    'species' => 'Species',
    'tissue' => 'Tissue',
    'genotype' => 'Genotype',
    'analyst' => 'Analyst',
    'file' => 'File'];
    //'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data[$model]['start_date'] : '2000-01-01'));
echo $this->element('search_form', ['model' => $model, 'title' => $title, 'category_options' => $options]); ?>
    
<div id="search-results">

</div>

<script>
//    var boxnum=<?php echo $box_nums; ?>;    
//    var cols =<?php echo json_encode(array_keys($options)); ?>;
//    var names = <?php echo json_encode(array_values($options)); ?>;
//    cols.splice(cols.length-1,1);  //removes the date option
//    names.splice(names.length-1,1); //removes the date option
//    /**
//     * adds another input pair    
//     */
//    function add(){
//        $('#boxes').append(getNewBox(boxnum, cols,names,'<?php echo $model; ?>')); //adds the new boxes the the section
//        boxnum++; //increases the number of boxes passed to and from the view and controller
//        $('#box_nums').val(boxnum); //updates the hidden input
//    }
 </script>
</header>
 <?php    
// echo '<code>';
// var_dump($this->Paginator>paging);
// echo '</code>';
//$this->Paginator->settings['limit'] = 30;
//    echo '<div  id="resultsTable">';
//    if (isset($results[0]['Compoundpfr_data'])){
//	   $names = array( $this->Paginator->sort('assigned_name', 'Name', ['data' => $data]),
//           array('Actions' => ['class' => 'Buttons']),
//           $this->Paginator->sort('sample_ref', 'Sample Ref.',['data' => $data]),
//           $this->Paginator->sort('reference', 'Experiment Ref.',['data' => $data]),
//           $this->Paginator->sort('exact_mass','Exact Mass', ['data' => $data]),
//           $this->Paginator->sort('intensity_value', 'Intensity', ['data' => $data]),
//           $this->Paginator->sort('intensity_description', 'Units', ['data' => $data]),
//           $this->Paginator->sort('crop', 'Crop',['data' => $data]),
//           $this->Paginator->sort('genotype', 'Genotype', ['data' => $data]),
//           $this->Paginator->sort('tissue', 'Tissue', ['data' => $data]),
//		   $this->Paginator->sort('analyst', 'Analyst', ['data' => $data]));
//       $cols = array('assigned_name', 'Actions', 'sample_ref', 'reference', 'exact_mass', 'intensity_value', 'intensity_description', 'crop', 'genotype','tissue', 'analyst', );	
//       $type = 'CompoundpfrData';
//       echo $this->element('results_table', ['results' => $results, 'names' => $names, 'cols' => $cols, 'model' => $model, 'type' => $type, 'data' => $data, 'num' => $num]);
//    } else if (isset($results)){
//        echo "No Data found";
//    }
//    echo '</div>';

