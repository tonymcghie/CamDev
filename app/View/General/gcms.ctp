<header>
<h1>Links to GCMS Utilities</h1>
</header>

<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed table-responsive col-md-6" id="temp_tab">
    <tr>
        <th style="width:30%"></th>
        <th style="width:5%"></th>
        <th style="width:40%"></th>
    </tr>
    <tr>
        <td><h3>Convert Excel file to a new layout:</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#smplModal"><span class="glyphicon glyphicon-info-sign"></span></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-download-alt"></span> Download Template</button></td>
        <td><?php  echo $this->Html->link('Start',  'https://genome.plantandfood.co.nz/cgi-bin/cmp_convert_xls.cgi',  array('style'=>'width: 120px','class' => 'find-button abbr-button', 'target' => '_blank')); ?></td>
    </tr>
    <tr>
        <td><h3>Combines data from multiple GCMS text file into an Excel files:</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#cdstModal"><span class="glyphicon glyphicon-info-sign"></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-download-alt"></span> Download Template</button></td>
        <td><?php  echo $this->Html->link('Start',  'https://genome.plantandfood.co.nz/cgi-bin/txt2xlsHM.cgi',  array('style'=>'width: 120px','class' => 'find-button abbr-button', 'target' => '_blank')); ?></td>
    </tr>
    <tr>
        <td><h3>GCMS text file to Excel converter:</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#cmpdModal"><span class="glyphicon glyphicon-info-sign"></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-download-alt"></span> Download Template</button></td>
        <td><?php  echo $this->Html->link('Start',  'https://genome.plantandfood.co.nz/cgi-bin/txt2xls.cgi',  array('style'=>'width: 120px','class' => 'find-button abbr-button', 'target' => '_blank')); ?></td>
    </tr>
</table>
</div>

<div id="smplModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sample Info Upload</h4>
            </div>
            <div class="modal-body">
                <?php echo 'Data processing' ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="cdstModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Compound Data Summary Table</h4>
            </div>
            <div class="modal-body">
                <?php echo 'Data processing' ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="cmpdModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Compound Data Upload Specifications</h4>
            </div>
            <div class="modal-body">
                <?php echo 'Data processing' ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="metaModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Metabolomics Data Upload Specifications</h4>
            </div>
            <div class="modal-body">
                <?php echo 'Data processing' ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="dpModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Data Processing</h4>
            </div>
            <div class="modal-body">
                <?php echo 'Data processing' ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--<table class="noFormat viewSampleSet">
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
</table>-->




