<?php
var_dump($titles);
?>

<ul class="nav nav-tabs">
    <?php foreach($titles as $title):?>
        <li class="<?php if(isset($currentAnalysis) && $title['Msms_compound']['id'] == $currentAnalysis['Msms_compound']['id'])echo 'active';?>">
            <a href="<?= $this->Html->url([
                'controller' => 'Msms_compounds',
                'action' => 'editAnalysis',
                '?' => [
                    'compound_id' => $compound_id,
                    'id' => $title['Msms_compound']['id']]])?>">
                <?= $title['Msms_compound']['msms_title']; ?>
            </a>
        </li>
    <?php endforeach; ?>
    <li class="<?php if(!isset($currentAnalysis)) echo 'active'?>">
        <a href="<?= $this->Html->url([
            'controller' => 'Msms_compounds',
            'action' => 'newAnalysis',
            '?' => [
                'compound_id' => $compound_id]]);?>">+</a>
    </li>
</ul>