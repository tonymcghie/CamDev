Converts a summary table into rows of compounds ready for importing into PFR Data<br>
Here is a template file
<?php
echo $this->Form->create('General', ['url' => 'download']);
echo $this->Form->hidden('name', ['value' => 'SummartTableConvert_dB_template.csv']);
echo $this->Form->hidden('path', ['value' => 'webroot/files/pythonScripts/SummaryTableConvert_dB.py_template']);
echo $this->Form->end(['label' => 'Template', 'class' => 'large-button anySizeButton green-button']);