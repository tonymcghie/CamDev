<?php
$title = "Find Unknown Compounds";
$model = "Metabolite";
$options = array( //sets the options in the criteria select
'sources' => 'Source',
'all' => 'All',
'exact_mass' => 'Exact Mass',
'experiment_ref' => 'Experiment Reference',
'sources' => 'Source',
'tissue' => 'Tissue',
'chemist' => 'Chemist',
'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data[$model]['start_date'] : '2000-01-01'));

echo $this->element('search_form', ['model' => $model, 'title' => $title, 'category_options' => $options]); ?>

<div id="search-results">

</div>

