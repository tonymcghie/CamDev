
<style type="text/css">
      .scrollable {
        height: 800px;
        overflow-y: scroll;
      }
    </style><p>Search for masses view</p>
<p style="display:inline">Data File: <?php echo $identify_parms[0] ?></p>
<p><?php //var_dump($masses) ?></p>
<?php
//var_dump($compounds[1]["Compound"]["compound_name"]);
var_dump($identify_parms);
//$tempExp = $this->Form->postLink('Export CSV', ['action' => 'export', http_build_query($identify_parms)], ['style'=>'width: 80px', 'class' => 'find-button abbr-button']);
$tempExp = $this->Form->postLink('Export CSV',  ['action' => 'export', $identify_parms[1]], ['style'=>'width: 80px', 'class' => 'find-button abbr-button']);
echo $tempExp;
echo "<div class='scrollable'>";
echo "<table>";
echo $this->Html->tableHeaders(array($head[0], $head[1], $head[2], $head[3], $head[4]));
echo $this->Html->tableCells($masses);
echo "</table>";
echo "</div>";
/**echo "<pre>";  //output array for testing
echo "********************\n";
echo htmlentities(print_r($compounds,true));
echo "\n====================";
echo "</pre>";*/
?>
