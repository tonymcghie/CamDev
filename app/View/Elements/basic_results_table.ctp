<?php
/**
 * Make a results table from only one colum of data with no pagination
 * 
 * @param array $output The single dimensional array of data to display
 * @param String $label The label of the column
 * @param String $Column The name of the column in the database
 * 
 */
?>
<div class='scrollable' id='resultsTable'>
<?php if (!empty($output)): ?>
    <table class="table-striped">
        <tr>
            <th><?= $label ?></th>
            <?php if (!empty($column)): ?><th>Action</th><?php endif; ?>
        </tr>
        <?php foreach ($output as $line): ?>
        <tr>
            <td><?= $line ?></td>
            <?php if (!empty($column)): ?>
            <td><?= $this->Html->link('View',
                    ['controller' => $controller, 'action' => $action, '?' => ['search' => ['column' => $column ,'value' => $line]]],
                    ['class' => 'find-button abbr-button', 'title'=>'View']) ?>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    No Data found
<?php endif; ?>
</div>
