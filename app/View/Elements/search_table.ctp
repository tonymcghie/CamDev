<?php if (!empty($results)): ?>
    <?php
    // Pre conditions
    assert(isset($num), '\'$num\' is required when \'$results\' is not empty');
    /** @var int $num */
    assert(isset($initialColumns), '\'$initialColumns\' is required when \'$results\' is not empty');
    /** @var array $initialColumns */
    assert(isset($model), '\'$model\' is required when \'$results\' is not empty');
    /** @var string $model */
    
    
    $sort_options = array(
        'compound_name',
        'cas',
        'exact_mass');

    ?>

    <div id="search-results">
        <h2>Results found (n=<?php echo $num; ?>)</h2>
        <?php
        if(in_array('Exportable', $behaviour)) {
            echo $this->Html->link(
                    'Export to CSV',
                    [
                        'action' => 'export',
                        '?' => http_build_query($data)
                    ],
                    [
                        'class' => 'btn-xs btn-info',
                        'role' => 'button'
                    ]
            );
        }
        ?>

        <div class="results-table">
            <table class="table table-striped table-hover">
                <?php
                $headings = [];
                foreach ($initialColumns as $column){
                    if (in_array($column, $sort_options)) {
                        $headings[] = $this->Paginator->sort($column, $this->String->get_string($column, $model)).'+';
                    } else {
                        $headings[] = $this->String->get_string($column, $model);
                    }
                }
                //$headings = ['Actions', $this->Paginator->sort('compound_name', 'Name'), 'Synonyms', $this->Paginator->sort('cas', 'CAS'), 'Class', 'Formula', $this->Paginator->sort('exact_mass', 'Exact Mass'), '[M-H]-', '[M+HCOOH]-', '[M+H]+', '[M+Na]+', 'Comment'];
                var_dump($headings);
                echo $this->Html->tableHeaders($headings, null, ['scope' => 'col']);
                foreach ($results as $row){
                    $row->actions = $this->element($model.DS.'actions', ['data' => $row->getActionData()]);
                    echo $this->Html->tableCells($row->getTableRowData());
                }
                ?>
            </table>

            <div class="table-page-nums">
                <span>
                    <?= $this->Paginator->first('First'); ?>
                    <?php if($this->Paginator->hasPrev())echo $this->Paginator->prev('Prev'); ?>
                    <?= $this->Paginator->numbers(['modulus' => 4]); ?>
                    <?php if ($this->Paginator->hasNext())echo $this->Paginator->next('Next'); ?>
                    <?=  $this->Paginator->last('Last'); ?>
                </span>
            </div>
        </div>
    </div>
<?php else: ?>
    <span class="no-results"><?= $this->String->get_string('noresults', 'Search_form')?></span>
<?php endif; ?>