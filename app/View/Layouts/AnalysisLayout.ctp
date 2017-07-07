
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
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<?php
		echo $this->Html->meta('icon');

                echo $this->Html->css([
                    'bootstrap-3.3.7/bootstrap.min',
                    'page.css?'.filemtime('css/page.css'),
                    'button.css?'.filemtime('css/button.css'),
                    'analysis.css?'.filemtime('css/analysis.css'),
                    'custom.css?'.filemtime('css/custom.css')
                ]);

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="content" class="analysisStyle">
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
</body>
</html>
