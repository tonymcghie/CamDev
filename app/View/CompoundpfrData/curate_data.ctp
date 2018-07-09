<header>
<h1>Curate data in the PFR Compound Data table</h1>
<p id="one">  The process is:</p>
<p> For example correct compound names using a CAS match with the Compounds Table</p>
<p> The process is ....</p>
</header>

<?php
    $mDa = ['5' => '5' , '10' => '10' , '20' => '20', '50' => '50', '100' => '100', '500' => '500'];
    $ions = ['[M-H]-' => '[M-H]-' , '[M+H]+' => '[M+H]+', '[M]' => '[M]'];
    echo $this->Form->create('Upload', array( 'type' => 'file'));
    echo $this->Form->input('sample_set_code', array('type'=>'select', 'label'=>'Sample Set Code (Experiment Ref.)', 'options'=>$mDa, 'default'=>'10'));
    echo $this->Form->input('ion_type', array('type'=>'select', 'label'=>'Ion Type:', 'options'=>$ions, 'default'=>'[M-H]-'));
    echo $this->Form->input('csv_path', array('type' => 'file','label' => 'CSV Data File (contains accurate masses)'));
    echo $this->Form->end('Updata Data Table (careful!!!)');
?>
<script>
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>