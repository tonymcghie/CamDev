<?php
// Pre conditions
assert(isset($model), '\'$model\' is required by this view');
/** @var string $model */


//'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data['SampleSet']['start_date'] : '2000-01-01'));
// //'p_name' => $this->String->get_string('p_name', 'SampleSet'),

$criteria_options = [
    ['value' => 'set_code', 'text' => 'Set Code'],
    ['value' => 'all', 'text' => 'All'],
    ['value' => 'submitter', 'text' => 'PFR Collaborator'],
    ['value' => 'chemist', 'text' => 'Chemist'],
    ['value' => 'p_name', 'text' => 'Project Name'],
    ['value' => 'p_code', 'text' => 'Project Code'],
    ['value' => 'crop', 'text' => 'Crop'],
    ['value' => 'compounds', 'text' => 'Compounds'],
    ['value' => 'comments', 'text' => 'Comments'],
    ['value' => 'exp_reference', 'text' => 'Experiment Reference'],
    ['value' => 'team', 'text' => 'Team']];

echo  $this->element('search_form', ['model' => $model,
    'title' => 'Find Sample Set',
    'criteria_options' => $criteria_options]);
if (isset($results)) {
    echo $this->element('search_results_table', ['results' => isset($results) ? $results : null,
        'model' => $model,
        'num' => isset($num) ? $num : null,
        'initialColumns' => isset($cols) ? $cols : null]);
}
?>
