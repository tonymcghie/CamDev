<h1><?= $this->String->get_string('title', 'Edit_form');?></h1>

<?= $this->BootstrapForm->create($model, ['action' => 'edit']); ?>

<?= $this->element($model.'/edit_form', ['item' => $item]); ?>

<?= $this->BootstrapForm->addActionButtons('Save as new version'); ?>
<?= $this->BootstrapForm->get_js(); ?>
<?= $this->BootstrapForm->end(); ?>
