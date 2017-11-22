<?php
$title = "Find PFR Compound Data";
$model = "Compoundpfr_data";
$options = [
        'assigned_name' => 'Compound Name',
    'all' => 'All',
    'assigned_confid' => 'Id Confidence (1-5)',
    'exact_mass' => 'Exact Mass',
    'exact_mass_10mDa' => 'Exact Mass +- 10 mDa',
    'exact_mass_50mDa' => 'Exact Mass +- 50 mDa',
    'intensity_description' => 'Units',
    'reference' => 'Experiment Reference',
    'sample_ref' => 'Sample Reference',
    'sample_description' => 'Sample Description',
    'crop' => 'Crop',
    'species' => 'Species',
    'tissue' => 'Tissue',
    'genotype' => 'Genotype',
    'analyst' => 'Analyst',
    'file' => 'File'];
    //'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data[$model]['start_date'] : '2000-01-01'));
echo $this->element('search_form', ['model' => $model, 'title' => $title, 'category_options' => $options]); ?>
    
<div id="search-results">

</div>
