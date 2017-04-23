Converts a summary table (compound (rows) X samples (columns) of analytical data into rows of compounds ready for importing into PFR Compound Data<br>
Here is a template file
<?php
echo $this->Form->create('General', ['url' => 'download']);
echo $this->Form->hidden('name', ['value' => 'Compound-SummaryTableConvert.csv']);
echo $this->Form->hidden('path', ['value' => 'webroot/files/pythonScripts/Compound-SummaryTableConvert.py_template']);
echo $this->Form->end(['label' => 'Template', 'class' => 'large-button anySizeButton green-button']);