<header>
<h1>Identify Compounds by Accurate Mass Matching</h1>
<p id="one">  The process is:</p>
<?php $message = "This is a message - Hello World"; ?>
<!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Display Message</button>-->
<p> 1) Generate a .csv file where the fourth column contains accurate masses.</p>
<p> 2) Select a mass tolerance (eg +/- 10 mDa) and the ion type;  select your input data file.</p>
<p> 3) The compounds that are present in the Compounds database, and that match your accurate mass data will be displayed.  This table can be exported.</p>
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
    $mDa = ['5' => '5' , '10' => '10' , '20' => '20', '50' => '50', '100' => '100', '500' => '500'];
    $ions = ['[M-H]-' => '[M-H]-' , '[M+H]+' => '[M+H]+', '[M]' => '[M]'];
        
    echo $this->BootstrapForm->create_horizontal('Upload', ['type' => 'file']);
    echo $this->BootstrapForm->input_horizontal('csv_path', ['label' => 'CSV Data File (contains accurate masses)',
    'type' => 'file']);
    echo $this->BootstrapForm->input_horizontal('mass_tolerance', ['label' => 'Mass Tolerance (+/- mDa): ',
    'options' => $mDa, 'default' => '10']);
    echo $this->BootstrapForm->input_horizontal('ion_type', ['label' => 'Ion Type: ',
    'options' => $ions, 'default' => '[M-H]-']);
    echo $this->BootstrapForm->addIdentifyButton();
?>
<script>
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>