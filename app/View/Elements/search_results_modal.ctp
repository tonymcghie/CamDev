<?php if (isset($results[0])) : ?>
    <?php
    $this->Paginator->options(array(
        'update' => '#table-tab',
        'evalScripts' => true
    ));
    ?>
    <div id="table-model" class="modal fade" role="dialog">
        <div class="modal-dialog table-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Search Results (n=<?php echo $num; ?>)</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#table-tab">Table</a></li>
                        <li><a data-toggle="tab" href="#adduct-tab">Ion-adducts</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="table-tab" class="tab-pane fade in active">
                            <div class="results-table">
                                <?= $this->element('search_results_table', ['cols' => $cols, 'results' => $results, 'model' => $model]) ?>
                            </div>
                            <div id="hidden-columns"></div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Html->script('search_results.min') ?>
<?php endif; ?>