<?php
var_dump($titles);
?>

<ul class="nav nav-tabs">
    <?php foreach($titles as $title):?>
        <li class="<?php if(isset($currentAnalysis) && $title['Analysis']['id'] == $currentAnalysis['Analysis']['id'])echo 'active';?>">
            <a href="<?= $this->Html->url([
                'controller' => 'Analyses',
                'action' => 'editAnalysis',
                '?' => [
                    'set_code' => $set_code,
                    'id' => $title['Analysis']['id']]])?>">
                <?= $title['Analysis']['title']; ?>
            </a>
        </li>
    <?php endforeach; ?>
    <li class="<?php if(!isset($currentAnalysis)) echo 'active'?>">
        <a href="<?= $this->Html->url([
            'controller' => 'Analyses',
            'action' => 'newAnalysis',
            '?' => [
                'set_code' => $set_code]]);?>">+</a>
    </li>
</ul>