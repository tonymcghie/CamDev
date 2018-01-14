<header>
<h1>Links to GCMS Utilities</h1>
</header>

<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed table-responsive col-md-6" id="temp_tab">
    <tr>
        <th style="width:20%"></th>
        <th style="width:5%"></th>
        <th style="width:5%"></th>
    </tr>
    <tr>
        <td><h3>Convert Excel file to a new layout:</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#convertModal"><span class="glyphicon glyphicon-info-sign"></span></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-play-circle"></span> <?php  echo $this->Html->link('Start', 'https://genome.plantandfood.co.nz/cgi-bin/cmp_convert_xls.cgi', ['target'=>'_blank']); ?></td>
    </tr>
    <tr>
        <td><h3>Combines data from multiple GCMS text files into an Excel file:</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#combineModal"><span class="glyphicon glyphicon-info-sign"></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-play-circle"></span> <?php  echo $this->Html->link('Start', 'https://genome.plantandfood.co.nz/cgi-bin/txt2xlsHM.cgi', ['target'=>'_blank']); ?></td>
    </tr>
    <tr>
        <td><h3>GCMS text file to Excel converter:</h3></td>
        <td class="text-center" style = "vertical-align: middle"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#2xlxsModal"><span class="glyphicon glyphicon-info-sign"></button></td>
        <td style = "vertical-align: middle"><button type="button" class="btn"><span class="glyphicon glyphicon-play-circle"></span> <?php  echo $this->Html->link('Start', 'https://genome.plantandfood.co.nz/cgi-bin/txt2xls.cgi', ['target'=>'_blank']); ?></td>
    </tr>
</table>
</div>

<div id="convertModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Convert Excel file to a new layout</h4>
            </div>
            <div class="modal-body">
                <?php echo 'Converts an Excel file ....' ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="combineModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Combines data from multiple GCMS text files into an Excel file</h4>
            </div>
            <div class="modal-body">
                <?php echo 'Combines multiple text GCMS data files into a single Excel file' ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="2xlxsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">GCMS text file to Excel converter</h4>
            </div>
            <div class="modal-body">
                <?php echo 'Converts and GCMS text file (from Leco) to an Excel files.' ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>






