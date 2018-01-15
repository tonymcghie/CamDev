<?php
array_unshift($data,[$model => array_keys($data[0][$model])]);
foreach ($data as $row):
    foreach ($row[$model] as &$cell):
        // Escape double quotation marks
        $cell = '"' . preg_replace('/"/','""', $cell) . '"';
    endforeach;
    echo implode(',', $row[$model]) . "\n";
endforeach;
?>