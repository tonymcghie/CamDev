<header>
    <h1>Sample Set Analysis Workspace</h1>
    <h2>Set Code: <?php echo $set_code ?></h2>
</header>
<?= $this->element('Analysis/tabs', ['titles' => $titles, 'currentAnalysis' => $currentAnalysis]); ?>

<div class="tab-content">
    <?= $this->element('Analysis/tab_content', ['analysis' => $currentAnalysis, 'set_code' => $set_code]); ?>
</div>
