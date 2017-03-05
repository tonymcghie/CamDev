<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>QUnit tests</title>
    <?php
    echo $this->Html->css(['qunit-2.1.1']);
    echo $this->Html->script('lib/qunit-2.1.1');

    echo $this->Html->script('lib/jquery-3.1.1.min');
    echo $this->Html->script('lib/bootstrap.min');
    echo $this->Html->script('ajax_helper.min');
    echo $this->Html->script('typescript/validator/validator.min');
    echo $this->Html->script('typescript/form_rules/displayif.min');
    echo $this->Html->script('search_helper.min');
    echo $this->Html->script('lib/jquery-ui-1.12.1/jquery-ui');

    echo $this->Html->script(['tests/ajax_helper.test', 'tests/validator.test', 'tests/search_helper.test']);
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
</head>
<body>
    <div id="qunit"></div>
    <div id="qunit-fixture">
        <?php echo $this->fetch('content'); ?>
    </div>
</body>
</html>