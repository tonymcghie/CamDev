<?php
    $this->assign('title', 'Chemistry WorkBench');
    echo $this->Html->script('jquery-3.1.1/jquery-3.1.1.min' , array('inline' => false));
?>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<div class="content-wrapper">
    <div class="sidebar col-lg-1 col-md-1 col-sm-1" id="sidebar">
    <p><?php echo $this->Html->image('cam.png', array('alt' => 'CAM Logo', 'width' => '140')); ?> </p>
        <ul id="menu" class="menu">
            <li><?php echo $this->Html->link('login', ['controller' => 'users', 'action' => 'login'], ['target' => 'mainFrame']); ?></li>| 
            <li><?php echo $this->Html->link('logout',['controller' => 'users', 'action' => 'logout'], ['target' => 'mainFrame']); ?></li>
        </ul>
        <ul style="clear:left">
            <li>Sample Sets
            <ul>
                <?php //links go here
                //if ($this->Session->read('Auth.User')!==null){
                echo '<li>'.$this->Html->link('New', array('controller' => 'SampleSets', 'action' => 'newSet'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
              //}
                echo '<li>'.$this->Html->link('Find', array('controller' => 'SampleSets','action' => 'searchSet'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                        echo '<li>'.$this->Html->link('Import Samples', array('controller' => 'Samples','action' => 'import'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                ?>
            </ul>
        </li>
        <li>Compounds
            <ul>
            <?php
                echo '<li>'.$this->Html->link('Find', array('controller' => 'Compounds','action' => 'SearchCompound'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('Sub Structure Search', array('controller' => 'Compounds','action' => 'subSearch'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                //if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
                    echo '<li>'.
          $this->Html->link('Add', ['controller' => 'Compounds','action' => 'addCompound'], array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('ID by Mass', array('controller' => 'Identify','action' => 'SelectFile'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                  //}
            ?>
            </ul>
        </li>
        <li>PFR Compound Data
            <ul>
            <?php
                echo '<li>'.$this->Html->link('Find', array('controller' => 'Compoundpfr_data','action' => 'findData'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('Overview', array('controller' => 'Compoundpfr_data','action' => 'reviewData'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('Graph', array('controller' => 'Compoundpfr_data','action' => 'graphData'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                //if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])) {
                //echo '<li>'.$this->Html->link('Import', array('controller' => 'Compoundpfr_data','action' => 'import'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('Import', array('controller' => 'CompoundpfrData','action' => 'import'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('Find-Bioactivity', array('controller' => 'Bioactivitypfr_data','action' => 'findData'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
              //}
            ?>
            </ul>
        </li>
        <li>Metabolomics Data
            <ul>
            <?php
                echo '<li>'.$this->Html->link('Find', array('controller' => 'Molecular_features','action' => 'findData'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('Overview', array('controller' => 'Molecular_features','action' => 'reviewData'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('Import', array('controller' => 'Molecular_features','action' => 'import'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                //}
            ?>
            </ul>
        </li>
        <li>Unknown Compounds
            <ul>
            <?php
                if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
                    echo '<li>'.
          $this->Html->link('Add', array('controller' => 'Metabolites','action' => 'addMetabolite'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                }
                echo '<li>'.$this->Html->link('Find', array('controller' => 'Metabolites','action' => 'searchMetabolite'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('Add', array('controller' => 'Metabolites','action' => 'addMetabolite'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
            ?>
            </ul>
        </li>
        <li>Tools
            <ul>
            <?php
                if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
                    echo '<li>'.
          $this->Html->link('Scripts', ['controller' => 'General','action' => 'scripts'], array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                }
                echo '<li>'.$this->Html->link('Scripts', ['controller' => 'General','action' => 'scripts'], array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('GCMS Utilities', ['controller' => 'General','action' => 'gcms_utilities'], array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('Data Templates', ['controller' => 'General','action' => 'templates'], array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
                echo '<li>'.$this->Html->link('New Project', array('controller' => 'Projects', 'action' => 'addProject'), ['target' => 'mainFrame', 'class' => 'none']).'</li>';
                echo '<li>'.$this->Html->link('Info', array('controller' => 'General', 'action' => 'info'), ['target' => 'mainFrame', 'class' => 'none']).'</li>';        
                echo '<li>'.$this->Html->link('How To', array('controller' => 'General', 'action' => 'howto'), ['target' => 'mainFrame', 'class' => 'none']).'</li>';
                echo '<li>'.$this->Html->link('Feedback', array('controller' => 'Feedbacks', 'action' => 'new_feedback'), ['target' => 'mainFrame', 'class' => 'none']).'</li>';
                echo '<li>'.$this->Html->link('Clear Workbench', 'about:blank', ['target' => 'mainFrame', 'class' => 'none']).'</li>';
            ?>
            </ul>
            <ul>
                <?php
                    echo '<l1>'.$this->Html->link('plates', ['controller' => 'InDev', 'action' => 'plates'], ['target' => 'mainFrame', 'class' => 'none']).'</li>';
                    echo '<l1>'.$this->Html->link('Text Input', ['controller' => 'InDev', 'action' => 'text_input'], ['target' => 'mainFrame', 'class' => 'none']).'</li>';
                ?>
            </ul>
        </li>
      </ul>
    </div>

    <div class="frame  col-lg-11 col-sm-11 col-md-11" id="mainFrameDiv">
        <iframe name="mainFrame" id="mainFrame" onload="fixSize()" src="<?php echo $this->Html->url(['controller' => 'General', 'action' => 'blank']); ?>"></iframe>
    </div>
</div>

<script>
    /**
     * fixes the size of the iframe to fill the page
     * @returns {null}
     */
    function fixSize(){
        $('#mainFrame').css('background-image', 'url("img/pn_backgrounds/palmy_town.jpg")'); 
    };

    /**
     * This will show the log in and out menu
    
    $("#menuButton").on('click', function(){
       $("#menu").toggle();
    });
 */
    /**
     * This will hide the log in and out menu if anything but the menu is pressed
     
    $("html").on('click',function(event){
        if (event.target.id !== "menu" && event.target.id !== "menuButton"){
            $("#menu").hide();
        }
    });
*/
</script>
