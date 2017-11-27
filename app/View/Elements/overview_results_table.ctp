<table class="table table-striped table-hover">
    <?php
    $headings = [];
    $heading = 'Sample Set';
    //var_dump($results);
    //echo $this->Html->tableHeaders($headings);
    //foreach ($results as $row){
        //echo $this->Html->tableCells($results);
        
    //}
    //echo $this->Html->tableHeaders($heading);
    foreach ($results as $row){
        //var_dump($row);
        echo $this->Html->tableCells(array_values($row[$model]));
    }
    ?>
</table>