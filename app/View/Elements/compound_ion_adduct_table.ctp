<table class="table table-striped table-hover">
    <?php
    $headings = [];
    foreach ($cols as $heading){
        $headings[] = $this->String->get_string($heading, $model);
    }
    echo $this->Html->tableHeaders($headings);
    foreach ($ion_adducts as $row){
        echo $this->Html->tableCells($row);
    }
    ?>
</table>