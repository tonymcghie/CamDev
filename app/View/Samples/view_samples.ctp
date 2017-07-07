<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('tabs.css?'.filemtime('css/tabs.css'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
<h1>Sample View Workspace</h1>
<h2 style="display:inline">Set Code: <?php echo $info['SampleSet']['set_code'] ?></h2>
<p style="display:inline">Crop: <?php echo $info['SampleSet']['crop'] ?></p>
<p style="display:inline">Type: <?php echo $info['SampleSet']['type'] ?></p>
</header>
<?php
echo '</table></header>';

echo '<div  id="resultsTable">'; 
if (isset($results[0]['Sample'])){     
    $names = array($this->Paginator->sort('sample_name', 'Sample', ['data' => $data]),
        $this->Paginator->sort('treatment_1', 'Attribute#1', ['data' => $data]),
        $this->Paginator->sort('description_1', 'Description#1', ['data' => $data]),
	$this->Paginator->sort('treatment_2', 'Attribute#2', ['data' => $data]),
        $this->Paginator->sort('description_2', 'Description#2', ['data' => $data]),
	$this->Paginator->sort('treatment_3', 'Attribute#3', ['data' => $data]),
        $this->Paginator->sort('description_3', 'Description#3', ['data' => $data]),
        $this->Paginator->sort('replicate', 'Rep', ['data' => $data]),
	$this->Paginator->sort('sample_weight', 'Weight', ['data' => $data]),
	$this->Paginator->sort('weight_unit', 'Unit', ['data' => $data]),
        $this->Paginator->sort('tissue', 'Tissue', ['data' => $data]),
	$this->Paginator->sort('kea_num', 'Kea #', ['data' => $data]),
        $this->Paginator->sort('eBrida_ref', 'eBrida #', ['data' => $data]),
	$this->Paginator->sort('comment', 'Comment', ['data' => $data]));
    $cols = array('sample_name', 'treatment_1', 'description_1', 'treatment_2', 'description_2', 'treatment_3', 'description_3', 'replicate', 'sample_weight', 'weight_unit', 'tissue', 'kea_num', 'ebrida_ref','comment');
    $model = 'Sample';
    $type = 'Sample';
    //echo "view_samples:", var_dump($data['SampleSet']['set_code']), "<br>";
    echo $this->element('results_table', ['results' => $results, 'names' => $names, 'cols' => $cols, 'model' => $model, 'type' => $type, 'data' => $data, 'num' => $num]);    
} else if (isset($results)) {
    echo "<br>", "No Samples have been loaded for this Sample Set!";
}
 echo '</div>';
?>




