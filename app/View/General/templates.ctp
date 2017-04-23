<header>
<h1>Data Template Download Area:</h1>
</header>
<table class="noFormat viewSampleSet">
    <tr>
        <td><h2>Sample Info Upload:</h2></td>
        <td><?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('sample_info.csv'),['target'=>'_blank', 'class' => 'find-button anySizeButton']); ?></td
    </tr>
	<tr>
        <td><h2>Compound Data Summary Table:</h2></td>
        <td><?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('summary_table.xlsx'),['target'=>'_blank', 'class' => 'find-button anySizeButton']); ?></td
    </tr>
    <tr>
        <td><h2>PFR Compound Data Upload Specifications:</h2></td>
        <td><?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('pfr_compound_specifications.xlsx'),['target'=>'_blank', 'class' => 'find-button anySizeButton']); ?></td
    </tr>
    <tr>
        <td><h2>Metabolomics Data Upload Specifications:</h2></td>
        <td><?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('molecular_features_specifications.xlsx'),['target'=>'_blank', 'class' => 'find-button anySizeButton']); ?></td
    </tr>
    <tr>
        <td><h2>Data Processing:</h2></td>
        <td><?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('data_processing.xlsx'),['target'=>'_blank', 'class' => 'find-button anySizeButton']); ?></td
    </tr>
</table>




