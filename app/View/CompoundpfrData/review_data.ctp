<header>
<?php
$title = "Review PFR Data - Compounds";
$model = "Compoundpfr_data";
$options = array(
    'empty' => 'Select Criteria',
    'assigned_name' => 'Compound',
    'cas' => 'CAS',
    'assigned_confid' => 'Id Confidence (1-5)',
    'exact_mass' => 'Exact Mass',
    'intensity_description' => 'Units',
    'reference' => 'Experiment Ref.',
    'sample_ref' => 'Sample Ref.',
    'sample_description' => 'Sample Description',
    'crop' => 'Crop',
    'species' => 'Species',
    'tissue' => 'Tissue',
    'genotype' => 'Genotype',
    'analyst' => 'Analyst',
    'file' => 'File');

$this->Html->script('HelperScripts_'.getenv('CSS_VERSION'), array('inline' => false));
if (!isset($box_nums)){$box_nums=1;} //sets the box nums for the first time
//echo $this->My->makeSearchForm($title, $model, $options, $box_nums)
        //echo $this->element('search_form', ['title' => $title, 'model' => $model, 'options' => $options, 'box_nums' => $box_nums]);
?>
<header>
<h1><?php echo $title; ?></h1>
<p>Select and enter values; then click on Review Data:</p>
</header>
<section id="boxes" class="noFormat">
<table class="noFormat search">
<?php echo $this->Html->tableCells(['<label>Review</label>','<label>Value</label>','<label>Match</label>','<label>For</label>']); ?>
</table>
<?php
    /**echo $this->Form->create('review', ['type' => 'file']);
    echo $this->Form->input('cri_', ['options' => $options, 'label' => '']);
    echo $this->Form->input('val_', array('label' => ''));
    echo $this->Form->input('match_', array('label' => '','options' => ['contain' => 'Contains', 'exact' => 'Exactly', 'starts_with' => 'Starts with']));
    echo $this->Form->input('for_', ['options' => $options, 'label' => '']);
    echo $this->Form->end('Review Data>>');*/
echo'<table class="noFormat search">';
echo $this->Html->tableCells([$this->Form->create('review', ['type' => 'file']),
$this->Form->input('cri_', ['options' => $options, 'label' => '']),
$this->Form->input('val_', array('label' => '')),
$this->Form->input('match_', array('label' => '','options' => ['contain' => 'Contains', 'exact' => 'Exactly', 'starts_with' => 'Starts with'])),
$this->Form->input('for_', ['options' => $options, 'label' => '']),
$this->Form->end(['label' => 'Review Data >>'])]);         
echo'</table>';
?>
</section>

<?php
echo "<div class='scrollable'>";
echo '<table style="background-color: rgba(252, 252, 252, 0.75)">';
echo $this->Html->tableHeaders('Compound');
echo $this->Html->tableCells($output);
echo var_dump($output),"<br>";
echo "</table>";
echo "</div>";
/**echo '<div  id="resultsTable">';
    if (isset($results[0]['Compoundpfr_data'])){
	   $names = array( $this->Paginator->sort('assigned_name', 'Name', ['data' => $data]),
           array('Actions' => ['class' => 'Buttons']),
           $this->Paginator->sort('sample_ref', 'Sample Ref.',['data' => $data]),
           $this->Paginator->sort('reference', 'Experiment Ref.',['data' => $data]),
           $this->Paginator->sort('exact_mass','Exact Mass', ['data' => $data]),
           $this->Paginator->sort('intensity_value', 'Intensity', ['data' => $data]),
           $this->Paginator->sort('intensity_description', 'Units', ['data' => $data]),
           $this->Paginator->sort('crop', 'Crop',['data' => $data]),
           $this->Paginator->sort('genotype', 'Genotype', ['data' => $data]),
           $this->Paginator->sort('tissue', 'Tissue', ['data' => $data]),
		   $this->Paginator->sort('analyst', 'Analyst', ['data' => $data]));
       $cols = array('assigned_name', 'Actions', 'sample_ref', 'reference', 'exact_mass', 'intensity_value', 'intensity_description', 'crop', 'genotype','tissue', 'analyst', );	
       $type = 'CompoundpfrData';
       echo $this->element('results_table', ['results' => $results, 'names' => $names, 'cols' => $cols, 'model' => $model, 'type' => $type, 'data' => $data, 'num' => $num]);
    } else if (isset($results)){
        echo "No Data found";
    }
    echo '</div>';*/
    ?>
