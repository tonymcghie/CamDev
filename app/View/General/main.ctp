<style>
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
    <?php if ($this->Session->read('Auth.User')['location'] == 'Palmerston North Research Centre'): ?>
        div.content_container {background-image: url('img/chemlab_pn.jpg');}
    <?php elseif ($this->Session->read('Auth.User')['location'] == 'Mt Albert Research Centre'): ?>
        div.content_container {background-image: url('img/chemlab_pn.jpg');}
    <?php elseif ($this->Session->read('Auth.User')['location'] == 'Ruakura Research Centre'): ?>
        div.content_container {background-image: url('img/chemlab_ruakura.jpg');}
    <?php elseif ($this->Session->read('Auth.User')['location'] == 'Lincoln Research Centre'): ?>
        div.content_container {background-image: url('img/chemlab_pn.jpg');}
    <?php elseif ($this->Session->read('Auth.User')['location'] == 'Otago University'): ?>
        div.content_container {background-image: url('img/chemlab_otago.jpg');}
    <?php else: ?>
        div.content_container {background-image: url('img/vineyard-blenheim.jpg');}
    <?php endif; ?>

</style>
<?php
    $this->assign('title', 'Chemistry WorkBench');
?>
<nav class="col-lg-2 col-md-3 layer-2" style="height: 100vh;overflow: auto;">
    <?php $tabletView = 'false';?>
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
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'SampleSets', 'action' => 'newSet'], true) ?>', $('#main_content'))">
                        New
                    </button>
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'SampleSets', 'action' => 'searchSet'], true) ?>', $('#main_content'))">
                        Find
                    </button>
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Samples', 'action' => 'importSamples'], true) ?>', $('#main_content'))">
                        Import Samples
                    </button>
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
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Compounds', 'action' => 'searchCompound'], true) ?>', $('#main_content'))">
                        Find
                    </button>
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Compounds', 'action' => 'subSearch'], true) ?>', $('#main_content'))">
                        Sub Structure Search
                    </button>
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Compounds', 'action' => 'addCompound'], true) ?>', $('#main_content'))">
                        Add
                    </button>
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Identify', 'action' => 'idMass'], true) ?>', $('#main_content'))">
                        ID by Mass
                    </button>
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Identify', 'action' => 'IdByMass'], true) ?>', $('#main_content'))">
                        ID by Mass(ac)
                    </button>

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
            <div class="panel-collapse collapse" id="pfr_data_menu">
                <div class="panel-body light-blue lighten-3">
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Compoundpfr_data', 'action' => 'findData'], true) ?>', $('#main_content'))">
                        Find
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
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Bioactivitypfr_data', 'action' => 'findData'], true) ?>', $('#main_content'))">
                        Find-Bioactivity
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
            <div class="panel-heading light-green lighten-3" data-toggle="collapse" data-parent="#nav_accordion" href="#metabolomic_menu">
                <span>Metabolomic Data</span>
            </div>
            <div class="panel-collapse collapse" id="metabolomic_menu">
                <div class="panel-body light-blue lighten-3">
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Molecular_features', 'action' => 'findData'], true) ?>', $('#main_content'))">
                        Find
                    </button>
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Molecular_features', 'action' => 'reviewData'], true) ?>', $('#main_content'))">
                        Overview
                    </button>
                    <button type="button"
                            class="list-group-item"
                            onclick="load_page('<?php echo $this->Html->url(['controller' => 'Molecular_features', 'action' => 'import'], true) ?>', $('#main_content'))">
                        Import
                    </button>

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
    <div class="col-lg-10 col-lg-offset-1 content container layer-2" id="main_content"></div>
</div>