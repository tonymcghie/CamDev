<?php
$title = "Find Compounds";
$model = "Compound";
$options = ['compound_name' => 'Compound Name',
'all' => 'All', 
'cas' => 'CAS',
'compound_type' => 'Chemical Class',
'exact_mass' => 'Exact Mass',
'[M-H]-' => '[M-H]-',
'[M+COOH-H]-' => '[M+COOH-H]-',
'[M+H]+' => '[M+H]+',
'[M+Na]+' => '[M+Na]+',
'pub_chem' => 'PubChem CID',
'chemspider_id' => 'ChemSpider ID',
'comment' => 'Additional Info'];

echo $this->element('search_form', ['model' => $model, 'title' => $title, 'category_options' => $options]); ?>
 
<div id="search-results">

</div>

