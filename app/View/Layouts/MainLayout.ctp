
<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
            <?php echo $this->fetch('title'); ?>
	</title>
        <link rel="shortcut icon" href="img/cam.ico"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300italic,300,500,500italic|Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>

	<?php
		echo $this->Html->css(array ('bootstrap.min', 'materialize_colors'));/* , 'main_'.getenv('CSS_VERSION'),'button_'.getenv('CSS_VERSION'), 'simple-sidebar_'.getenv('CSS_VERSION'), 'custom_'.getenv('CSS_VERSION') */
		echo $this->Html->script('jquery-3.1.1.min', ['inline' => true]);
		echo $this->Html->script('bootstrap.min', ['inline' => false, 'async' => 'async']);
		echo $this->Html->script('ajax_helper', ['inline' => false, 'async' => 'async']);
        echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div>
		<div>
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
</body>
</html>
