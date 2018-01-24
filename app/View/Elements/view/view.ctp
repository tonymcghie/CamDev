<header>
<h1><?= $this->String->get_string('view', $this->name)?></h1>
</header>

<?php
    assert(isset($dataObject), 'The dataObject need to be passed in');
    assert(in_array('ViewableModel', class_implements($dataObject)),
        'The DataObject must implement Viewable');

    $displayData = $dataObject->getViewData();
    // Remove empty elements.
    $displayData = array_filter($displayData, function($item) {
        return !empty($item);
    });
    // Get the headings from the string helper.
    $displayData = array_map(function($key, $item) {
        if ($this->String->string_exists($key, $this->name)) {
            $heading = $this->String->get_string($key, $this->name);
        } else {
            $heading = $key;
        }
        if (isset($item['text']) && is_array($item['text'])) {
            $item['text'] = $this->String->get_string($item['text']['id'], $item['text']['set']);
        }
        if (isset($item['links'])) {
            foreach ($item['links'] as &$link) {
                if (is_array($link['text'])) {
                    $link['text'] = $this->String->get_string($link['text']['id'], $link['text']['set']);
                }
                if (is_array($link['url'])) {
                    $link['url'] = $this->Html->url($link['url']);
                } else {
                    $link['url'] = $this->webroot.$link['url'];
                }
            }
        }
        return array_merge($item, ['heading' => $heading]);
    }, array_keys($displayData), $displayData);

    $shortItemFilter = function($item) {
        return !isset($item['text']) || strlen(strval($item['text'])) < 100;
    };
    $longItemFilter = function ($item) use ($shortItemFilter) {
        return !$shortItemFilter($item);
    };
?>
<?php foreach (array_filter($displayData, $shortItemFilter) as $item): ?>
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
