<?php
//var_dump($head);
//var_dump($masses);
//foreach ($head as $row): //print headings to the .csv after removing unnecessary characters
    foreach ($head as &$cell):
        // Escape double quotation marks
        $cell = '"' . preg_replace('/"/','""',$cell) . '"';
    endforeach;
    echo implode(',', $head) . "\n";
//endforeach;

foreach ($masses as $row): //print headings to the .csv after removing unnecessary characters 
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
<?php 
//echo $this->My->drawCSV($masses, 'Identify');
//array_unshift($data,[$model => array_keys($data[0][$model])]);
        /**foreach ($masses as $row):
            foreach ($row as &$cell):
                // Escape double quotation marks
                $cell = '"' . preg_replace('/"/','""',$cell) . '"';
            endforeach;
            echo implode(',', $row) . "\n";
        endforeach;*/
?>

