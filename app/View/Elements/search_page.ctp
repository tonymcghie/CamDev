<?php
//'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data['SampleSet']['start_date'] : '2000-01-01'));

// Pre conditions
assert(isset($model), '\'$modeldefined variable: \' is required by this view');
/** @var string $model */
/** @var array $options */
/** @var array $cols */
/** @var array $data */
/** @var array $results */
/** @var int num */

$criteria_options = [];
foreach ($options as $option) {
    $criteria_options[] = ['value' => $option, 'text' => $this->String->get_string($option, $model)];
}

echo  $this->element('search_form', ['model' => $model,
    'data' => isset($data) ? $data : null,
    'criteria_options' => $criteria_options]);
if (isset($results)) {
    assert(isset($num), '\'$num\' the number of results must be set');
    assert(isset($cols), '\'$cols\' the initial columns to display must be set');

    echo $this->element('search_table', ['results' => $results,
        'model' => $model,
        'num' => $num,
        'initialColumns' => $cols]);
}
?>
