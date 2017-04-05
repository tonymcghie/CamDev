<header>
<?php
$title = "Find Unknown Compounds";
$model = "Metabolite";
$options = array( //sets the options in the criteria select
'exact_mass' => 'Exact Mass',
'all' => 'All',
'experiment_ref' => 'Experiment Reference',
'sources' => 'Source',
'tissue' => 'Tissue',
'chemist' => 'Chemist',
'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data[$model]['start_date'] : '2000-01-01'));

$this->Html->script('HelperScripts_'.getenv('CSS_VERSION'), array('inline' => false));
if (!isset($box_nums)){$box_nums=1;} //sets the box nums for the first time
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
     * adds another input pair Uses a function from the helper scripts file
     */
    function add(){
        $('#boxes').append(getNewBox(boxnum, cols,names,'<?php echo $model; ?>')); //adds the new boxes the the section
        boxnum++; //increases the number of boxes passed to and from the view and controller
        $('#box_nums').val(boxnum); //updates the hidden input
    }
 </script>
<?php
echo '<div  id="resultsTable" class="searchMetabolite">';
if (isset($results[0]['Metabolite'])){
    $names = array($this->Paginator->sort('exact_mass', 'Exact Mass', ['data' => $data]),          //sets the names of the colums in the results table
        'Actions' ,
        $this->Paginator->sort('id', 'ID', ['data' => $data]),
        $this->Paginator->sort('ion_type', 'Ion Type', ['data' => $data]),
        $this->Paginator->sort('rt_value', 'Retention Value', ['data' => $data]),
        $this->Paginator->sort('rt_description', 'Retention Description', ['data' => $data]),
        $this->Paginator->sort('sources', 'Sources', ['data' => $data]),
        $this->Paginator->sort('tissue', 'Tissue', ['data' => $data]),
        $this->Paginator->sort('chemist', 'Chemist', ['data' => $data]),
        $this->Paginator->sort('experiment_ref', 'Experiment Reference', ['data' => $data]),
        $this->Paginator->sort('spectra_uv', 'UV/vis Spectra', ['data' => $data]),
        $this->Paginator->sort('spectra_nmr', 'NMR Spectra', ['data' => $data]),
        $this->Paginator->sort('date', 'Start Date', ['data' => $data]));
    $cols = array('exact_mass', 'Actions', 'id', 'ion_type', 'rt_value', 'rt_description','sources','tissue','chemist','experiment_ref','spectra_uv','spectra_nmr','date'); //sets the corresonding colum names in the database
    $model = 'Metabolite';
    $type = 'Metabolite';
    echo $this->element('results_table', ['results' => $results, 'names' => $names, 'cols' => $cols, 'model' => $model, 'type' => $type, 'data' => $data, 'num' => $num]); //draws the table
} else if (isset($results)){
    echo "No Metabolites Found";
} //if there are enties in the results array then darw the table if not print a message
 echo '</div>';
 ?>
<script>
    /**
     * toggles the data in and out
     */
    $("#isDate").on("click",function(){
        $("#dates").toggle(this.checked); //shows the date crieria
        if (this.checked){ //changes the label on the check box to be show or hide
            $("label[for=isDate]").text("Hide Date");
        } else {
            $("label[for=isDate]").text("Add Date Crieria");
        }
    });

    /**
     * Hides or shows the date input depeding on weather the check box is checked or not
     */
    $("document").ready(function(){
        $("#dates").toggle($("#isDate").is(":checked"));
    }); //hides or shows the dates section when the page loads

    </script>
