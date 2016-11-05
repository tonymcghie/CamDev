<?php
    /**
     * makes the search form for sampleset search and compund pfr data search
     * @param type $title (goes in h1 tages at the top)
     * @param type $model (the model that the serach is for)
     * @param type $options (options of the search boxes like what coulms are included in all colums)
     * @param type $box_nums (number of serach boxes)
     * @return string (the html code for the search)
     */
?>
<header>
<h1><?php echo $title; ?></h1>
<p>Enter at least one condition to search for:</p>
</header>
<?php
if (!isset($url)){
    if ($model==='SampleSet'){
        $url = 'searchSet';
    } else if ($model==='Compoundpfr_data'){
        $url = 'findData';
	} else if ($model==='Bioactivitypfr_data'){
        $url = 'findData';
    } else if ($model==='Metabolite'){
        $url = 'searchMetabolite';
    } else if ($model==='Compound'){
        $url = 'searchCompound';
    }
}
echo $this->Form->create($model, ['action' => $url, 'class' => 'searchForm']);
echo $this->Form->input('num_boxes', array('type' => 'hidden', 'value' => $box_nums, 'id' => 'box_nums'));
 if ($model === 'SampleSet' || $model === 'Metabolite' || $model === 'Compoundpfr_data' || $model === 'Bioactivitypfr_data') : ?>
    <?php echo $this->Form->input('isDate', ['type' => 'checkbox', 'label' => 'Add Date Criteria', 'id' => 'isDate']); ?>
    <section id="dates" style="display:none;">
    <?php echo $this->Form->input('start_date', array('label' => 'Start Date', 'dateFormat' => 'DMY', 'minYear' => 2000, 'maxYear' => date('Y'), 'type' => 'date',
        'selected' => date($options['start_date']) ));
    unset($options['start_date']);
    echo $this->Form->input('end_date', array('label' => 'End Date', 'dateFormat' => 'DMY', 'minYear' => 2000, 'maxYear' => date('Y'), 'type' => 'date'));
    ?>
    </section>
    <script>
    $("#isDate").on("click",function(){
        $("#dates").toggle(this.checked); //shows the date crieria
        if (this.checked){ //changes the label on the check box to be show or hide
            $("label[for=isDate]").text("Hide Date");
        } else {
            $("label[for=isDate]").text("Add Date Crieria");
        }
    });
    $("document").ready(function(){  //hides or shows the dates section when the page loads
        $("#dates").toggle($("#isDate").is(":checked"));
    });
    </script>

<?php endif;?>
<section id="boxes" class="noFormat">
<table class="noFormat search">
<?php echo $this->Html->tableCells(['<label>Criteria</label>','<label>Value</label>','<label>Match</label>','<label>Logic</label>']); ?>
</table>
<?php
for ($i = 0;$i<$box_nums;$i++){ //adds the amount of inputs there were before the search
    echo $this->My->searchPair($i, $options);
}
?>
</section>
<table class="noFormat">
 <?php echo $this->Html->tableCells(['<button type="button" onclick="add()" class="large-button anySizeButton" id="addButton">Add Search Criteria</button>', 
	$this->Form->end(['label' => 'Search', 'class' => 'large-button anySizeButton'])]); ?>
</table>
