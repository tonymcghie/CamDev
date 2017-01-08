<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
            CAM - <?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

                echo $this->Html->css(array ('page_'.getenv('CSS_VERSION'), 'button_'.getenv('CSS_VERSION'), 'color_schemes_'.getenv('CSS_VERSION'), 'tablet_styles_'.getenv('CSS_VERSION')));
                
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container" style="margin-bottom: 50%;display: none;/*hides the page untill it has the right class*/">
		<div id="content">
			<?php echo $this->fetch('content'); ?>                    
		</div>
	</div>
        
    <script>                
        function pre(){
        if (current===0)return;
        $('#'+panes[current]).hide('slide', {direction: 'right'}, 500, function(){
            current--;
            if (current===0){
                $('#previous').hide();
            } else {
                $('#previous').show();                
            }
            $('#next').show();
            $('#'+panes[current]).show('slide', {direction: 'left'}, 500);            
        });         
    }
    function next(){
        if (current+1 === panes.length)return;        
        $('#'+panes[current]).hide('slide', {direction: 'left'}, 500, function(){
            current++;
            if (current+1 === panes.length){
                $('#next').hide();
            } else {
                $('#next').show();                
            }
            $('#previous').show();
            $('#'+panes[current]).show('slide', {direction: 'right'}, 500);
        }); 
    }
    </script>
</body>
</html>

