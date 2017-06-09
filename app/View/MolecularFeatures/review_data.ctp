<header>
<?php
$title = "Review Metabolomics Data";
$model = "Molecular_feature";
$options_a = array(
    'crop' => 'Crop',
    'genotype' => 'Genotype',
    'tissue' => 'Tissue',
    'genus_species' => 'Species',
    'experiment_reference' => 'Experiment Reference',
    'analyst' => 'Analyst',
    'sample_reference' => 'Sample Reference',
    'feature_tag' => 'Feature Tag',
    'exact_mass' => 'Exact Mass',
    'ms_instrument_loc'=> 'MS Instrument',
    'intensity_description' => 'Units');

$options_b = array(
    'experiment_reference' => 'Experiment Reference',
    'feature_tag' => 'Feature Tag',
    'exact_mass' => 'Exact Mass',
    'intensity_description' => 'Units',
    'sample_reference' => 'Sample Reference',
    'crop' => 'Crop',
    'genus_species' => 'Species',
    'tissue' => 'Tissue',
    'genotype' => 'Genotype',
    'ms_instrument_loc'=> 'MS Instrument',
    'analyst' => 'Analyst');

$this->Html->script('HelperScripts_'.getenv('CSS_VERSION').'.min', array('inline' => false));
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
<?php echo $this->Html->tableCells(['<label>Review</label>','<label>By (enter value)</label>','<label>Match</label>','<label>For</label>']); ?>
</table>
<?php
echo'<table class="noFormat search">';
echo $this->Html->tableCells([$this->Form->create('review', ['type' => 'file']),
$this->Form->input('cri', ['options' => $options_a, 'label' => '']),
$this->Form->input('by', array('label' => '')),
$this->Form->input('match', array('label' => '','options' => ['contain' => 'Contains', 'exact' => 'Exactly', 'starts_with' => 'Starts with'])),
$this->Form->input('for', ['options' => $options_b, 'label' => '']),
$this->Form->end(['label' => 'Review Data >>'])]);         
echo'</table>';
?>
</section>
    

<?php
//displays the data ($output) at a simple list of values
echo "<div class='scrollable'>";
if (isset($output)){
    if ($num >= 1) {
        foreach ($output as $line) {
            echo $line, "<br>";
        }
    } else if (isset($output)){
        echo "No Data found";
    }
}
echo "</div>";
?>
