<header>
<h1><?= $this->String->get_string($this->name, 'view')?></h1>
</header>

<?php
    assert(isset($dataObject), 'The dataObject need to be passed in');
    assert(in_array('ViewableModel', class_implements($dataObject)),
        'The DataObject must implement Viewable');

    $displayData = $dataObject->getViewData();
    // Remove empty elements.
    $displayData = array_filter($displayData, function($item) {
        return !empty($item) && !empty($item['text']);
    });
    // Get the headings from the string helper.
    $displayData = array_map(function($key, $item) {
        return array_merge($item, ['heading' => $this->String->get_string($this->name, $key)]);
    }, array_keys($displayData), $displayData);

    $shotItemFilter = function($item) {
        return strlen(strval($item['text'])) < 100;
    };
    $longItemFilter = function ($item) use ($shotItemFilter) {
        return !$shotItemFilter($item);
    };
?>
<?php foreach (array_filter($displayData, $shotItemFilter) as $item): ?>
    <div class="col-lg-4 col-md-6 col-sm-12 details-item">
        <?=  $this->Mustache->render('view/item',
            ['item' => $item])?>
    </div>
<?php endforeach; ?>

<?php foreach (array_filter($displayData, $longItemFilter) as $item): ?>
    <div class="col-lg-12 details-item">
        <?=  $this->Mustache->render('view/item',
            ['item' => $item])?>
    </div>
<?php endforeach; ?>

<?php
//echo '<table class="noFormat view" style="width:90%;">';
//echo '<tr><td colspan="2"><h2>Processed Data:</h2></td></tr>';
//foreach($deRes as $derived_result){
//    echo $this->Html->tableCells([$this->Form->input('derived_results', array('label' => $derived_result['Analysis']['title'].' Derived data:', 'value' => $derived_result['Analysis']['derived_results'], 'disabled' => 'disabled')),
//    $this->Html->link('open',$this->My->makeDataURL($derived_result['Analysis']['derived_results']),['target'=>'_blank', 'class' => 'find-button anySizeButton'])]);
//}
//echo '</table>';
?>
