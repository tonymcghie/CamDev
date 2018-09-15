<style type="text/css">
      .scrollable {
        height: 800px;
        overflow-y: scroll;
      }
</style>
<h2>Match Results:</h2>
<h4>Compound names and CAS numbers that match compounds in the input .csv datafile.</h4>
<p style="display:inline"><strong>Input Data File: </strong><?php echo $identify_parms[0]?><br></p>

<?php
$tempExp = $this->Form->postLink('Export to CSV',  array('action' => 'export', urlencode($identify_parms[0])), ['class' => 'btn-xs btn-info']);
echo $tempExp; 
//passes the search parameters back to NamechangerController>export so that the csv version of the results can be generated and exported
?>
<div class="results-table">
    <table class="table table-striped table-hover">
        <?php echo $this->Html->tableHeaders(array($head[0], $head[1], $head[2], $head[3], $head[4], $head[5]));?>
        <?php echo $this->Html->tableCells($data);; ?>
    </table>
</div>

