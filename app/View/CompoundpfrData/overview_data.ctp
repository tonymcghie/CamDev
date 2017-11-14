<?php
$title = "Overview PFR Compound Data";
$model = "Compoundpfr_data";
$by_options = array(
    'crop' => 'Crop',
    'genotype' => 'Genotype',
    'tissue' => 'Tissue',
    'species' => 'Species',
    'reference' => 'Experiment Reference',
    'analyst' => 'Analyst',
    'sample_ref' => 'Sample Reference',
    'assigned_name' => 'Compound',
    'cas' => 'CAS',
    'exact_mass' => 'Exact Mass',
    'intensity_description' => 'Units');

$for_options = array(
    'assigned_name' => 'Compound',
    'crop' => 'Crop',
    'genotype' => 'Genotype',
    'tissue' => 'Tissue',
    'species' => 'Species',
    'reference' => 'Experiment Reference',
    'analyst' => 'Analyst',
    'sample_ref' => 'Sample Reference',
    'cas' => 'CAS',
    'exact_mass' => 'Exact Mass',
    'intensity_description' => 'Units');

echo $this->element('overview_form', ['model' => $model, 'title' => $title, 'by_options' => $by_options, 'for_options' => $for_options]); ?>

<div id="search-results">

</div>
    
<?php
if (!empty($data)) {
    $values = ['label' => $options_b[$data['review']['for']], 'output' => $output, 'controller' => 'SampleSet', 'action' => 'searchSet'];
    switch ($data['review']['for']) {
        case 'reference':
            $values['controller'] = 'SampleSets';
            $values['action'] = 'searchSet';
            $values['column'] = 'set_code';
            break;
        case 'crop':
            $values['controller'] = 'SampleSets';
            $values['action'] = 'searchSet';
            $values['column'] = 'crop';
            break;
        case 'tissue':
            $values['controller'] = 'SampleSets';
            $values['action'] = 'searchSet';
            $values['column'] = 'type';
            break;
        case 'analyst':
            $values['controller'] = 'SampleSets';
            $values['action'] = 'searchSet';
            $values['column'] = 'chemist';
            break;
        case 'cas':
            $values['controller'] = 'Compounds';
            $values['action'] = 'searchCompound';
            $values['column'] = 'cas';
            break;
        case 'exact_mass':
            $values['controller'] = 'Compounds';
            $values['action'] = 'searchCompound';
            $values['column'] = 'exact_mass';
            break;
        case 'assigned_name':
            $values['controller'] = 'Compounds';
            $values['action'] = 'searchCompound';
            $values['column'] = 'compound_name';
            break;
        default:
    }
    echo $this->element('basic_results_table', $values);
}
?>
