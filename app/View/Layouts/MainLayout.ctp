
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
        <link rel="shortcut icon" href="favicon.ico"/>
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300italic,300,500,500italic|Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>

	<?php
		//echo $this->Html->meta('icon');

		echo $this->Html->css(array ('bootstrap.min_'.getenv('CSS_VERSION'), 'main_'.getenv('CSS_VERSION'),'button_'.getenv('CSS_VERSION'), 'simple-sidebar_'.getenv('CSS_VERSION'), 'custom_'.getenv('CSS_VERSION')));

		echo $this->fetch('meta');
		echo $this->fetch('css');

		echo $this->fetch('script');
                echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js' , array('inline' => false));
	?>
</head>
<body>


	<div id="container" class="default">
		<div id="content">
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
    <script>
        $(document).ready(function(){
            if( window.innerHeight <= screen.height-300 || window.innerWidth+30 < screen.width) {
                //alert("This Software was produced to be used in a maximised window using it in a smaller window could result in some page formatting being messed up");
            }
        });

    </script>
</body>
</html>
