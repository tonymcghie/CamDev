<?php if (!empty($results)): ?>
    <?php
    // Pre conditions
    assert(isset($num), '\'$num\' is required when \'$results\' is not empty');
    /** @var int $num */
    assert(isset($column), '\'$column\' is required when \'$results\' is not empty');
    /** @var array $initialColumns */
    assert(isset($model), '\'$model\' is required when \'$results\' is not empty');
    /** @var string $model */
    ?>

    <div id="search-results">
        <h2>Overview Results for <?php echo $this->String->get_string($column, $model); ?> (n=<?php echo $num; ?>)</h2>
        
        <div class="results-table">
            <table class="table table-striped table-hover">
                <?php
                foreach ($results as $row){
                    echo "<tr>", "<td>", $row->getSpecifiedTableRowData($column), "</td>", "</tr>";
                    //$row->actions = $this->element($model.DS.'actions', ['data' => $row->getActionData()]);
                }
                ?>
            </table>
        </div>
    </div>
<?php else: ?>
    <span class="no-results"><?= $this->String->get_string('noresults', 'Overview_form')?></span>
<?php endif; ?>