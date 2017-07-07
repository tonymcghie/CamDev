<header>
<?php
$title = "Find Sample Sets";
$model = "SampleSet";
$options = array(
'set_code' => 'Set Code',
'all' => 'All',
'submitter' => 'PFR Collaborator',
'chemist' => 'Chemist',
'p_name' => 'Project Name',
'p_code' => 'Project Code',
'crop' => 'Crop',
'compounds' => 'Compounds',
'comments' => 'Comments',
'exp_reference' => 'Experiment Reference',
'team' => 'Team',
'status' => 'Status',
'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data['SampleSet']['start_date'] : '2000-01-01'));

$this->Html->script('HelperScripts.min.js?'.filemtime('js/HelperScripts.min.js'), array('inline' => false));

if (!isset($box_nums))$box_nums=1; //sets the box nums for the first time
echo $this->element('search_form', ['title' => $title, 'model' => $model, 'options' => $options, 'box_nums' => $box_nums]);
?>
</header>
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

 <?php
    echo '<div  id="resultsTable">';
    if (isset($results[0]['SampleSet'])){       
       $names = array( $this->Paginator->sort('set_code', 'Code', ['data' => $data]),
           array('Actions' => ['class' => 'Buttons']),
           $this->Paginator->sort('status', 'Status', ['data' => $data]),
           $this->Paginator->sort('submitter', 'PFR Collaborator', ['data' => $data]),
           $this->Paginator->sort('chemist', 'Chemist', ['data' => $data]),
           $this->Paginator->sort('crop', 'Crop', ['data' => $data]),
           $this->Paginator->sort('type', 'Type', ['data' => $data]),
           $this->Paginator->sort('number', 'Number', ['data' => $data]),
           $this->Paginator->sort('compounds', 'Compounds', ['data' => $data]),
           $this->Paginator->sort('comments', 'Comments', ['data' => $data]));
       $cols = array('set_code', 'Actions', 'status', 'submitter', 'chemist', 'crop', 'type', 'number', 'compounds','comments');
       $type = 'SampleSet';
       echo $this->element('results_table', ['results' => $results, 'names' => $names, 'cols' => $cols, 'model' => $model, 'type' => $type, 'data' => $data, 'num' => $num]);
    } else if (isset($results)){
        echo "No Sample Sets Found";
    }
    echo '</div>';

