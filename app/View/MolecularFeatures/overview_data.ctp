<?php
$title = "Overview Metabolomic Data";
$model = "molecular_features";
$by_options = array(
    'crop' => 'Crop',
    'genotype' => 'Genotype',
    'tissue' => 'Tissue',
    'genus_species' => 'Species',
    'experiment_reference' => 'Experiment Reference (eg Set Code)',
    'sample_reference' => 'Sample Reference',
    'analyst' => 'Analyst',
    'feature_tag' => 'Feature Tag',
    'ms_instrument_loc' => 'MS Instrument',
    'ion_polarity' => 'Ion Polarity');

$for_options = array(
    'experiment_reference' => 'Experiment Reference (eg Set Code)',
    'crop' => 'Crop',
    'genotype' => 'Genotype',
    'tissue' => 'Tissue',
    'genus_species' => 'Species',
    'sample_reference' => 'Sample Reference',
    'analyst' => 'Analyst',
    'feature_tag' => 'Feature Tag',
    'ms_instrument_loc' => 'MS Instrument',
    'ion_polarity' => 'Ion Polarity');

echo $this->element('overview_form', ['model' => $model, 'title' => $title, 'by_options' => $by_options, 'for_options' => $for_options]); ?>

<div id="search-results">

</div>
    

