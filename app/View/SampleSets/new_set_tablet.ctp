<?php include('new_set.ctp');?>
<div id="slide1">
    <?php echo $this->fetch('slide1'); ?>
</div>
<div id="slide2" style="display: none;">
    <?php echo $this->fetch('slide2'); ?>
</div>
<?php echo $this->fetch('extras'); ?>
<span id="previous"><img src="<?php echo $this->webroot; ?>img/previous_tablet.png"></span>
<span id="next"><img src="<?php echo $this->webroot; ?>img/next_tablet.png"></span>

<script>
    var current = 0;
    var panes = ['slide1','slide2'];
    
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