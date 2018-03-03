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
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-download-alt"></span> <?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('data_processing.xlsm'),['target'=>'_blank']); ?></td>    
    </tr>
    <tr>
        <td><h3>Data Processing (TASQ):</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#dptModal"><span class="glyphicon glyphicon-info-sign"></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-download-alt"></span> <?php  echo $this->Html->link('DownLoad Template',$this->My->makeTemplateURL('data_processing_tasq.xlsm'),['target'=>'_blank']); ?></td>    
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
                <?php echo 'Data processing template contains formated sheets to facilitate the calculation of results' ?>
                <?php echo 'from data exported from chromatigraphic data systems (DCS) such as Chromeleon.' ?>
                <?php echo 'The primary sheets in the Data Processing template are:' ?><br>
                <?php echo 'Sample Data - contains samples codes, relevant sample metadata,  sample weights etc .' ?><br>
                <?php echo 'Analytes - a list of analytes with chemical information, which is autofilled when the name is entered.' ?><br>
                <?php echo 'Raw Data - as exported from the CDS.' ?><br>
                <?php echo 'Calculation - formulas for converting data from the CDS into concentration data for each analyte.' ?><br>
                <?php echo 'Result Summary - combines information from Sample Data and data from Calculation to generate a Summary of the results for reporting.' ?><br>
                <?php echo 'Additional sheets - for preparing data for upload to CAM and sheets necessary for the working of the template (e.g. compound lookup).' ?><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="dptModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Data Processing</h4>
            </div>
            <div class="modal-body">
                <?php echo 'This template is similar to the Data Processing template but contains' ?>
                <?php echo 'specific operations relevant to the data processing of Bruker TASQ data.' ?>
                <?php echo 'This template contains functionality to facilite the transfer of calibration curves of' ?>
                <?php echo 'compounds with standards to compounds for which standards are not available.' ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





