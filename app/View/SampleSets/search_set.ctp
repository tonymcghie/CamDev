<?php
//'start_date' => ((isset($data[$model]['isDate'])&&$data[$model]['isDate']==='1') ? $data['SampleSet']['start_date'] : '2000-01-01'));
// //'p_name' => $this->String->get_string('p_name', 'SampleSet'),
echo $this->element('search_form', ['model' => $model,
        'title' => 'Find Sample Set',
        'category_options' =>  ['set_code' => 'Set Code',
            'all' => 'All',
            'submitter' => 'PFR Collaborator',
            'chemist' => 'Chemist',
            'p_name' => 'Project Name',
            'p_code' => 'Project Code',
            'crop' => 'Crop',
            'compounds' => 'Compounds',
            'comments' => 'Comments',
            'exp_reference' => 'Experiment Reference',
            'team' => 'Team']]);
?>
<?php if (isset($cols) && !empty($results)): ?>
    <div id="search-results">
        <?= $this->Form->postLink('Export to CSV', ['action' => 'export', http_build_query($data)], ['class' => 'btn-xs btn-info', 'role' => 'button']);?>
        <div class="results-table">
            <?= $this->element('search_results_table', ['cols' => $cols, 'results' => $results, 'model' => $model]) ?>
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
<?php elseif (isset($results)): ?>
    There were no results // TODO use string helper
<?php endif; ?>
