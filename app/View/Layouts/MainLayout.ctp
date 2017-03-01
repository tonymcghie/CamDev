
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

	<?php
		echo $this->Html->css(['bootstrap.min', 'styles_required', 'materialize_colors']);/* , 'main_'.getenv('CSS_VERSION'),'button_'.getenv('CSS_VERSION'), 'simple-sidebar_'.getenv('CSS_VERSION'), 'custom_'.getenv('CSS_VERSION') */
		echo $this->Html->script('lib/jquery-3.1.1.min', ['inline' => true]);
		echo $this->Html->script('lib/bootstrap.min', ['inline' => false, 'async' => 'async']);
		echo $this->Html->script('ajax_helper.min', ['inline' => false, 'async' => 'async']);

        echo $this->Html->script('typescript/validator/validator.min', ['inline' => false, 'async' => 'async']);
        echo $this->Html->script('typescript/form_rules/displayif.min', ['inline' => false, 'async' => 'async']);
        echo $this->Html->script('search_helper.min', ['inline' => false, 'async' => 'async']);

        echo $this->Html->script('lib/jquery-ui-1.12.1/jquery-ui', ['inline' => false, 'async' => 'async']);
        echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->css('styles_content', ['media' => 'none', 'onload' => 'if(media!=\'all\')media=\'all\'']);
	?>
</head>
<body>
	<div>
		<div>
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
    <script>
        var validators = [];
        $('button').on('click', function(event){
            event.preventDefault();
        });
    </script>
</body>
</html>
