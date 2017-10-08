<table class="table table-striped table-hover">
    <?php
    $headings = [];
    foreach ($cols as $heading){
        $headings[] = $this->String->get_string($heading, $model);
    }
    echo $this->Html->tableHeaders($headings);
    foreach ($results as $row){
        $row->actions = $this->element($model.DS.'actions', ['data' => $row->getActionData()]);
        //var_export($row);
        echo $this->Html->tableCells($row->getTableRowData());
    }
    ?>
</table>