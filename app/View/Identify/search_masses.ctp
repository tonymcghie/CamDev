<p>Search for masses view</p>
<p style="display:inline">Data File: <?php echo $fileName ?></p>
<p><?php //var_dump($masses) ?></p>
<?php
//var_dump($compounds[1]["Compound"]["compound_name"]);
echo "<table>";
echo $this->Html->tableHeaders(array($head[0], $head[1], $head[2], $head[3]));
echo $this->Html->tableCells($masses);
echo "</table>";
/**echo "<pre>";  //output array for testing
echo "********************\n";
echo htmlentities(print_r($compounds,true));
echo "\n====================";
echo "</pre>";*/
?>
