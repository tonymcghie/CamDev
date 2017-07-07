<?php
/**
 * Make a results table from only one colum of data with no pagination
 * 
 * @param array $output The single dimensional array of data to display
 * @param label $label The label of the colum
 * 
 */
?>
<div class='scrollable' id='resultsTable'>
<?php if (!empty($output)): ?>?>
    <table class="table-striped">
        <tr><th><?= $label ?></th></tr>
        <?php foreach ($output as $line): ?>
            <tr><td><?= $line ?></td></tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    No Data found
<?php endif; ?>
</div>
