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
<p>Enter at least one condition to search for:</p>
</header>
<section id="boxes" class="noFormat">
<table class="noFormat search">
<?php echo $this->Html->tableCells(['<label>Review</label>','<label>Value</label>','<label>Match</label>','<label>For</label>']); ?>
</table>
<?php
    //echo $this->My->searchPair($i, $options);
echo'<table class="noFormat search">';
//echo $this->Form->create('review_criteria', array( 'type' => 'file'));
echo $this->Html->tableCells([$this->Form->input('cri_', ['options' => $options, 'label' => '']),
$this->Form->input('val_', array('label' => '')),
$this->Form->input('match_', array('label' => '','options' => ['contain' => 'Contains', 'exact' => 'Exactly', 'starts_with' => 'Starts with'])),
$this->Form->input('for_', ['options' => $options, 'label' => ''])]);
            
echo'</table>';
?>
</section>
<table class="noFormat">
 <?php echo $this->Html->tableCells(['<button type="button" onclick="add()" class="large-button anySizeButton" id="addButton">Add Search Criteria</button>', 
	$this->Form->end(['label' => 'Search', 'class' => 'large-button anySizeButton'])]); ?>
</table>
