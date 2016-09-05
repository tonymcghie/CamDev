<?php
    $this->assign('title', 'Chemistry WorkBench');
    echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' , array('inline' => false));      
?>
<div class="sidebar" id="sidebar">
    <img src="img/login_menu.png" class="menu" id="menuButton">
    <ul id="menu" class="menu">
        <li><?php echo $this->Html->link('login', ['controller' => 'users', 'action' => 'login'], ['target' => 'mainFrame']); ?></li>
        <li><?php echo $this->Html->link('Logout',['controller' => 'users', 'action' => 'logout'], ['target' => 'mainFrame']); ?></li>
    </ul>
    <br /><br />
    <ul>
        <li id="default" class="selected">&nbsp;&nbsp;</li>
        <li id="analysis">&nbsp;&nbsp;</li>
        <li id="invDefault">&nbsp;&nbsp;</li>
        <li id="BlackWhite">&nbsp;&nbsp;</li>
    </ul>
    <h1><?php echo $this->Html->link('CAM', array('action' => 'info'), array('target' => 'mainFrame')); ?></h1>
    <h2>Sample Sets</h2>
    <?php //links go here
        echo $this->Html->link('New', array('action' => 'newSet'), array('target' => 'mainFrame' , 'class' => 'large-button green-button')).'<br>';                
        echo $this->Html->link('Find', array('action' => 'searchSet'), array('target' => 'mainFrame' , 'class' => 'large-button green-button')).'<br>';
    ?>
    <h2>Compounds</h2>
    <?php
        echo $this->Html->link('Add', array('controller' => 'Compounds','action' => 'addCompound'), array('target' => 'mainFrame' , 'class' => 'large-button blue-button')).'<br>';
        echo $this->Html->link('Search/Manage', array('controller' => 'Compounds','action' => 'SearchCompound'), array('target' => 'mainFrame' , 'class' => 'large-button blue-button')).'<br>';
        echo $this->Html->link('Adv. Search', array('controller' => 'Compoundpfr_data','action' => 'findData'), array('target' => 'mainFrame' , 'class' => 'large-button red-button')).'<br>';
    ?>
    <h2>Metabolites</h2>  
    <?php
        echo $this->Html->link('Add', array('controller' => 'Metabolites','action' => 'addMetabolite'), array('target' => 'mainFrame' , 'class' => 'large-button darkorange-button')).'<br>';
        echo $this->Html->link('Search', array('controller' => 'Metabolites','action' => 'searchMetabolite'), array('target' => 'mainFrame' , 'class' => 'large-button darkorange-button')).'<br>';
    ?>
    <br>
    <br>
    <h2>General</h2>
    <?php
        echo $this->Html->link('Info', array('controller' => 'SampleSets', 'action' => 'info'), ['target' => 'mainFrame', 'class' => 'large-button red-button']).'<br>';
        echo $this->Html->link('Clear Workbench', 'about:blank', ['target' => 'mainFrame', 'class' => 'large-button red-button']).'<br>';
    ?>
</div>
<div class="frame">
    <iframe name="mainFrame" id="mainFrame" onload="fixSize()" src="<?php echo $this->Html->url(['controller' => 'SampleSets', 'action' => 'blank']); ?>"></iframe>
</div>

<script>   
    $("#menuButton").on('click', function(){
       $("#menu").toggle(); 
    });
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
             $("#menu").hide();                             //will hide the menue if the iframe is clicked
        });
    });
    /**
     * These handle the on click functions
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
    
    /**
     * sets the classes of the container to be the same as the id that is passes to the function
     * @param {type} id
     * @returns {undefined}
     */
    function changeColorScheme(id){
        removeAllClasses();
        $("#"+id).addClass("selected");
        
        
        $('#container').addClass(id);
        $('#mainFrame').contents().find('#container').addClass(id);
        $("#"+id).parent().hide().show(0); //calls a redraw so that the styls are updated imediatly
    }
    /**
     * removes all the classes from both the container div in the main layout and in the page
     * @returns {undefined}
     */
    function removeAllClasses(){
        $("#default").removeClass(); //list of all the li's
        $("#analysis").removeClass();
        $("#invDefault").removeClass();
        $("#BlackWhite").removeClass();
        
        $('#container').removeClass();
        $('#mainFrame').contents().find('#container').removeClass();
    }  
    //$.fn.redraw = function(){ return $(this).each(function(){ var redraw = this.offsetHeight; }); };
</script>
