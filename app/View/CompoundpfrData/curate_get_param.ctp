<header>
<h1>Curate data in the PFR Compound Data table (under construction!)</h1>
<p id="one">  The process is:</p>
<p> For example correct compound names using a CAS match with the Compounds Table</p>
<p> The process is ....</p>
<?php $message = "This is a message - Hello World"; ?>
<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Check?</button>
</header>

<?php
    $cas_nums = array_filter($cas_nums); //remove blanks from the array
    // needed to make the autolist to work ???
    //var_dump($cas_nums);
    echo $this->BootstrapForm->create_horizontal('Compoundpfr_data', ['action' => 'doCurate']);
    
    //echo $this->BootstrapForm->input_horizontal('chemist', ['label' => $this->String->get_string('chemist_name', 'SampleSet_form'),
    //'autocomplete' => 'off',
    //'id' => 'curateParamsChemist']);
    
    echo $this->BootstrapForm->input_horizontal('set_code', ['label' => $this->String->get_string('set_code', 'SampleSet'),
    'autocomplete' => 'off',
    'id' => 'Compoundpfr_dataSetCode']);
    
    echo $this->BootstrapForm->input_horizontal('cas', ['label' => $this->String->get_string('cas', 'Compound_form'),
    'autocomplete' => 'off',
    'id' => 'Compoundpfr_dataCas']);
    
    echo $this->BootstrapForm->executeCurateButton();
           
    echo $this->BootstrapForm->get_js();
    echo $this->BootstrapForm->end();
?>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">The number of records that will be changed</h4>
            </div>
            <div class="modal-body">
                <?php echo $Compoundpfr_dataCas ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#Compoundpfr_dataSetCode').autocomplete({
            source: Object.values(JSON.parse('<?php echo json_encode($set_codes); ?>')),
            appendTo: $('#Compoundpfr_dataSetCode').closest('div')
        });
        $('#curateParamsChemist').autocomplete({
            source: Object.values(JSON.parse('<?php echo json_encode($names); ?>')),
            appendTo: $('#curateParamsChemist').closest('div')
        });
        $('#Compoundpfr_dataCas').autocomplete({
            source: Object.values(JSON.parse('<?php echo json_encode($cas_nums); ?>')),
            appendTo: $('#Compoundpfr_dataCas').closest('div')
        });
    });
</script>