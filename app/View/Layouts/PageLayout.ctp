<?php
$this->assign('title', 'Chemistry WorkBench');
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version());

assert(isset($group),
    'The \'$group\' variable is required for the menu to maintain state. Please set it in the controller.');

$sampleSetGroup = 'sampleSets';
$compoundsGroup = 'compounds';
$pfrDataGroup = 'pfrData';
$metabolomicDataGroup = 'metabolomicData';
$unknownCompoundsGroup = 'unknownCompounds';
$helpGroup = 'help';
$adminGroup = 'admin';
$toolsGroup = 'tools';
$preReleaseGroup = 'preRelease';
$inDevGroup = 'inDev';

// Set the group to sample set by default.
if (!isset($group)) {
    $group = $sampleSetGroup;
}
assert(in_array($group, [$sampleSetGroup,
    $compoundsGroup, $pfrDataGroup, $unknownCompoundsGroup, $helpGroup,
    $preReleaseGroup, $adminGroup, $toolsGroup, $metabolomicDataGroup, $inDevGroup]),
    "The group '$group' was not recognised.");
?>

<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title><?= $this->fetch('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    echo $this->Html->meta('favicon.ico','img/cam.ico',array('type' => 'icon'));

    echo $this->Html->css(['bootstrap.min', 'styles_required', 'materialize_colors', 'styles_content']);
    echo $this->Html->script('lib/jquery-3.1.1.min', ['inline' => true]);
    echo $this->Html->script('lib/jquery-ui-1.12.1/jquery-ui', ['inline' => true]);
    echo $this->Html->script('lib/bootstrap.min', ['inline' => true]);

    echo $this->Html->script('typescript/validator/validator.min', ['inline' => false, 'async' => 'async']);
    echo $this->Html->script('typescript/form_rules/displayif.min', ['inline' => false, 'async' => 'async']);


    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>

    <style>
        /* TODO remove */
        nav > .list-group > div {
            margin-bottom: 10px;
            cursor: pointer;
        }
        nav > .list-group > div > div.list-group {
            margin-bottom: 0px !important;
        }
        .content, nav {
            background-color: rgb(255, 255, 255);
        }

        .background {
            background-image: url('../img/vineyard-blenheim.jpg');
            background-size: cover;
            position: fixed;
            width: 100vw;
            height: 100vh;
            margin: 0;
            padding: 0;
            z-index: -1;
        }
    </style>
</head>
<body>
    <nav class="col-lg-2 col-md-2 layer-2" style="height: 100vh;overflow: auto;">
        <p><?php echo $this->Html->image('cam.png', array('alt' => 'CAM Logo', 'width' => '140')); ?> </p>
        <?php echo $this->Html->link('login', ['controller' => 'users', 'action' => 'login'], ['class' => 'btn btn-link']); ?>|
        <?php //echo $this->Html->link('CAM4login',['controller' => 'users', 'action' => 'cam4_login'], ['target' => 'mainFrame', 'class' => 'btn btn-link']); ?>
        <?php echo $this->Html->link('logout',['controller' => 'users', 'action' => 'logout'], ['class' => 'btn btn-link']); ?>

        <div class="panel-group" id="nav_accordion">
            <div class="panel panel-default">
                <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#sample_sets_menu">
                    <span>Sample Sets</span>
                </div>
                <div class="panel-collapse collapse <?php if ($group == $sampleSetGroup)echo 'in'; ?>"
                     id="sample_sets_menu">
                    <div class="panel-body light-blue lighten-3">
                        <?= $this->Html->link('Find', ['controller' => 'SampleSets', 'action' => 'search'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('New', ['controller' => 'SampleSets', 'action' => 'newSet'], ['class' => 'list-group-item']) ?>
                        <?= ''//$this->Html->link('Import Samples', ['controller' => 'SampleSets', 'action' => 'import'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('Import Samples', ['controller' => 'Samples', 'action' => 'import'], ['class' => 'list-group-item']) ?>
                        <!--links go here
                        if ($this->Session->read('Auth.User')!==null){-->
                        <?php /*echo $this->Html->link('New', ['controller' => 'SampleSets', 'action' => 'newSet'], ['target' => 'mainFrame', 'class' => 'btn btn-link']) */?>
                        <!--}-->
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#compounds_menu">
                    <span>Compounds</span>
                </div>
                <div class="panel-collapse collapse <?php if ($group == $compoundsGroup)echo 'in'; ?>" id="compounds_menu">
                    <div class="panel-body light-blue lighten-3">
                        <?= $this->Html->link('Find', ['controller' => 'Compounds', 'action' => 'search'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('New', ['controller' => 'Compounds', 'action' => 'addCompound'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('Identify by Mass', ['controller' => 'Identify', 'action' => 'SelectFile'], ['class' => 'list-group-item']) ?>

                        <?php
                        /*//if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
                        echo '<li>'. $this->Html->link('Add', ['controller' => 'Compounds','action' => 'addCompound'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                        echo '<li>'.$this->Html->link('ID by Mass', ['controller' => 'Identify','action' => 'idMass'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                        echo '<li>'.$this->Html->link('ID by Mass(ac)', ['controller' => 'Identify','action' => 'IdByMass'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                        //}
                        */?>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#pfr_data_menu">
                    <span>PFR Compound Data</span>
                </div>
                <div class="panel-collapse collapse <?php if ($group == $pfrDataGroup)echo 'in'; ?>" id="pfr_data_menu">
                    <div class="panel-body light-blue lighten-3">
                        <?= $this->Html->link('Find', ['controller' => 'Compoundpfr_data', 'action' => 'search'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('Overview', ['controller' => 'Compoundpfr_data', 'action' => 'overview'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('Graph', ['controller' => 'Compoundpfr_data', 'action' => 'graphData'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('Import', ['controller' => 'Compoundpfr_data', 'action' => 'import'], ['class' => 'list-group-item']) ?>
                        <?= ''//$this->Html->link('Find-Bioactivity', ['controller' => 'Bioactivitypfr_data', 'action' => 'search'], ['class' => 'list-group-item']) ?>
                        <?php
                        /*if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])) {
                        echo '<li>'.$this->Html->link('Import', array('controller' => 'Compoundpfr_data','action' => 'import'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                        }*/
                        ?>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#metabolomic_data_menu">
                    <span>Metabolomic Data</span>
                </div>
                <div class="panel-collapse collapse <?php if ($group == $metabolomicDataGroup )echo 'in'; ?>" id="metabolomic_data_menu">
                    <div class="panel-body light-blue lighten-3">
                        <?= $this->Html->link('Find', ['controller' => 'Molecular_features', 'action' => 'search'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('Overview', ['controller' => 'Molecular_features', 'action' => 'overview'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('Import', ['controller' => 'Molecular_features', 'action' => 'import'], ['class' => 'list-group-item']) ?>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#unknown_compounds_menu">
                    <span>Unknown Compounds</span>
                </div>
                <div class="panel-collapse collapse <?php if ($group == $unknownCompoundsGroup)echo 'in'; ?>" id="unknown_compounds_menu">
                    <div class="panel-body light-blue lighten-3">
                        <?= $this->Html->link('Find', ['controller' => 'Metabolites', 'action' => 'search'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('New', ['controller' => 'Metabolites', 'action' => 'newMetabolite'], ['class' => 'list-group-item']) ?>
                        <?php
                        /*if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
                            echo '<li>'.$this->Html->link('Add', ['controller' => 'Metabolites','action' => 'addMetabolite'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                        }*/
                        ?>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#general_menu">
                    <span>Getting Started</span>
                </div>
                <div class="panel-collapse collapse <?php if ($group == $helpGroup)echo 'in'; ?>" id="general_menu">
                    <div class="panel-body light-blue lighten-3">
                        <?= $this->Html->link('Info', ['controller' => 'General', 'action' => 'info'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('How To', ['controller' => 'General', 'action' => 'howto'], ['class' => 'list-group-item']) ?>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#help_menu">
                    <span>Tools</span>
                </div>
                <div class="panel-collapse collapse <?php if ($group == $toolsGroup)echo 'in'; ?>" id="help_menu">
                    <div class="panel-body light-blue lighten-3">
                        <?= ''//$this->Html->link('Scripts', ['controller' => 'General', 'action' => 'scripts'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('GCMS Utilities', ['controller' => 'General', 'action' => 'gcms'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('Data Templates', ['controller' => 'General', 'action' => 'templates'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('New Project', ['controller' => 'Projects', 'action' => 'addProject'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('Clear Workbench', ['controller' => 'General', 'action' => 'welcome'], ['class' => 'list-group-item']) ?>
                        <?php
                        /*if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
                            echo '<li>'.$this->Html->link('Scripts', ['controller' => 'General','action' => 'scripts'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                        }*/
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#admin_menu">
                    <span>Administration</span>
                </div>
                <div class="panel-collapse collapse <?php if ($group == $adminGroup)echo 'in'; ?>" id="admin_menu">
                    <div class="panel-body light-blue lighten-3">
                        <?= $this->Html->link('Find Analyst', ['controller' => 'Chemists', 'action' => 'search'], ['class' => 'list-group-item']) ?>
                        <?= $this->Html->link('New Analyst', ['controller' => 'Chemists', 'action' => 'newAnalyst'], ['class' => 'list-group-item']) ?>
                        <?php
                        /*if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
                            echo '<li>'.$this->Html->link('Scripts', ['controller' => 'General','action' => 'scripts'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                        }*/
                        ?>
                    </div>
                </div>
            </div>

            <p><br><?php echo $login_message; ?> </p>
            <p><?php //echo $login_name; ?> </p>
            
            <!--
            <div class="panel panel-default">
                <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#pre_release_menu">
                    <span>Pre Relase</span>
                </div>
                <div class="panel-collapse collapse <?php if ($group == $preReleaseGroup)echo 'in'; ?>" id="pre_release_menu">
                    <div class="panel-body light-blue lighten-3">
                        <?= $this->Html->link('Plates', ['controller' => 'inDev', 'action' => 'plates'], ['class' => 'list-group-item']) ?>
                    </div>
                </div>
            </div>
            -->
        </div>
    </nav>

    <div class="col-lg-10 col-md-10 container" id="container">
        <div class="content layer-2 col-lg-10 col-md-10" id="content">
            <?php echo $this->Flash->render(); ?>
            <?php echo $this->fetch('content'); ?>
        </div>
    </div>

    <div class="background"></div>
</body>
</html>
