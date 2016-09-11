<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('tabs_'.getenv('CSS_VERSION'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
<h1>Sample View and Upload Workspace</h1>
<h2>Set Code: <?php echo $info['SampleSet']['set_code'] ?></h2>
<p>Crop: <?php echo $info['SampleSet']['crop'] ?></p>
<p>Type: <?php echo $info['SampleSet']['type'] ?></p>
</header>
<?php
echo '</table></header>';

echo '<div  id="resultsTable">'; 
//if (isset($results[0]['Sample'])){     
    $names = array($this->Paginator->sort('sample_name', 'Sample', ['data' => $data]),
        $this->Paginator->sort('treatment_1', 'Treatment#1', ['data' => $data]),
        $this->Paginator->sort('description_1', 'Description#1', ['data' => $data]),
		$this->Paginator->sort('treatment_2', 'Treatment#2', ['data' => $data]),
        $this->Paginator->sort('description_2', 'Description#2', ['data' => $data]),
		$this->Paginator->sort('treatment_3', 'Treatment#3', ['data' => $data]),
        $this->Paginator->sort('description_3', 'Description#3', ['data' => $data]),
		$this->Paginator->sort('sample_weight', 'Weight', ['data' => $data]),
		$this->Paginator->sort('weight_unit', 'Unit', ['data' => $data]),
        $this->Paginator->sort('tissue', 'Tissue', ['data' => $data]),
		$this->Paginator->sort('kea_num', 'Kea #', ['data' => $data]),
		$this->Paginator->sort('comment', 'Comment', ['data' => $data]));
    $cols = array('sample_name', 'treatment_1', 'description_1', 'treatment_2', 'description_2', 'treatment_3', 'description_3', 'sample_weight', 'weight_unit', 'tissue', 'kea_num', 'comment');
    $model = 'Sample';
    $type = 'Sample';
    echo $this->element('results_table', ['results' => $results, 'names' => $names, 'cols' => $cols, 'model' => $model, 'type' => $type, 'data' => $data, 'num' => $num]);    
//} else if (isset($results)) {
//    echo "No Data Found";
//}
 echo '</div>';
?>




