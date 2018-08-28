<?php
//var_dump($titles);
var_dump($currentMsms);
?>

<ul class="nav nav-tabs">
    <?php foreach($titles as $title):?>
        <li class="<?php if(isset($currentMsms) && $title['Msms_compound']['id'] == $currentMsms['Msms_compound']['id'])echo 'active';?>">
            <a href="<?= $this->Html->url([
                'controller' => 'Msms_compounds',
                'action' => 'editMsmsCompound',
                '?' => [
                    'compound_id' => $compound_id,
                    'id' => $title['Msms_compound']['id']]])?>">
                <?= $title['Msms_compound']['msms_title']; ?>
            </a>
        </li>
    <?php endforeach; ?>
    <li class="<?php if(!isset($currentMsms)) echo 'active'?>">
        <a href="<?= $this->Html->url([
            'controller' => 'Msms_compounds',
            'action' => 'editMsmsCompound',
            '?' => [
                'compound_id' => $compound_id]]);?>">+</a>
    </li>
</ul>