<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title><?= $this->fetch('title'); ?></title>
        <link rel="shortcut icon" href="img/cam.ico"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
        echo $this->Html->css(['bootstrap.min', 'styles_required', 'materialize_colors']);
        echo $this->Html->script('lib/jquery-3.1.1.min', ['inline' => true]);
        echo $this->Html->script('lib/bootstrap.min', ['inline' => false, 'async' => 'async']);
        echo $this->Html->script('lib/jquery-ui-1.12.1/jquery-ui', ['inline' => false, 'async' => 'async']);

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        echo $this->Html->css('styles_content', ['media' => 'none', 'onload' => 'if(media!=\'all\')media=\'all\'']);
        $this->assign('title', 'Chemistry WorkBench');
        ?>

        <style>
            /* TODO remove */
            nav > div.list-group > div {
                margin-bottom: 10px;
                cursor: pointer;
            }
            nav > div.list-group > div > div.list-group {
                margin-bottom: 0px !important;
            }
            div.content_container {
                background-size: cover;
            }
            div.content_container .content, nav {
                background-color: rgb(255, 255, 255);
            }
            body{
                background-color: rgb(241, 241, 241);
            }

            div.content_container {background-image: url('../img/vineyard-blenheim.jpg');}

        </style>
    </head>
    <body>
        <div>
            <div>

                <nav class="col-lg-2 col-md-3 layer-2" style="height: 100vh;overflow: auto;">
                    <p><?php echo $this->Html->image('cam.png', array('alt' => 'CAM Logo', 'width' => '140')); ?> </p>
                    <?php echo $this->Html->link('login', ['controller' => 'users', 'action' => 'login'], ['target' => 'mainFrame', 'class' => 'btn btn-link']); ?>|
                    <?php echo $this->Html->link('logout',['controller' => 'users', 'action' => 'logout'], ['target' => 'mainFrame', 'class' => 'btn btn-link']); ?>

                    <div class="panel-group" id="nav_accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#sample_sets_menu">
                                <span>Sample Sets</span>
                            </div>
                            <div class="panel-collapse collapse in" id="sample_sets_menu">
                                <div class="panel-body light-blue lighten-3">
                                    <?= $this->Html->link('New', ['controller' => 'SampleSets', 'action' => 'newSet'], ['class' => 'list-group-item']) ?>
                                    <?= $this->Html->link('Find', ['controller' => 'SampleSets', 'action' => 'searchSet'], ['class' => 'list-group-item']) ?>
                                    <?= $this->Html->link('Import Samples', ['controller' => 'Samples', 'action' => 'importSamples'], ['class' => 'list-group-item']) ?>
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
                            <div class="panel-collapse collapse" id="compounds_menu">
                                <div class="panel-body light-blue lighten-3">
                                    <?= $this->Html->link('Search', ['controller' => 'Compounds', 'action' => 'subSearch'], ['class' => 'list-group-item']) ?>
                                    <?= $this->Html->link('Add', ['controller' => 'addCompound', 'action' => 'addCompound'], ['class' => 'list-group-item']) ?>
                                    <?= $this->Html->link('ID by Mass', ['controller' => 'Identify', 'action' => 'idMass'], ['class' => 'list-group-item']) ?>
                                    <?= $this->Html->link('ID by Mass(ac)', ['controller' => 'Identify', 'action' => 'IdByMass'], ['class' => 'list-group-item']) ?>

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
                                <span>PFR Data</span>
                            </div>
                            <div class="panel-collapse collapse" id="pfr_data_menu">
                                <div class="panel-body light-blue lighten-3">
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Compoundpfr_data', 'action' => 'findData'], true) ?>', $('#main_content'))">
                                        Chemical
                                    </button>
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Bioactivitypfr_data', 'action' => 'findData'], true) ?>', $('#main_content'))">
                                        Bioactivity
                                    </button>
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Compoundpfr_data', 'action' => 'graphData'], true) ?>', $('#main_content'))">
                                        Graph
                                    </button>
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Compoundpfr_data', 'action' => 'import'], true) ?>', $('#main_content'))">
                                        Import
                                    </button>

                                    <?php
                                    /*if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])) {
                                    echo '<li>'.$this->Html->link('Import', array('controller' => 'Compoundpfr_data','action' => 'import'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                                    }*/
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#unknown_compounds_menu">
                                <span>Unknown Compounds</span>
                            </div>
                            <div class="panel-collapse collapse" id="unknown_compounds_menu">
                                <div class="panel-body light-blue lighten-3">
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Metabolites', 'action' => 'addMetabolite'], true) ?>', $('#main_content'))">
                                        Add
                                    </button>
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Metabolites', 'action' => 'searchMetabolite'], true) ?>', $('#main_content'))">
                                        Search
                                    </button>
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
                                <span>General</span>
                            </div>
                            <div class="panel-collapse collapse" id="general_menu">
                                <div class="panel-body light-blue lighten-3">
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'General', 'action' => 'scripts'], true) ?>', $('#main_content'))">
                                        Scripts
                                    </button>
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Projects', 'action' => 'addProject'], true) ?>', $('#main_content'))">
                                        New Project
                                    </button>
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'General', 'action' => 'info'], true) ?>', $('#main_content'))">
                                        Info
                                    </button>
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'General', 'action' => 'howto'], true) ?>', $('#main_content'))">
                                        How To
                                    </button>
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="$('#main_content').html('');">
                                        Clear Workbench
                                    </button>
                                    <?php
                                    /*if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
                                        echo '<li>'.$this->Html->link('Scripts', ['controller' => 'General','action' => 'scripts'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                                    }*/
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#pre_release_menu">
                                <span>Pre Relase</span>
                            </div>
                            <div class="panel-collapse collapse" id="pre_release_menu">
                                <div class="panel-body light-blue lighten-3">
                                    <button type="button"
                                            class="list-group-item"
                                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'SampleSets', 'action' => 'newSet'], true) ?>', $('#main_content'))">
                                        Plates
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="container-fluid content_container"  style="height: 100vh; overflow-y: auto">
                    <div class="col-lg-10 col-lg-offset-1 content container layer-2" id="main_content">
                        <?php echo $this->Flash->render(); ?>
                        <?php echo $this->fetch('content'); ?>
                    </div>
                </div>



            </div>
        </div>
    </body>
</html>
