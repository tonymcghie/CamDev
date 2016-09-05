<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html style="margin: 0px;">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
            CAM - <?php echo $this->fetch('title'); ?>
	</title>       
	<?php
            echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js' , array('inline' => false));                  
            echo $this->Html->meta('icon');

            echo $this->Html->css(array ('page_'.getenv('CSS_VERSION'), 'button_'.getenv('CSS_VERSION'), 'color_schemes_'.getenv('CSS_VERSION')));

            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
	?>
</head>
<body style="overflow: hidden;">
	<div id="container" style="overflow: hidden;box-shadow: none;padding-top: 0px;margin: 0px;">
		<div id="content" style="overflow: hidden;box-shadow: none;margin: 0px;">
			<?php echo $this->fetch('content'); ?>                    
		</div>
	</div>
</body>
</html>

