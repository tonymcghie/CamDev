<style type="text/css">
      .scrollable {
        height: 800px;
        overflow-y: scroll;
      }
</style>
<h2>Data Processing Results:</h2>
<h4>Processing output .....</h4>
<p><strong>Note: </strong>etc etc etc ...<br></p>
<p style="display:inline-block; width: 350px;"><strong>Data File: </strong><?php echo $processing_parms[0]?></p>
<p style="display:inline-block; width: 300px;"><strong>Processing Option: </strong><?php echo $processing_parms[1]?></p>
<p style="display:inline"><strong>Upload (PFR Compound Data) Option: </strong><?php echo $processing_parms[2]?><br></p>

<div class="results-table">
    <table class="table table-striped table-hover">
        <?php //echo $this->Html->tableHeaders($head);?>
        <?php //echo $this->Html->tableCells($masses);; ?>
    </table>
</div>

