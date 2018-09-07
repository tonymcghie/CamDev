<header>
    <h1><?php echo $this->String->get_string('edit_title', 'Compound_msms_form'); ?></h1>
    <h2>Compound ID: <?php echo $compound_id ?></h2>
    <h2>Msms ID: <?php echo $id ?></h2>
    var_dump($msms_data);
</header>
<?= $this->element('Msms_compound/tabs', ['titles' => $titles, 'currentMsms' => $currentMsms]); ?>

<div class="tab-content">
    <?= $this->element('Msms_compound/tab_content', ['Msms' => $currentMsms, 'compound_id' => $compound_id]); ?>
</div>

<?= $this->element('image_modal'); ?>
