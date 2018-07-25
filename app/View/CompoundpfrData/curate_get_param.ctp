<header>
<h1>Curate data in the PFR Compound Data table (under construction!)</h1>
<p id="one">To ensure Compound name consistency this module updates compound names using the CAS number as reference:</p>
<p> The process is:</p>
<p> 1) Select the Set Code (reference) of the Sample Set to be updated.</p>
<p> 2) Select the CAS number of the compounds to be updated.</p>
<p style = 'line-height : 130%;'> When executed, all the compound names for the selected CAS numbers will be updated in the Sample Set identified by the Set Code.<br>
The new compound names are those listed for the CAS number in the Compounds database - ie the CAM Compound Name.</p><br>
<p style = 'line-height : 130%;' > Warning. This action can potentially change many records.  Use the button below to check that the number of records <br>
to be updated is reasonable.</p><br>
<button type="button" class="btn btn-info btn-sm" id = "getRecNum" >Check # of records</button>
<p>
<div id="record"></div>
</p>
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
    'onchange' => 'getRecordNum(this.value)',
    'id' => 'Compoundpfr_dataCas']);
    
    echo $this->BootstrapForm->executeCurateButton();
           
    echo $this->BootstrapForm->get_js();  
    echo $this->BootstrapForm->end();
?>

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
    $('#getRecNum').on('click',function(event){
        $.ajax({
            data:{
                setcode_value: $("#Compoundpfr_dataSetCode").val(),
                cas_value: $("#Compoundpfr_dataCas").val()
            },
            url: 'http://localhost/CAM4-test/CompoundpfrData/checkRecord',
            cache: false,
            type: 'post',
            dataType: 'HTML',
            success: function (data) {
                $("#record").attr("style", "color: red");
                $('#record').html(data);
                 //if (data === "true"){
                 //       $("#record").attr("style", "color: green");
                 //       $("#record").html("Compound is not in Database");                        
                 //   } else {
                 //       $("#record").attr("style", "color: red");
                 //       $("#record").html("Compound is already in Database");
                  //  }
            }
        });
    });
</script>