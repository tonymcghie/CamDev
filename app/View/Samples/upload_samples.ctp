<header>
<h1>Import Samples - to an existing sample set</h1>
<?php //echo $this->Html->image('underconstruction.png', array('alt' => 'CAM Logo', 'width' => '140')); ?>
<p> The process is:</p>
<p> 1) Generate a .csv containing sample and treatment data.</p>
<p> 2) Select the .csv file.  </p>
<p> 3) The first 6 rows of the sample table will be displayed.  Ensure the table headings match the database fields and click on Import.</p>
</header>
<?php
    $mDa = ['5' => '5' , '10' => '10' , '20' => '20', '50' => '50', '100' => '100', '500' => '500'];
    $ions = ['[M-H]-' => '[M-H]-' , '[M+H]+' => '[M+H]+', '[M]' => '[M]'];
    echo $this->Form->create('Upload', array( 'type' => 'file'));
    echo $this->Form->input('csv_path', array('type' => 'file','label' => 'CSV File (sample data)'));
    echo $this->Form->end('Next>');
?>
<script>
    $('#csvFile').on('change',function(){
       $('#fileForm').submit(); 
    });
</script>