<h1>Sample Upload Workspace</h1>
<p> Samples can only be imported to an existing Sample Set.</p>
<p><The process is:</p>
<p> 1) Generate a flat .csv file containing sample and treatment or attribute information.</p>
<p> 2) Click on Choose File and select the .csv file. The first 5 rows of the .csv sample table will be displayed.  </p>
<p> 3) Select the database fields (top row) to match the table column headings (second row) of the incoming .csv file.</p>
<p> 4) Click on Import button to upload the sample data into the database.</p>
<?php

?>
<table class="noFormat">
    <tr>
        <td style="width: 50%;">
            <!--<iframe id="csvFileFrame" class="iframeNoformat" src="<?php echo $this->Html->url(['controller' => 'Samples', 'action' => 'getCsv']);?>"></iframe>-->
            <div class="file-loading">
                <!--<input id="sample_file" name="sample_file" type="file" class="file">-->
                <?php
                echo $this->Form->create('Samples', array( 'type' => 'file', 'action' => 'getCsv'));
                echo $this->Form->input('csv_path', array('type' => 'file','label' => 'CSV Data File'));
                echo $this->Form->end('Load');
                ?>
            </div>
        </td>
        <td style="width: 20%;">
            <span type="button" id="mapData" class="btn btn-default">Map Data</span>
        </td>
        <td style="width: 20%;">
            <span type="button" id="importData" class="btn btn-default">Import</span>
        </td>
    </tr>
</table>

