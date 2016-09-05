<?php include('add_metabolite.ctp'); ?>
<div id="slide1">
    <?php echo $this->fetch('Metabolite'); ?>
</div>
<div id="slide2" style="display: none;">
    <?php echo $this->fetch('ProMetabolite'); ?> 
</div>
<div id="slide3"  style="display: none;">
    <?php echo $this->fetch('MsmsMetabolite'); ?>
</div>

<span id="previous"><img src="<?php echo $this->webroot; ?>img/previous_tablet.png"></span>
<span id="next"><img src="<?php echo $this->webroot; ?>img/next_tablet.png"></span>

<script>
    var current = 0;
    var panes = ['slide1','slide2','slide3'];
    
    $("#previous").on('click', function(){
        pre();
    });
    $("#next").on('click', function(){
        next();
    });
    $("html").on("swiperight",function(){
        pre();
    });
    $("html").on("swipeleft",function(){
       next(); 
    });  
</script>
    

