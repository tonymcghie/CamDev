<?php
/**
 * returns the pane for the analysis sample set page
 * @param array $analysis
 * @return string
 */
?>

<?php
/**
 * code to initiate TinyMCE ex www.davidtan.org/cakephp-how-to-add-advanced-tinymce-textarea/
 */

echo $javascript->link('jquery-1.3.2.min', false);
echo $javascript->link('tiny_mce/tiny_mce.js', false);
?>
        <script type="text/javascript">
            tinyMCE.init({
                theme : "advanced",
                mode : "textareas",
                convert_urls : false,
                theme_advanced_buttons1 : "bold,italic,underline,blockquote,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
                theme_advanced_buttons2: "",
                theme_advanced_buttons3: "",
                theme_advanced_buttons4: "",
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left"
            });
        </script>

<textarea rows="4" cols="50">
At w3schools.com you will learn how to make a website. We offer free tutorials in all web development technologies.
</textarea>
        
<?php
echo $this->BootstrapForm->create_horizontal('Analysis', ['type' => 'file']);
echo $this->BootstrapForm->input_horizontal('title',
    ['type' => 'text', 'label' => 'Edit Title:', 'value' => $analysis['Analysis']['title']]);
echo $this->BootstrapForm->input_horizontal('id',
    ['label' => '', 'type' => 'hidden', 'value' => $analysis['Analysis']['id']]);
echo $this->BootstrapForm->input_horizontal('set_code',
['label' => '', 'type' => 'hidden', 'value' => $analysis['Analysis']['set_code']]); ?>
<fieldset>
    <legend>Analysis Info</legend>

    <?php if ($analysis['Analysis']['workflow'] == 'chem_everything'
            || $analysis['Analysis']['workflow'] == 'chem_files'
            || $analysis['Analysis']['workflow'] == 'bio_everything'
            || $analysis['Analysis']['workflow'] == 'bio_files'): ?>

        <?= $this->BootstrapForm->input_horizontal('startdate',
            ['label' => 'Start date (dd/mm/yyyy):', 'value' => $analysis['Analysis']['startdate']]) ?>
        <?=  $this->BootstrapForm->input_horizontal('method',
            ['label' => 'Method File:', 'value' => $analysis['Analysis']['method']]) ?>
        <?=  $this->BootstrapForm->input_horizontal('labbook_ref',
            ['label' => 'Reference:', 'value' => $analysis['Analysis']['labbook_ref'], 'placeholder' => 'Lab Book/MS #/Job # etc']) ?>
        <?=  $this->BootstrapForm->input_horizontal('prep',
            ['label' => 'Sample Preparation:', 'value' => $analysis['Analysis']['prep'], 'rows' => '5', 'cols' => '100']) ?>
        <?=  $this->BootstrapForm->input_horizontal( 'details',
            ['label' => 'Analysis Details:', 'value' => $analysis['Analysis']['details'], 'rows' => '5', 'cols' => '100']) ?>
        <?=  $this->BootstrapForm->input_horizontal( 'result_summary',
            ['label' => 'Results:', 'value' => $analysis['Analysis']['result_summary'], 'rows' => '5', 'cols' => '100']) ?>
        <?=  $this->BootstrapForm->input_horizontal( 'raw_data',
            ['label' => $this->String->get_string('rawData', 'Analysis'),
            'value' => $analysis['Analysis']['raw_data']]) ?>
</fieldset>
<fieldset>
    <legend>File Uploads
        <span>(to PowerPlant)</span>
    </legend>
    <?php
    //echo $this->BootstrapForm->input_horizontal('raw_data', [
    //        'label' => $this->String->get_string('rawData', 'Analysis'),
    //        'value' => $analysis['Analysis']['raw_data']]);
    echo $this->BootstrapForm->fileUpload('derived_results', [
        'label' => $this->String->get_string('processedData', 'Analysis'),
        'url' => $this->Html->url(['action' => 'uploadProcessedData'], true),
        'value' => $analysis['Analysis']['derived_results']]);
    echo $this->BootstrapForm->fileUpload('processed', [
        'label' => $this->String->get_string('resultsData', 'Analysis'),
        'url' => $this->Html->url(['action' => 'uploadResultsData'], true),
        'value' => $analysis['Analysis']['processed']]);
    ?>
</fieldset>
<?php endif; /* The file inputs */ ?>
<?php if ($analysis['Analysis']['workflow'] == 'chem_everything'
        || $analysis['Analysis']['workflow'] == 'chem_pictures'
        || $analysis['Analysis']['workflow'] == 'bio_everything'
        || $analysis['Analysis']['workflow'] == 'bio_pictures'): ?>
    <fieldset>
        <legend>Upload an Image</legend>
        <?= $this->BootstrapForm->immediateUpload('newImage', [
                'label' => $this->String->get_string('uploadImage', 'Analysis'),
                'callback' => 'addNewImageToGallery',
                'url' => $this->Html->url(['action' => 'uploadNewImage'], true)
            ]); ?>
        <div id="images-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox" id="images-carousel-items">

            </div>
            <ol class="carousel-indicators" id="images-carousel-indicators">

            </ol>
            <a class="carousel-control left" href="#images-carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control right" href="#images-carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <?= $this->Html->script('lib/mustache.min'); ?>
        <script>
            var indicatorTemplate = <?= $this->Mustache->getJSONPTemplates('Analysis/carousel_indicator') ?>;
            var itemTemplate = <?= $this->Mustache->getJSONPTemplates('Analysis/carousel_item') ?>;

            var carouselIndicators = $('#images-carousel-indicators');
            var carouselItems = $('#images-carousel-items');
            var i = 0;
            for (i = 0; i < <?= $analysis['Analysis']['imgURL']?>; i++) {
                addGalleryItem(i);
            }

            function addNewImageToGallery(filepath) {
                addGalleryItem(i);
                i = i + 1;
            }

            function addGalleryItem(index) {
                carouselIndicators.append(
                    Mustache.render(indicatorTemplate["Analysis/carousel_indicator"],
                        {"index": i, "active": index === 0})
                );
                carouselItems.append(
                    Mustache.render(itemTemplate["Analysis/carousel_item"],
                        {"url": '<?= $this->webroot?>data/images/analysis/<?=$analysis['Analysis']['id']?>_'+ index,
                        "active": index === 0})
                );
            }
        </script>
    </fieldset>
<?php endif; ?>
<?php
echo $this->BootstrapForm->addActionButtons();
echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();
?>
