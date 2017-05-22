<?php $this->layout = 'MinLayout'; //minimilistic layout that has no formating ?>
<style type="text/css">
      .scrollable {
        height: 800px;
        overflow-y: scroll;
      }
</style>
<p>Search Results: compounds in the Compounds DB that match an accurate mass. Note: more than one compound may match.<br><br></p>
<p style="display:inline">Data File: <?php echo $identify_parms[0]?></p>
<p style="display:inline">Mass Window (+/- mDa): <?php echo $identify_parms[1]*1000?></p>
<p style="display:inline">Ion Type: <?php echo $identify_parms[2]?><br></p>
<?php
$tempExp = $this->Form->postLink('Export CSV',  array('action' => 'export', urlencode($identify_parms[0]), $identify_parms[1], $identify_parms[2]), ['style'=>'width: 80px', 'class' => 'find-button abbr-button']);
echo $tempExp; //passes the search parameters back to IdentifyController>export so that the csv version of the results can be generated and exported
echo "<div class='scrollable'>";
echo '<table style="background-color: rgba(252, 252, 252, 0.75)">';
echo $this->Html->tableHeaders(array($head[0], $head[1], $head[2], $head[3], $head[4], $head[5]));
echo $this->Html->tableCells($masses);
echo "</table>";
echo "</div>";
/**echo "<pre>";  //output array for testing
echo "********************\n";
echo htmlentities(print_r($compounds,true));
echo "\n====================";
echo "</pre>";*/
?>
