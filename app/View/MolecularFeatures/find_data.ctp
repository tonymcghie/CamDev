<?php
$title = "Find Metabolomic Data";
$model = "Molecular_feature";
$options = ['experiment_reference' => 'Experiment Reference',
    'all' => 'All',
    'feature_tag' => 'Metabolite Tag',
    'mz' => 'Exact m/z',
    'exact_mass_10mDa' => 'Exact Mass +- 10 mDa',
    'exact_mass_50mDa' => 'Exact Mass +- 50 mDa',
    'ms_instrument_loc' => 'MS Instrument',
    'sample_reference' => 'Sample Reference',
    'sample_description' => 'Sample Description',
    'crop' => 'Crop',
    'genus_species' => 'Species',
    'tissue' => 'Tissue',
    'genotype' => 'Genotype',
    'analyst' => 'Analyst',
    'file' => 'File'];
    //'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data[$model]['start_date'] : '2000-01-01')
echo $this->element('search_form', ['model' => $model, 'title' => $title, 'category_options' => $options]); ?>
<div id="search-results">

</div>
