<?php
// Pre conditions
assert(isset($model), '\'$model\' is required by this view');
/** @var string $model */

$criteria_options = [
    ['value' => 'compound_name', 'text' => 'Compound Name'],
    ['value' => 'all', 'text' => 'All'],
    ['value' => 'cas', 'text' => 'CAS'],
    ['value' => 'compound_type', 'text' => 'Chemical Class'],
    ['value' => 'exact_mass', 'text' => 'Exact Mass'],
    ['value' => '[M-H]-', 'text' => '[M-H]-'],
    ['value' => '[M+COOH-H]-', 'text' => '[M+COOH-H]-'],
    ['value' => '[M+H]+', 'text' => '[M+H]+'],
    ['value' => '[M+Na]+', 'text' => '[M+Na]+'],
    ['value' => 'pub_chem', 'text' => 'PubChem CID'],
    ['value' => 'chemspider_id', 'text' => 'ChemSpider ID'],
    ['value' => 'comment', 'text' => 'Additional Info']];

echo  $this->element('search_form', ['model' => $model,
    'title' => 'Find Compounds',
    'criteria_options' => $criteria_options]);
if (isset($results)) {
    echo $this->element('search_results_table', ['results' => $results,
        'model' => $model,
        'num' => $num,
        'initialColumns' => $cols]);
}
?>


