<?php
// Pre conditions
assert(isset($model), '\'$model\' is required by this view');
/** @var string $model */


//'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data['SampleSet']['start_date'] : '2000-01-01'));



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
