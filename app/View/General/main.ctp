<style>
    nav > div.list-group > div {
        margin-bottom: 10px;
    }
    nav > div.list-group > div > div.list-group {
        margin-bottom: 0px !important;
    }
</style>
<?php
    $this->assign('title', 'Chemistry WorkBench');
?>
<nav class="col-md-2" style="height: 100vh;overflow: scroll;border-right: thin solid #000;">
    <?php $tabletView = 'false';?>
    <p><?php echo $this->Html->image('cam.png', array('alt' => 'CAM Logo', 'width' => '140')); ?> </p>
    <?php echo $this->Html->link('login', ['controller' => 'users', 'action' => 'login'], ['target' => 'mainFrame', 'class' => 'btn btn-link']); ?>|
    <?php echo $this->Html->link('logout',['controller' => 'users', 'action' => 'logout'], ['target' => 'mainFrame', 'class' => 'btn btn-link']); ?>

    <div class="list-group" style="div{margin-bottom: 5px;}">
        <div>
            <button href="#sample_sets_menu" data-toggle="collapse" class="btn btn-default list-group-item light-green lighten-3">Sample Sets</button>
            <div class="list-group collapse light-green lighten-3" id="sample_sets_menu">
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('SampleSets', 'newSet', '', $('#main_content'))">New</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('SampleSets', 'searchSet', '', $('#main_content'))">Find</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('Samples', 'importSamples', '', $('#main_content'))">Import Samples</button>

                <!--links go here
                if ($this->Session->read('Auth.User')!==null){-->
                <?php /*echo $this->Html->link('New', ['controller' => 'SampleSets', 'action' => 'newSet'], ['target' => 'mainFrame', 'class' => 'btn btn-link']) */?>
                <!--}-->
            </div>
        </div>
        <div>
            <button href="#compounds_menu" data-toggle="collapse" class="btn btn-default list-group-item light-green lighten-3">Compounds</button>
            <div class="list-group collapse light-green lighten-3" id="compounds_menu">
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('Compounds', 'subSearch', '', $('#main_content'))">Search</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('Compounds', 'addCompound', '', $('#main_content'))">Add</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('Identify', 'idMass', '', $('#main_content'))">ID by Mass</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('Identify', 'IdByMass', '', $('#main_content'))">ID by Mass(ac)</button>

               <?php
                /*//if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
                echo '<li>'. $this->Html->link('Add', ['controller' => 'Compounds','action' => 'addCompound'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                echo '<li>'.$this->Html->link('ID by Mass', ['controller' => 'Identify','action' => 'idMass'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                echo '<li>'.$this->Html->link('ID by Mass(ac)', ['controller' => 'Identify','action' => 'IdByMass'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                //}
                */?>
            </div>
        </div>
        <div>
            <button href="#pfr_data_menu" data-toggle="collapse" class="btn btn-default list-group-item light-green lighten-3">PFR Data</button>
            <div class="list-group collapse light-green lighten-3" id="pfr_data_menu">
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('Compoundpfr_data', 'findData', '', $('#main_content'))">Chemical</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('Bioactivitypfr_data', 'findData', '', $('#main_content'))">Bioactivity</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('Compoundpfr_data', 'graphData', '', $('#main_content'))">Graph</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('CompoundpfrData', 'import', '', $('#main_content'))">Import</button>

                <?php
                /*if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])) {
                echo '<li>'.$this->Html->link('Import', array('controller' => 'Compoundpfr_data','action' => 'import'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                }*/
                ?>
            </div>
        </div>
        <div>
            <button href="#unknown_compounds_menu" data-toggle="collapse" class="btn btn-default list-group-item light-green lighten-3">Unknown Compounds</button>
            <div class="list-group collapse light-green lighten-3" id="unknown_compounds_menu">
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('Metabolites', 'addMetabolite', '', $('#main_content'))">Add</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('Metabolites', 'searchMetabolite', '', $('#main_content'))">Search</button>
                <?php
                /*if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
                    echo '<li>'.$this->Html->link('Add', ['controller' => 'Metabolites','action' => 'addMetabolite'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                }*/
                ?>
            </div>
        </div>
        <div>
            <button href="#general_menu" data-toggle="collapse" class="btn btn-default list-group-item light-green lighten-3">General</button>
            <div class="list-group collapse" id="general_menu">
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('General', 'scripts', '', $('#main_content'))">Scripts</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('Projects', 'addProject', '', $('#main_content'))">New Project</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('General', 'info', '', $('#main_content'))">Info</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('General', 'howto', '', $('#main_content'))">How To</button>
                <button type="button" class="list-group-item light-blue lighten-3" onclick="$('#main_content').html(' ');">Clear Workbench</button>
                <?php
                /*if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
                    echo '<li>'.$this->Html->link('Scripts', ['controller' => 'General','action' => 'scripts'], ['target' => 'mainFrame', 'class' => 'btn btn-link']).'</li>';
                }*/
                ?>
            </div>
        </div>
        <div>
            <button href="#pre_release_menu" data-toggle="collapse" class="btn btn-default list-group-item light-green lighten-3">Pre Relase</button>
            <div class="list-group collapse" id="pre_release_menu">
                <button type="button" class="list-group-item light-blue lighten-3" onclick="ajax_call_replace_url('SampleSets', 'newSet', '', $('#main_content'))">Plates</button>
            </div>
            <?php
            ?>
        </div>

    </div>
</nav>


<div class="col-md-10" id="main_content" style="height: 100vh; overflow-y: scroll">
</div>

<script>
    /**
     * changes the piture to the right one
     * @param {boolean} isTabletView weather the page is in tablet view or not
     * @returns {null}
     */
    function changePic(isTabletView){
        switch ('<?php echo (isset($this->Session->read('Auth.User')['location']) ? $this->Session->read('Auth.User')['location'] : "default" )?>'){
			case 'Palmerston North Research Centre':
				$('#mainFrame').css('background-image', 'url("img/chemlab_pn.jpg")');
                break;
            case 'Mt Albert Research Centre':
                $('#mainFrame').css('background-image', 'url("img/chemlab_pn.jpg")');
                break;
            case 'Ruakura Research Centre':
                $('#mainFrame').css('background-image', 'url("img/chemlab_ruakura.jpg")');
                break;
            case 'Lincoln Research Centre':
                $('#mainFrame').css('background-image', 'url("img/chemlab_pn.jpg")');
                break;
            case 'Otago University':
                $('#mainFrame').css('background-image', 'url("img/chemlab_otago.jpg")');
                break;
            default:
                $('#mainFrame').css('background-image', 'url("img/vineyard-blenheim.jpg")');
                break;
        };
    };
</script>
