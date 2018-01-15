<?php
$columnOptions = ['exclude' => $this->String->get_string('exclude', 'Import')];
foreach ($options as $option) {
    $columnOptions[$option] = $this->String->get_string($option, $model);
}
?>
<div class="results-table import-table">
    <table class="table table-striped table-hover">
        <tr>
            <?php foreach ($data[0] as $index => $field): ?>
                <?php
                $default = null;
                foreach ($columnOptions as $name => $text) {
                    if ($field == $name || $field == $text) {
                        $default = $name;
                        break;
                    }
                }
                ?>

                <th>
                    <?=
                    $this->BootstrapForm->input("$model][cols][$index", // @HACK dont ask >:(
                        [
                            'label' => false,
                            'type' => 'select',
                            'options' => $columnOptions,
                            'default' => $default
                        ]
                    );
                    ?>
                </th>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($data as $row): ?>
            <tr>
                <?php foreach($row as $item): ?>
                    <td><?= $item; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>