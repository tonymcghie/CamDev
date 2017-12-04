<header>
    <h1>Sample Set Analysis Workspace</h1>
    <h2>Set Code: <?php echo $set_code ?></h2>
</header>
<?php
    echo $this->BootstrapForm->create_horizontal('Analysis', ['action' => 'newAnalysis']);
    echo $this->BootstrapForm->input_horizontal('set_code', ['type' => 'hidden', 'value' => $set_code]);
    echo $this->BootstrapForm->input_horizontal('title', ['placeholder' => 'New Analysis title',
        'label' => $this->String->get_string('title', 'Analysis')]);
    echo $this->BootstrapForm->input_horizontal('workflow', ['label' => $this->String->get_string('workflow', 'Analysis'),
        'options' => [
            'chem_everything' => 'Chem: all sections',
            'chem_details' => 'Chem: analysis details only',
            'chem_files' => 'Chem: files only',
            'chem_pictures' => 'Chem: pictures only',
            'bio_everything' => 'Bio: all sections',
            'bio_details' => 'Bio: analysis details only',
            'bio_files' => 'Bio: files only',
            'bio_pictures' => 'Bio: pictures only',
            'reagents' => 'reagents',
            'plates' => 'plates'
        ]]);
    echo $this->BootstrapForm->addActionButtons();
    echo $this->BootstrapForm->get_js();
    echo $this->BootstrapForm->end();


    echo $this->Form->create('Analysis');
    echo $this->Form->input('set_code', array('type' => 'hidden', 'value' => $set_code));
    echo $this->Form->input('key', array('type' => 'hidden', 'value' => 'new'));
    echo $this->My->makeInputRow('title', ['label' => '' , 'oninput' => 'fix("newTitle")', 'id' => 'newTitle', 'placeholder' => 'New Analysis title'], 'Title');
    echo $this->My->makeInputRow('workflow', ['label' => '','options' => ['chem_everything' => 'Chem: all sections', 'chem_details' => 'Chem: analysis details only', 'chem_files' => 'Chem: files only', 'chem_pictures' => 'Chem: pictures only', 'bio_everything' => 'Bio: all sections', 'bio_details' => 'Bio: analysis details only', 'bio_files' => 'Bio: files only', 'bio_pictures' => 'Bio: pictures only', 'reagents' => 'reagents', 'plates' => 'plates' ]], 'Workflow');
    echo $this->Form->end(['label' => 'Create', 'class' => 'large-button anySizeButton green-button']);
?>
<?php
$titles = array();
foreach ($results as $res){
    array_push($titles, $res['Analysis']['title']);
}
?>
<ul class="nav nav-tabs">
    <?php foreach($titles as $index => $title):?>
        <li>
            <a href="#<?= $index ?>" data-toggle="tab"><?= $title ?></a>
        </li>
    <?php endforeach; ?>
    <li><a href="#add" data-toggle="tab">+</a></li>
</ul>
<div class="tab-content">
    <?php foreach ($results as $index => $row): ?>
        <div id="<?= $index?>" class="tab-pane fade in">
            <?= $this->element('analysis_tab', ['row' => $row, 'form_model' => 'Analysis.'.$index.'.']); ?>
        </div>
    <?php endforeach; ?>
    <div id="add" class="tab-pane fade">
        <span>This si in teh add panef</span>
    </div>
</div>
