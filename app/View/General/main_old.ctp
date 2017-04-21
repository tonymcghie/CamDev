<?php
    $this->assign('title', 'Chemistry WorkBench');
    echo $this->Html->script('jquery-3.1.1/jquery-3.1.1.min' , array('inline' => false));
    
?>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<div class="sidebar" id="sidebar">
    <img src="img/login_menu.png" class="menu" id="menuButton">    
    <?php if (isset($isTablet) && $isTablet === 'true'): ?>
    <?php $tabletView = 'true';?>
        <a href="<?php echo $this->Html->url(['controller' => 'General', 'action' => 'main', '?' => ['isTablet' => 'false']]);?>" class="switchImg" target="_self"><img src="<?php echo $this->webroot;?>img/tablet_view.png" class="switchImg"></a>
    <?php else: ?>
    <?php $tabletView = 'false';?>
        <a href="<?php echo $this->Html->url(['controller' => 'General', 'action' => 'main', '?' => ['isTablet' => 'true']]);?>" class="switchImg" target="_self"><img src="<?php echo $this->webroot;?>img/desktop_view.png" class="switchImg"></a>
    <?php endif; ?>    
        
    <?php if($tabletView === 'true'): ?>        
        <img src="<?php echo $this->webroot; ?>img/sidebar_toggle_hide.png" id="sidebarToggle1" class="sidebarToggle" style="z-index: 3;">
    <?php endif; ?>
        
    <ul id="menu" class="menu">
        <li><?php echo $this->Html->link('login', ['controller' => 'users', 'action' => 'login'], ['target' => 'mainFrame']); ?></li>
        <li><?php echo $this->Html->link('Logout',['controller' => 'users', 'action' => 'logout'], ['target' => 'mainFrame']); ?></li>
    </ul>
    <br />
    <br />
    <ul>
        <li id="default" class="selected">&nbsp;&nbsp;</li>
        <li id="analysis">&nbsp;&nbsp;</li>
        <li id="invDefault">&nbsp;&nbsp;</li>
        <li id="BlackWhite">&nbsp;&nbsp;</li>
        <!-- @colorScheme add another li with the id matching the class name of the new color scheme -->
    </ul>
    <h1><?php echo $this->Html->link('CAM', array('action' => 'info'), array('target' => 'mainFrame')); ?></h1>
    <h2>Sample Sets</h2>
    <?php //links go here
        if ($this->Session->read('Auth.User')!==null){
        echo $this->Html->link('New', array('controller' => 'SampleSets', 'action' => 'newSet', '?' => ['isTablet' => $isTablet]), array('target' => 'mainFrame' , 'class' => 'large-button green-button')).'<br>';}                
        echo $this->Html->link('Find', array('controller' => 'SampleSets','action' => 'searchSet'), array('target' => 'mainFrame' , 'class' => 'large-button green-button')).'<br>';
    ?>
    <h2>Compounds</h2>
    <?php
        echo $this->Html->link('Search', array('controller' => 'Compounds','action' => 'SearchCompound'), array('target' => 'mainFrame' , 'class' => 'large-button blue-button')).'<br>';
        echo $this->Html->link('Sub Structure Search', array('controller' => 'Compounds','action' => 'subSearch'), array('target' => 'mainFrame' , 'class' => 'large-button blue-button')).'<br>';
        if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
            echo $this->Html->link('Add', ['controller' => 'Compounds','action' => 'addCompound', '?' => ['isTablet' => $isTablet]], array('target' => 'mainFrame' , 'class' => 'large-button blue-button')).'<br>';}
    ?>
    <h2>PFR Data</h2>
    <?php
        echo $this->Html->link('Chemical', array('controller' => 'Compoundpfr_data','action' => 'findData'), array('target' => 'mainFrame' , 'class' => 'large-button red-button')).'<br>';
		echo $this->Html->link('Bioactivity', array('controller' => 'Bioactivitypfr_data','action' => 'findData'), array('target' => 'mainFrame' , 'class' => 'large-button red-button')).'<br>';        
        echo $this->Html->link('Graph', array('controller' => 'Compoundpfr_data','action' => 'graphData'), array('target' => 'mainFrame' , 'class' => 'large-button red-button')).'<br>';
        if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])) {
        echo $this->Html->link('Import', array('controller' => 'Compoundpfr_data','action' => 'import'), array('target' => 'mainFrame' , 'class' => 'large-button red-button')).'<br>';}
    ?>
    <h2>Unknown Compounds</h2>  
    <?php
        if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
            echo $this->Html->link('Add', array('controller' => 'Metabolites','action' => 'addMetabolite', '?' => ['isTablet' => $isTablet]), array('target' => 'mainFrame' , 'class' => 'large-button darkorange-button')).'<br>';}
        echo $this->Html->link('Search', array('controller' => 'Metabolites','action' => 'searchMetabolite'), array('target' => 'mainFrame' , 'class' => 'large-button darkorange-button')).'<br>';
    ?>
    <h2>General</h2>
    <?php
        if ($this->Session->read('Auth.User')!==null && in_array("PFR-GP-Biological Chemistry and Bioactives Group", $this->Session->read('Auth.User')['groups'])){
            echo $this->Html->link('Scripts', ['controller' => 'General','action' => 'scripts', '?' => ['isTablet' => $isTablet]], array('target' => 'mainFrame' , 'class' => 'large-button blue-button')).'<br>';}
        echo $this->Html->link('Info', array('controller' => 'General', 'action' => 'info'), ['target' => 'mainFrame', 'class' => 'large-button red-button']).'<br>';
        echo $this->Html->link('Clear Workbench', 'about:blank', ['target' => 'mainFrame', 'class' => 'large-button red-button']).'<br>';
    ?>
