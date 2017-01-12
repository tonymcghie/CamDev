<style>
    nav > div.list-group > div {
        margin-bottom: 10px;
    }
    nav > div.list-group > div > div.list-group {
        margin-bottom: 0px !important;
    }
    div.content_container {
        background-size: cover;
    }
    div.content_container div {
        background-color: rgba(200, 200, 200, 0.7);
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
<nav class="col-lg-2 col-md-3" style="height: 100vh;overflow: scroll;border-right: thin solid #000;">
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
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('SampleSets', 'newSet', '', $('#main_content'))">New</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('SampleSets', 'searchSet', '', $('#main_content'))">Find</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('Samples', 'importSamples', '', $('#main_content'))">Import Samples</button>
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
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('Compounds', 'subSearch', '', $('#main_content'))">Search</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('Compounds', 'addCompound', '', $('#main_content'))">Add</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('Identify', 'idMass', '', $('#main_content'))">ID by Mass</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('Identify', 'IdByMass', '', $('#main_content'))">ID by Mass(ac)</button>

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
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('Compoundpfr_data', 'findData', '', $('#main_content'))">Chemical</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('Bioactivitypfr_data', 'findData', '', $('#main_content'))">Bioactivity</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('Compoundpfr_data', 'graphData', '', $('#main_content'))">Graph</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('CompoundpfrData', 'import', '', $('#main_content'))">Import</button>

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
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('Metabolites', 'addMetabolite', '', $('#main_content'))">Add</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('Metabolites', 'searchMetabolite', '', $('#main_content'))">Search</button>
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
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('General', 'scripts', '', $('#main_content'))">Scripts</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('Projects', 'addProject', '', $('#main_content'))">New Project</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('General', 'info', '', $('#main_content'))">Info</button>
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('General', 'howto', '', $('#main_content'))">How To</button>
                    <button type="button" class="list-group-item" onclick="$('#main_content').html('');">Clear Workbench</button>
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
                    <button type="button" class="list-group-item" onclick="ajax_call_replace_url('SampleSets', 'newSet', '', $('#main_content'))">Plates</button>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid content_container"  style="height: 100vh; overflow-y: scroll">
    <div class="col-lg-10 col-lg-offset-1 content" id="main_content"></div>
</div>