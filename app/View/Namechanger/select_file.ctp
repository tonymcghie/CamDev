<header>
<h1>Find CAM-names by synonym (or CAS #) matching</h1>
<p id="one">  The process is:</p>
<?php $message = "This is a message - Hello World"; ?>
<!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Display Message</button>-->
<p> 1) Generate a .csv file containing compound names or CAS # in  columns A-F.</p>
<p> 2) If 'name' is selected the compound name in each row of the .csv file will be compared with the compound name and the synonyms in the CAM->Compound database.</p>
<p> 3) If 'CAS' is selected the CAS # in each row of the .csv file will be compared with the CAS # in the CAM->Compound database.</p>
<p> 4) When a match is found with the input compound name or CAS #, the CAM compound name and CAS # will be added to the row in the table.</p>
<p> This table can be exported.</p>
</header>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <?php echo $message ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
    $criteria = ['name' => 'name' , 'CAS' => 'CAS'];
    $column = ['A' => 'A' , 'B' => 'B', 'C' => 'C', 'D' => 'D' , 'E' => 'E', 'F' => 'F' ];
    echo $this->BootstrapForm->create_horizontal('Upload', ['type' => 'file']);
    echo $this->BootstrapForm->input_horizontal('csv_path', ['label' => 'CSV Data File (containing compound names or CAS #)',
    'type' => 'file']);
    echo $this->BootstrapForm->input_horizontal('match_criteria', ['label' => 'Match Criteria: ',
    'options' => $criteria, 'default' => 'name']);
    echo $this->BootstrapForm->input_horizontal('data_column', ['label' => 'Match Column: ',
    'options' => $column, 'default' => 'A']);
    echo $this->BootstrapForm->addMatchButtons();
?>
<script>
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>