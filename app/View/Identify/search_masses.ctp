<style type="text/css">
      .scrollable {
        height: 800px;
        overflow-y: scroll;
      }
</style>
<h2>Identification Results:</h2>
<h4>Matching (by accurate mass) compounds in the CAM Compounds DB.</h4>
<p><strong>Note: </strong>more than one DB compound may match.<br></p>
<p style="display:inline-block; width: 250px;"><strong>Data File: </strong><?php echo $identify_parms[0]?></p>
<p style="display:inline-block; width: 200px;"><strong>Mass Window (+/- mDa): </strong><?php echo $identify_parms[1]*1000?></p>
<p style="display:inline"><strong>Ion Type: </strong><?php echo $identify_parms[2]?><br></p>
<?php
$tempExp = $this->Form->postLink('Export to CSV',  array('action' => 'export', urlencode($identify_parms[0]), $identify_parms[1], $identify_parms[2]), ['class' => 'btn-xs btn-info']);
echo $tempExp; 
//passes the search parameters back to IdentifyController>export so that the csv version of the results can be generated and exported
?>
<div class="results-table">
    <table class="table table-striped table-hover">
        <?php echo $this->Html->tableHeaders($head);?>
        <?php echo $this->Html->tableCells($masses);; ?>
    </table>
</div>

