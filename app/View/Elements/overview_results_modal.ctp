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
                    <h2>Overview Results (for <?php echo $for; ?>; by <?php echo $by; ?> = <?php echo $value; ?> )</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#table-tab">Table</a></li>
                        <li><a data-toggle="tab" href="#adduct-tab">Blank</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="table-tab" class="tab-pane fade in active">
                            <div class="results-table">
                                <?= $this->element('overview_results_table', ['results' => $results, 'model' => $model]) ;?>
                            </div>    
                        </div>
                        <div id="adduct-tab" class="tab-pane fade">
                            <div class="results-table">                       
                                
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