Converts a summary table (metabolite (rows) X samples (columns) of metabolomic data into rows of metabolites ready for importing into PFR Metabolomics Data<br>
Here is a template file
<?php
echo $this->Form->create('General', ['url' => 'download']);
echo $this->Form->hidden('name', ['value' => 'Metabolite-SummaryTableConvert.csv']);
echo $this->Form->hidden('path', ['value' => 'webroot/files/pythonScripts/Metabolite-SummaryTableConvert.py_template']);
echo $this->Form->end(['label' => 'Template', 'class' => 'large-button anySizeButton green-button']);