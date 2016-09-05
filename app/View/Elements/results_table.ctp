<?php
$this->Paginator->options(array(
    'update' => '#resultsTable',
    'evalScripts' => true
));

if (isset($results)){
    echo '<table class="ResNum noFormat">';
    $tempRes = '<span>Results: '.$num.'</span>';
    if (isset($data)){
        $tempExp = $this->Form->postLink('Export Data', ['action' => 'export', http_build_query($data)], ['style'=>'width: 80px', 'class' => 'find-button abbr-button']);
    }
    if ($num != 0){
            $tempPg = '<span>';
            $tempPg .= $this->Paginator->first('First', ['data' => $data]); //These make the links to other pages the get allows the links to pass the search paramaters to the controller through ajax
            if($this->Paginator->hasPrev()){
                    $tempPg .= $this->Paginator->prev('Prev', ['data' => $data]);
            }
            $tempPg .= $this->Paginator->numbers(['modulus' => 4, 'data' => $data]);
            if($this->Paginator->hasNext()){
                $tempPg .= $this->Paginator->next('Next' ,['data' => $data]);
            }
            $tempPg .= $this->Paginator->last('Last', ['data' => $data]);
            if (!$this->Paginator->hasPrev()&&!$this->Paginator->hasNext()){
                $tempPg .= '1';
            }
            $tempPg .= '</span>';
    }
    echo $this->Html->tableCells([$tempRes, $tempExp, $tempPg]);
    echo '</table>';
    echo $this->My->makeResultsTable($results, array( //makes the table
        'names' => $names,
        'cols' => $cols,
        'model' => $model,),
        $type, (isset($isTablet) ? $isTablet : ''));
}
echo $this->Js->writeBuffer();
