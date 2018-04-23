<h1>PFR Login</h1>
<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-offset-3 col-md-6 ">
<?php
echo $this->Form->create('User');
echo $this->Form->input('username');
echo $this->Form->input('password');
?>
<label for="data[User][rememberMe]">Remember Me</label>
<?php
echo $this->Form->checkbox('rememberMe');
echo $this->Form->end(['label' => 'Login', 'class' => 'large-button anySizeButton']);
?>
</div>