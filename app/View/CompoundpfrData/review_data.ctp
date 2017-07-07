<?php
$title = "Review PFR Data - Compounds";
$model = "Compoundpfr_data";
$options_a = array(
    'crop' => 'Crop',
    'genotype' => 'Genotype',
    'tissue' => 'Tissue',
    'species' => 'Species',
    'reference' => 'Exp. Reference',
    'analyst' => 'Analyst',
    'sample_ref' => 'Sample Ref.',
    'assigned_name' => 'Compound',
    'cas' => 'CAS',
    'exact_mass' => 'Exact Mass',
    'intensity_description' => 'Units');

$options_b = array(
    'crop' => 'Crop',
    'genotype' => 'Genotype',
    'tissue' => 'Tissue',
    'species' => 'Species',
    'reference' => 'Exp. Reference',
    'analyst' => 'Analyst',
    'sample_ref' => 'Sample Ref.',
    'assigned_name' => 'Compound',
    'cas' => 'CAS',
    'exact_mass' => 'Exact Mass',
    'intensity_description' => 'Units');

//TODO $options_a and $options_b are identival so one should be removed if you dont have other plans for them

$this->Html->script('HelperScripts_'.getenv('CSS_VERSION').'.min', array('inline' => false));
if (!isset($box_nums)){$box_nums=1;} //sets the box nums for the first time
//echo $this->My->makeSearchForm($title, $model, $options, $box_nums)
        //echo $this->element('search_form', ['title' => $title, 'model' => $model, 'options' => $options, 'box_nums' => $box_nums]);
?>
<header>
    <h1><?= $title ?></h1>
    <p>Select and enter values; then click on Review Data:</p>
</header>
    <section id="boxes" class="noFormat">
    <table class="noFormat search">
        <?= $this->Html->tableCells(['<label>Review</label>','<label>By (enter value)</label>','<label>Match</label>','<label>For</label>']); ?>
    </table>
    <table class="noFormat search">
    <?= $this->Html->tableCells([$this->Form->create('review', ['type' => 'file']),
    $this->Form->input('cri', ['options' => $options_a, 'label' => '']),
    $this->Form->input('by', array('label' => '')),
    $this->Form->input('match', array('label' => '','options' => ['contain' => 'Contains', 'exact' => 'Exactly', 'starts_with' => 'Starts with'])),
    $this->Form->input('for', ['options' => $options_b, 'label' => '', 'default' => 'assigned_name']),
    $this->Form->end(['label' => 'Review Data >>'])]); ?>      
    </table>
</section>
    
<?php
if (!empty($data)) {
    echo $this->element('basic_results_table', ['label' => $options_b[$data['review']['for']], 'output' => $output]);
}
?>
