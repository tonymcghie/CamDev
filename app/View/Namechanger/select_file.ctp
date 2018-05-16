<header>
<h1>Find CAM-names by synonym matching</h1>
<p id="one">  The process is:</p>
<?php $message = "This is a message - Hello World"; ?>
<!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Display Message</button>-->
<p> 1) Generate a .csv file where the fourth column contains compound names.</p>
<p> 1) The name in each row of the .csv file will be compared with the synonyms on the CAM->Compound database.</p>
<p> 2) When a compound names matches a Compound->Synonym name, the CAM compound name will be added to the table. This table can be exported.</p>
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
    echo $this->Form->create('Upload', array( 'type' => 'file'));
    //echo $this->Form->input('mass_tolerance', array('type'=>'select', 'label'=>'Mass Tolerance (+/- mDa): ', 'options'=>$mDa, 'default'=>'10'));
    //echo $this->Form->input('ion_type', array('type'=>'select', 'label'=>'Ion Type:', 'options'=>$ions, 'default'=>'[M-H]-'));
    echo $this->Form->input('csv_path', array('type' => 'file','label' => 'CSV Data File (contains compound names)'));
    echo $this->Form->end('Search for matching Compound Names');
?>
<script>
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>