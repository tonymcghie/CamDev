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
    
<?php
/**$this->Html->script('HelperScripts_'.getenv('CSS_VERSION'), array('inline' => false));
if (!isset($box_nums)){$box_nums=1;} //sets the box nums for the first time
echo $this->element('search_form', ['title' => $title, 'model' => $model, 'options' => $options, 'box_nums' => $box_nums]);

if (isset($results[0]['Compound'])){ 
 
    echo $this->Html->tableCells([$this->Form->radio('display',['monoisotopic mass' => 'monoisotopic mass', 'negative ions' => 'negative ions', 'positive ions' => 'positive ions'], ['id' => 'display', 'value' => 'monoisotopic mass'])]);
}
echo '</table></header>';

echo '<div  id="resultsTable">'; 
if (isset($results[0]['Compound'])){     
    foreach ($results as &$row){ //sets the colums for the negative and positive view
        $row['Compound']['[M-H]-']=$row['Compound']['exact_mass']-1.0078;
        $row['Compound']['[M+COOH-H]-']=$row['Compound']['exact_mass']+44.9977;
        $row['Compound']['[M+H]+']=$row['Compound']['exact_mass']+1.0078;
        $row['Compound']['[M+Na]+']=$row['Compound']['exact_mass']+22.9898;
    }    
    $names = array($this->Paginator->sort('compound_name', 'Name', ['data' => $data]),
        'Actions' ,
        $this->Paginator->sort('exact_mass', 'Exact Mass', ['data' => $data]),
        $this->Paginator->sort('exact_mass', '[M-H]-', ['data' => $data]),
        $this->Paginator->sort('exact_mass', '[M+COOH-H]-', ['data' => $data]),
        $this->Paginator->sort('exact_mass', '[M+H]+', ['data' => $data]),
        $this->Paginator->sort('exact_mass', '[M+Na]+', ['data' => $data]),
        $this->Paginator->sort('cas', 'CAS', ['data' => $data]),
        $this->Paginator->sort('formula', 'Formula', ['data' => $data]));
    $cols = array('compound_name', 'Actions', 'exact_mass', '[M-H]-', '[M+COOH-H]-','[M+H]+','[M+Na]+','cas', 'formula');
    $model = 'Compound';
    $type = 'Compound';
    echo $this->element('results_table', ['results' => $results, 'names' => $names, 'cols' => $cols, 'model' => $model, 'type' => $type, 'data' => $data, 'num' => $num]);      
} else if (isset($results)) {
    echo "No Compounds Found";
}
 echo '</div>';*/
?>


