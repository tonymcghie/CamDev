<header>
<h1>Data Template Download Area</h1>
</header>

<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed table-responsive col-md-6" id="temp_tab">
    <tr>
        <th style="width:30%"></th>
        <th style="width:5%"></th>
        <th style="width:40%"></th>
    </tr>
    <tr>
        <td><h3>Sample Info Upload:</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#smplModal"><span class="glyphicon glyphicon-info-sign"></span></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-download-alt"></span> <?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('sample_info.csv'),['target'=>'_blank']); ?></td>
    </tr>
    <tr>
        <td><h3>Compound Data Summary Table:</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#cdstModal"><span class="glyphicon glyphicon-info-sign"></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-download-alt"></span> <?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('compound_summary_table.csv'),['target'=>'_blank']); ?></td>
    </tr>
    <tr>
        <td><h3>PFR Compound Data Upload Specifications:</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#cmpdModal"><span class="glyphicon glyphicon-info-sign"></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-download-alt"></span> <?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('pfr_compound_specifications.xlsx'),['target'=>'_blank']); ?></td> 
    </tr>
    <tr>
        <td><h3>Metabolomics Data Upload Specifications:</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#metaModal"><span class="glyphicon glyphicon-info-sign"></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-download-alt"></span> <?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('molecular_features_specifications.xlsx'),['target'=>'_blank']); ?></td> 
    </tr>
    <tr>
        <td><h3>Data Processing:</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#dpModal"><span class="glyphicon glyphicon-info-sign"></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-download-alt"></span> <?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('data_processing.xlsx'),['target'=>'_blank']); ?></td>    
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





