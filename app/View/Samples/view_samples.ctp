<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
echo $this->Html->css('tabs_'.getenv('CSS_VERSION'), null, array('inline' => false));
echo $this->Html->script(array('base'), array('inline' => false));
?>
<header>
<h1>Sample View and Upload Workspace</h1>
<h2>Set Code: <?php echo $info['SampleSet']['set_code'] ?></h2>
<?php
echo '</table></header>';

echo '<div  id="resultsTable">'; 
//if (isset($results[0]['Compound'])){     
    $names = array($this->Paginator->sort('sample_name', 'Sample', ['data' => $data]),
        $this->Paginator->sort('treatment_1', 'Treatment#1', ['data' => $data]),
        $this->Paginator->sort('description_1', 'Description#1', ['data' => $data]),
        $this->Paginator->sort('tissue', 'Tissue', ['data' => $data]));
    $cols = array('sample_name', 'treatment_1', 'description_1', 'tissue');
    $model = 'Sample';
    $type = 'Sample';
    echo $this->element('results_table', ['results' => $results, 'names' => $names, 'cols' => $cols, 'model' => $model, 'type' => $type, 'data' => $data, 'num' => $num]);    
//} else if (isset($results)) {
//    echo "No Data Found";
//}
 echo '</div>';
?>


<?php if (count($results)<=0): ?>
<h2>No Data Found Out</h2>
<ol>
    <li id="add"><a href="">+</a></li>
</ol>
<?php endif; ?>
</header>
