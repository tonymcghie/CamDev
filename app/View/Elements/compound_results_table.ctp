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
                    <h2>Search Results</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#table-tab">Compound Data</a></li>
                        <li><a data-toggle="tab" href="#graph-tab">Ion Adducts</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="table-tab" class="tab-pane fade in active">
                            <div class="results-table">
                                <table class="table table-striped table-hover">
                                    <?php
                                    $headings = [];
                                    foreach (array_keys($results[0][$model]) as $key){
                                        $heading = $this->String->get_string_bool($key, $model);
                                        if (!$heading){
                                            foreach ($results as &$row){
                                                unset($row[$model][$key]);
                                            }
                                        } else {
                                            $headings[] = $heading;
                                        }
                                    }
                                    echo $this->Html->tableHeaders($headings);
                                    //calculate addut values and add to $results array
                                    foreach ($results as $row){
                                        echo $this->Html->tableCells(array_values($row[$model]));
                                    }
                                    ?>
                                </table>
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
                        <div id="graph-tab" class="tab-pane fade">
                            <h2>Calculated ion adducts go here</h2>
                            <div class="results-table">
                                <table class="table table-striped table-hover">
                                    <?php
                                    $headings = [];
                                    foreach (array_keys($results[0][$model]) as $key){
                                        $heading = $this->String->get_string_bool($key, 'IonAdducts');
                                        if (!$heading){
                                            foreach ($results as &$row){
                                                unset($row[$model][$key]);
                                            }
                                        } else {
                                            $headings[] = $heading;
                                        }
                                    }
                                    //calculate exact masses for ion adducts and add to $results array
                                    echo $this->Html->tableHeaders($headings);
                                    foreach ($results as $row){
                                        echo $this->Html->tableCells(array_values($row[$model]));
                                    }
                                    ?>
                                </table>
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