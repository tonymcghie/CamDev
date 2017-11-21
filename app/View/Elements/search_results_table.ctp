<?php
// Pre conditions
assert(isset($results), '\'$results\' is required by this element');
/** @var array $results */
?>
<?php if (!empty($results)): ?>
    <?php
    // Pre conditions
    assert(isset($num), '\'$num\' is required when \'$results\' is not empty');
    /** @var int $num */
    assert(isset($initialColumns), '\'$initialColumns\' is required when \'$results\' is not empty');
    /** @var array $initialColumns */
    assert(isset($model), '\'$model\' is required when \'$results\' is not empty');
    /** @var string $model */
    ?>


    <div id="search-results">
        <h2>Search Results (n=<?php echo $num; ?>)</h2>
        <?= $this->Html->link('Export to CSV', ['action' => 'export', '?' => http_build_query($data)], ['class' => 'btn-xs btn-info', 'role' => 'button']);?>
        <div class="results-table">

            <table class="table table-striped table-hover">
                <?php
                $headings = [];
                foreach ($initialColumns as $column){
                    $headings[] = $this->String->get_string($column, $model);
                }
                echo $this->Html->tableHeaders($headings);
                foreach ($results as $row){
                    $row->actions = $this->element($model.DS.'actions', ['data' => $row->getActionData()]);
                    echo $this->Html->tableCells($row->getTableRowData());
                }
                ?>
            </table>

            <div class="table-page-nums">
                <span>
                    // TODO make pagination work
                    <?= $this->Paginator->first('First', ['data' => $results]); ?>
                    <?php if($this->Paginator->hasPrev())echo $this->Paginator->prev('Prev', ['data' => $results]); ?>
                    <?= $this->Paginator->numbers(['modulus' => 4, 'data' => $results]); ?>
                    <?php if ($this->Paginator->hasNext())echo $this->Paginator->next('Next' ,['data' => $results]); ?>
                    <?=  $this->Paginator->last('Last', ['data' => $results]); ?>
                </span>
            </div>

        </div>

        <div id="adduct-tab" class="tab-pane fade">
            <div class="results-table">
                <?= $this->element('compound_ion_adduct_table', ['cols' => $ion_cols, 'ion_adducts' => $ion_adducts, 'model' => $model]) ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <span class="no-results"><?= $this->String->get_string('noresults', 'Search_form')?></span>
<?php endif; ?>


