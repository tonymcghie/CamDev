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
				<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300italic,300,500,500italic|Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>
	<?php

			echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js' , array('inline' => false));
            echo $this->Html->meta('icon');

            echo $this->Html->css(array ('bootstrap.min_'.getenv('CSS_VERSION'), 'page_'.getenv('CSS_VERSION'), 'button_'.getenv('CSS_VERSION'), 'custom_'.getenv('CSS_VERSION')));
            //echo $this->Html->css(array ('page_'.getenv('CSS_VERSION'), 'button_'.getenv('CSS_VERSION'), 'color_schemes_'.getenv('CSS_VERSION')));
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
	?>
</head>
<body>



	<div id="container" class="container">
		<div class="row" id="content">
			<div class="col-xs-12">


			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
			</div>
		</div>
	</div>
</body>
</html>