</div>
<?php if($tabletView === 'true'): ?>        
<img src="<?php echo $this->webroot; ?>img/sidebar_toggle.png" id="sidebarToggle2" class="sidebarToggle" style="z-index: 2;left: 0px;">
<?php endif; ?>
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
        if (isTabletView){
            $("#mainFrame").attr('style','position: absolute;top: 0px;left: -201px;width: 100%; z-index: 1;');
            $("#sidebar").attr('style','position: absolute;top: 0px;left: 0px;z-index: 3;box-shadow: 6px 6px 6px rgba(0,0,0,0.7);');
            $("#mainFrame").width($(window).width());
        } else {
            $("#mainFrame").width(($(window).width()-204));
        }
        tabletView = isTabletView;
        $("#sidebar").height($(window).height()-10);
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
    
    /**
     * This will show the log in and out menu
     */
    $("#menuButton").on('click', function(){
       $("#menu").toggle(); 
    });
    
    /**
     * This will hide the log in and out menu if anything but the menu is pressed
     */
    $("html").on('click',function(event){
        if (event.target.id !== "menu" && event.target.id !== "menuButton"){
            $("#menu").hide();
        } 
    });    
    
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
    
    /**
     * sets the color scheme when the main page is loaded
     */
    $('document').ready(function(){
        var colorScheme = document.cookie;
        colorScheme = colorScheme.split(';');
        for (var i = 0;i<colorScheme.length; i++){
            if (colorScheme[i].split('=')[0]==='colorScheme'){
                changeColorScheme(colorScheme[i].split('=')[1]);
            }
        }
    });
    /**
     * These handle the on click functions for changing the color schemes
     */
    $("#default").on('click', function(){
        changeColorScheme("default");
    });
    $("#analysis").on('click', function(){
        changeColorScheme("analysis");
    });
    $("#invDefault").on('click', function(){
        changeColorScheme("invDefault");
    });
    $("#BlackWhite").on('click', function(){
        changeColorScheme("BlackWhite");
    });  
    //@colorScheme add a new on click function of the new button (exactly the same as the others)
    
    
    /**
     * sets the classes of the container to be the same as the id that is passes to the function
     * @param {type} id
     * @returns {undefined}
     */
    function changeColorScheme(id){
        removeAllClasses();
        document.cookie="colorScheme="+id+"; expires=Thu, 18 Dec 2050 12:00:00 UTC";
        
        $("#"+id).addClass("selected");        
        
        $('#container').addClass(id);
        $('#mainFrame').contents().find('#container').addClass(id);
        $("#"+id).parent().hide().show(0); //calls a redraw so that the styls are updated imediatly
    }
    /**
     * removes all the classes from both the container div in the main layout and in the page
     * @returns {null}
     */
    function removeAllClasses(){
        $("#default").removeClass(); //removes the class on the buttons
        $("#analysis").removeClass();
        $("#invDefault").removeClass();
        $("#BlackWhite").removeClass();
        // @colorScheme add the new class in -> $("#newClass").removeClass();
        
        $('#container').removeClass();
        $('#mainFrame').contents().find('#container').removeClass();
    }  
    
    $("#sidebarToggle1").on('click', function(){
        hideSidebar();
    });
    $("#sidebarToggle2").on('click', function(){           
        showSidebar();
    });
    $('html').on('click', function(){      
    });
    
    /**
     * slides in the side bar. This is only used in tablet view
     * @returns {null}
     */
    function showSidebar(){
        $("#sidebar").show('slide', {direction: 'left'}, 500);   
        $("#sidebarToggle2").hide();
        $("#sidebarToggle1").show();
        sessionStorage.setItem('sidebarVis' , 'true'); //sets the session so the sidebar will stay visible if the page if refresed and stuff
    }
    
    /**
     * Instantly shows the sidebar used if the sidebar is not showing but should be
     * @returns {nulll}
     */
    function instShowSidebar(){
        $("#sidebar").show();
        showSidebar();
    }
    
    /**
     * slides the sidebar back. This is only used in tablet view
     * @returns {null}
     */
    function hideSidebar(){
        $("#sidebar").hide('slide', {direction: 'left'}, 500);
        $("#sidebarToggle1").hide();
        $("#sidebarToggle2").show();
        sessionStorage.setItem('sidebarVis' , 'false');
    }
    
    /**
     * Instantly hides the sidebar
     * used when the sidebar is showing but shouldnt be showing
     * @returns {null}
     */
    function instHideSidebar(){
        $("#sidebar").hide();
        hideSidebar();
    }
   
</script>
