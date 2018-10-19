<header>
<h1>LCMS Data Procssing Scripts (under development)</h1>
<p id="one">  The process is:</p>
<?php $message = "This is a message - Hello World"; ?>
<!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Display Message</button>-->
<p> 1) Generate a data file (xlsx) using the TASQ data processing template.</p>
<p> 2) The data file must contain tabs with 1) sample data; 2) analyte data; 3) calibration parameters; and 4) the raw global data from TASQ.</p>
<p> 3) xxxx.</p>
<p> 4) xxxx.</p>
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
    $processing = ['all' => 'Apply surrogate calibrations and quantify' , 'quant' => 'Quantify only'];
    $upload = ['No' => 'No' , 'Yes' => 'Yes' ];
    echo $this->BootstrapForm->create_horizontal('Upload', ['type' => 'file']);
    echo $this->BootstrapForm->input_horizontal('csv_path', ['label' => 'Data File (xlsx):',
    'type' => 'file']);
    echo $this->BootstrapForm->input_horizontal('processing_options', ['label' => 'Processing Options: ',
    'options' => $processing, 'default' => 'all']);
    echo $this->BootstrapForm->input_horizontal('upload', ['label' => 'Upload Options: ',
    'options' => $upload, 'default' => 'No']);
    echo $this->BootstrapForm->addMatchButtons();
?>
<script>
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>