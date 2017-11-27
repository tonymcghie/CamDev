<?php
// Pre conditions
assert(isset($model), '\'$model\' is required by this view');
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
    echo $this->element('Compound/search_table', ['results' => $results,
        'model' => $model,
        'num' => $num,
        'initialColumns' => $cols]);
}
?>


