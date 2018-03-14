<h1><?= $this->String->get_string('title', 'Edit_form');?></h1>

<ul class="nav nav-tabs">
    <?php foreach ($versions as $version): ?>
        <li
            <?php
                if ($version['SampleSet']['id'] == $item['SampleSet']['id']){
                    echo 'class="active"';
                }
            ?>
        >
            <a href="<?= $this->Html->url(null, true);?>?id=<?=$version['SampleSet']['id']?>">
                <?= $version['SampleSet']['version']?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?= $this->BootstrapForm->create($model, ['type' => 'file', 'action' => 'edit']); ?>

<?= $this->element($model.'/edit_form', ['item' => $item]); ?>

<?= $this->BootstrapForm->addActionButtons('Save as new version'); ?>
<?= $this->BootstrapForm->get_js(); ?>
<?= $this->BootstrapForm->end(); ?>
