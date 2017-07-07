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
    'ms_instrument_loc'=> 'MS Instrument',
    'intensity_description' => 'Units');

$options_b = array(
    'crop' => 'Crop',
    'genotype' => 'Genotype',
    'tissue' => 'Tissue',
    'genus_species' => 'Species',
    'experiment_reference' => 'Experiment Reference',
    'analyst' => 'Analyst',
    'sample_reference' => 'Sample Reference',
    'feature_tag' => 'Feature Tag',
    'ms_instrument_loc'=> 'MS Instrument',
    'intensity_description' => 'Units');

$this->Html->script('HelperScripts.min.js?'.filemtime('js/HelperScripts.min.js'), array('inline' => false));
if (!isset($box_nums)){$box_nums=1;} //sets the box nums for the first time
//echo $this->My->makeSearchForm($title, $model, $options, $box_nums)
        //echo $this->element('search_form', ['title' => $title, 'model' => $model, 'options' => $options, 'box_nums' => $box_nums]);
?>
<header>
    <h1><?= $title; ?></h1>
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
    $this->Form->input('for', ['options' => $options_b, 'label' => '', 'default' => 'experiment_reference']),
    $this->Form->end(['label' => 'Review Data >>'])]); ?>     
    </table>
</section>
    
<?php
if (!empty($data)) {
    $values = ['label' => $options_b[$data['review']['for']], 'output' => $output];
    echo $this->element('basic_results_table', $values);
}
?>
