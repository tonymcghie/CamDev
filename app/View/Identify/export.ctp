<?php
//var_dump($head);
//var_dump($masses);
    foreach ($head as &$cell):  //print the heading to the export csv
        // Escape double quotation marks
        $cell = '"' . preg_replace('/"/','""',$cell) . '"';
    endforeach;
    echo implode(',', $head) . "\n";

foreach ($masses as $row): //print data plus compounds matches from the database to the export csv
    foreach ($row as &$cell):
        // Escape double quotation marks
        $cell = '"' . preg_replace('/"/','""',$cell) . '"';
    endforeach;
    echo implode(',', $row) . "\n";
endforeach;
?>
<?php
/**echo "<pre>";  //output array for testing
echo "********************\n";
echo htmlentities(print_r($head,true));
echo "\n====================";
echo "</pre>";
echo "<pre>";  //output array for testing
echo "********************\n";
echo htmlentities(print_r($masses,true));
echo "\n====================";
echo "</pre>";*/
?>


