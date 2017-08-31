<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php elseif (empty($sampleSet)): ?>
    <div class="alert alert-danger">There is not Sample Set selected</div>
<?php else: ?>
    <table>
    <?php foreach ($sampleSet['SampleSet'] as $name => $value): ?>
        <?php if (empty($value) || $name = 'id') continue; ?>
        <tr>
            <td><?= $name ?></td>
            <td><?= $value ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>
