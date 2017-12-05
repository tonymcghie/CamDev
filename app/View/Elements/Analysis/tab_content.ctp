<?php
/**
 * returns the pane for the analysis sample set page
 * @param array $analysis
 * @return string
 */
?>
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
            ['label' => 'Reference:', 'value' => $analysis['Analysis']['labbook_ref'], 'placeholder' => 'Lab Book/ MS #/ Job #']) ?>
        <?=  $this->BootstrapForm->input_horizontal('prep',
            ['label' => 'Sample Preparation:', 'value' => $analysis['Analysis']['prep'], 'rows' => '5', 'cols' => '100']) ?>
        <?=  $this->BootstrapForm->input_horizontal( 'details',
            ['label' => 'Analysis Details:', 'value' => $analysis['Analysis']['details'], 'rows' => '5', 'cols' => '100']) ?>
</fieldset>
<fieldset>
    <legend>File Locations
        <span>(files stored in http://storage.powerplant.pfr.co.nz/output/chemistry/cam/...)</span>
    </legend>
    <?php
    $urlAnalysis = $analysis['Analysis']['raw_data'];
    $urlProcessed = $this->My->makeDataURL($analysis['Analysis']['processed']);
    $urlResults = $this->My->makeDataURL($analysis['Analysis']['derived_results']);
    ?>
    <table class="noFormat"> <!--//makes the table of files and open buttons-->
        <?php
//                echo $this->Html->tableCells([[$this->Form->input($form_model . 'raw_data', array('label' => 'Raw Data Location:', 'value' => $row['Analysis']['raw_data'])),
//                    ''],
//                    [$this->Form->input($form_model . 'derived_results', array('label' => 'Processed Data:', 'value' => $row['Analysis']['derived_results'])),
//                        $this->Html->link('open', $urlResults, ['target' => '_blank', 'class' => 'find-button anySizeButton']),
//                        '<label for="' . $form_model . 'd_data">Upload New xlsx File</label>' . $this->Form->file($form_model . 'd_data', [])],
//                    [$this->Form->input($form_model . 'processed', array('label' => 'Additional Data: ', 'value' => $row['Analysis']['processed'])),
//                        $this->Html->link('open', $urlProcessed, ['target' => '_blank', 'class' => 'find-button anySizeButton']),
//                        '<label for="' . $form_model . 'p_data">Upload New Any File</label>' . $this->Form->file($form_model . 'p_data', [])]]);
        ?>
    </table>
</fieldset>
<?php endif; /* The file inputs */ ?>
<?php if ($analysis['Analysis']['workflow'] == 'chem_everything'
        || $analysis['Analysis']['workflow'] == 'chem_pictures'
        || $analysis['Analysis']['workflow'] == 'bio_everything'
        || $analysis['Analysis']['workflow'] == 'bio_pictures'): ?>
    <h2>Upload an Image</h2>
    <?php
//        echo $this->Form->hidden($form_model . 'imgURL', ['value' => $currentAnalysis['Analysis']['imgURL'], 'id' => $currentAnalysis['Analysis']['id'] . 'imgURL']);
    ?>
    <!--        <iframe id="--><?php //echo $row['Analysis']['id'];?><!--" class="iframeNoformat" src="--><?php //echo $this->Html->url(['controller' => 'Analyses', 'action' => 'uploadNewImg', '?' => ['id' => $row['Analysis']['id']]]);?><!--"></iframe>-->
    <!---->
    <!--        <div id="imagesCarousel" class="carousel slide" data-ride="carousel">-->
    <!--            <ol class="carousel-indicators">-->
    <!--                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>-->
    <!--                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>-->
    <!--                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
    <!--            </ol>-->
    <!--            <div class="carousel-inner" role="listbox">-->
    <!--                <div class="carousel-item active">-->
    <!--                    <img class="d-block img-fluid" src="..." alt="First slide">-->
    <!--                </div>-->
    <!--                <div class="carousel-item">-->
    <!--                    <img class="d-block img-fluid" src="..." alt="Second slide">-->
    <!--                </div>-->
    <!--                <div class="carousel-item">-->
    <!--                    <img class="d-block img-fluid" src="..." alt="Third slide">-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <a class="carousel-control-prev" href="#imagesCarousel" role="button" data-slide="prev">-->
    <!--                <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
    <!--                <span class="sr-only">Previous</span>-->
    <!--            </a>-->
    <!--            <a class="carousel-control-next" href="#imagesCarousel" role="button" data-slide="next">-->
    <!--                <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
    <!--                <span class="sr-only">Next</span>-->
    <!--            </a>-->
    <!--        </div>-->

    <?php
    //echo $this->Form->file($form_model.'newImg', ['class' => 'take-picture', 'accept' => 'image/*;capture=camera', 'id' => $row['Analysis']['id'], 'value' => $row['Analysis']['imgURL']]);
//        echo '<div class="imgDiv" style="background-color: #000;" id="imgDiv'.$row['Analysis']['id'].'">';
//        echo $this->Html->image(((intval($row['Analysis']['imgURL']) != 0) ? $this->My->makeImgURL($row['Analysis']['id'].'_0') : 'about:blank'), [
//            'alt' => 'img',
//            'id' => 'show-picture'.$row['Analysis']['id'],
//            'height' => '300px',
//            'style' => 'background-color: #FFFFFF;'
//            ]);
//        echo '</div>';
//        echo $this->Form->input($form_model . 'blobURL', ['id' => 'url' . $currentAnalysis['Analysis']['id'], 'type' => 'hidden']);
    ?>
<?php endif; /* The piture input */ ?>
<?php
echo $this->BootstrapForm->addActionButtons();
echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();
?>
