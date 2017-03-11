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
    'analyst' => 'Analyst');

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
<?php echo $this->Html->tableCells(['<label>Review</label>','<label>By</label>','<label>Match</label>','<label>For</label>']); ?>
</table>
<?php
echo'<table class="noFormat search">';
echo $this->Html->tableCells([$this->Form->create('review', ['type' => 'file']),
$this->Form->input('cri_', ['options' => $options, 'label' => '']),
$this->Form->input('by_', array('label' => '')),
$this->Form->input('match_', array('label' => '','options' => ['contain' => 'Contains', 'exact' => 'Exactly', 'starts_with' => 'Starts with'])),
$this->Form->input('for_', ['options' => $options, 'label' => '']),
$this->Form->end(['label' => 'Review Data >>'])]);         
echo'</table>';
?>
</section>
    

<?php
//$output[0] = " ";  //stops an error when page is first accessed to set up the Review criteria, but the first tiem in the list is not printed ????
echo "<div class='scrollable'>";
foreach ($output as $line) {
    echo $line, "<br>";
}
echo "</div>";
?>
