<?php
    $this->assign('title', 'Chemistry WorkBench');
    echo $this->Html->script('jquery-3.1.1/jquery-3.1.1.min' , array('inline' => false));




?>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<div id="expand-menu">


<a  class="menu-link" href="#">Menu</a>



<div class="sidebar" id="sidebar">


    <?php $tabletView = 'false';?>


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
        echo '<li>'.$this->Html->link('New', array('controller' => 'SampleSets', 'action' => 'newSet', '?' => ['isTablet' => $isTablet]), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
      //}
        echo '<li>'.$this->Html->link('Find', array('controller' => 'SampleSets','action' => 'searchSet'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
	        echo '<li>'.$this->Html->link('Import Samples', array('controller' => 'Samples','action' => 'import'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
    ?>
    </ul></li>
    <li>Compounds
    <ul>
    <?php
        echo '<li>'.$this->Html->link('Find', array('controller' => 'Compounds','action' => 'SearchCompound'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
        echo '<li>'.$this->Html->link('Sub Structure Search', array('controller' => 'Compounds','action' => 'subSearch'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
        //if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
            echo '<li>'.
  $this->Html->link('Add', ['controller' => 'Compounds','action' => 'addCompound', '?' => ['isTablet' => $isTablet]], array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
        echo '<li>'.$this->Html->link('ID by Mass', array('controller' => 'Identify','action' => 'SelectFile'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
          //}
    ?>
    </ul></li>
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
    </ul></li>
    <li>Metabolomics Data
    <ul>
    <?php
        echo '<li>'.$this->Html->link('Find', array('controller' => 'Molecular_features','action' => 'findData'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
        echo '<li>'.$this->Html->link('Overview', array('controller' => 'Molecular_features','action' => 'reviewData'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
	echo '<li>'.$this->Html->link('Import', array('controller' => 'Molecular_features','action' => 'import'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
        //}
    ?>
    </ul></li>
    <li>Unknown Compounds
    <ul>
    <?php
        if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
            echo '<li>'.
  $this->Html->link('Add', array('controller' => 'Metabolites','action' => 'addMetabolite', '?' => ['isTablet' => $isTablet]), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
        }
        echo '<li>'.$this->Html->link('Add', array('controller' => 'Metabolites','action' => 'addMetabolite', '?' => ['isTablet' => $isTablet]), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
        echo '<li>'.$this->Html->link('Find', array('controller' => 'Metabolites','action' => 'searchMetabolite'), array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
    ?>
    </ul></li>
    <li>Tools
    <ul>
    <?php
        if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
            echo '<li>'.
  $this->Html->link('Scripts', ['controller' => 'General','action' => 'scripts', '?' => ['isTablet' => $isTablet]], array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
        }
        echo '<li>'.$this->Html->link('Scripts', ['controller' => 'General','action' => 'scripts', '?' => ['isTablet' => $isTablet]], array('target' => 'mainFrame' , 'class' => 'none')).'</li>';
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
            ?>
        </ul>
    </li>
  </ul>
</div>


</div>


<div class="frame" id="mainFrameDiv">
    <iframe name="mainFrame" id="mainFrame" onload="fixSize(<?php echo $tabletView;?>)" src="<?php echo $this->Html->url(['controller' => 'General', 'action' => 'blank']); ?>"></iframe>
</div>

<script>
    var tabletView = 'false';

    /**
     * fixes the size of the iframe to fill the page
     * @param {boolean} isTabletView weather the page is in tablet view or not
     * @returns {null}
     */
    function fixSize(isTabletView){
        $("#mainFrame").width('100%');
        //tabletView = isTabletView;
        $("#sidebar").height($(window).height()-10);
        $('#mainFrame').css('background-image', 'url("img/pn_backgrounds/palmy_town.jpg")'); 
        /**$('#<?php echo $title.'pane' ?>').hide();
        //above lie is an example of how to transport a php variable into js*/
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
    /**
     * This handles when the iframe loads a new page
     */
    $("#mainFrame").on("load", function(){
        changeColorScheme($(".selected")[0].id);             //sets the class in the iframe to make it have the right colors
        $('#mainFrame').contents().find('#container').show(); //shows the page after the css has being added

        var mainFrame = $('#mainFrame').contents().get(0); //will get the contentes of the iframe
        $(mainFrame).bind('click', function(){
             $("#menu").hide();  //will hide the menue if the iframe is clicked
             if (tabletView)hideSidebar();
        });

        if (sessionStorage.getItem('sidebarVis') === 'false'){ //keeps the side bar in the same position
           instHideSidebar();
       } else {
           instShowSidebar();
       }
    });


</script>
