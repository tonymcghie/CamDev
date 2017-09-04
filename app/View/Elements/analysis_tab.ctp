<?php
    /**
     * returns the pane for the analysis sample set page
     * @param type $row
     * @param type $form_model
     * @return string
     */
    echo $this->Html->script('ckeditor/ckeditor' ,  array('inline' => false));
?>

<div id="<?php echo $row['Analysis']['title'];?>pane" name="panes" class='tab-pane fade in active'>
    <div id="slide_1_<?php echo $row['Analysis']['title'];?>pane">
        <fieldset><legend>Analysis Info</legend>
        <?php
        echo $this->Form->input($form_model.'title', array('label' => 'Edit Title:', 'value' => $row['Analysis']['title'], 'oninput' => 'fix("newTitle'.$row['Analysis']['title'].'")', 'id' => 'newTitle'.$row['Analysis']['title']));
        echo $this->Form->input($form_model.'id', array('label' => '', 'type' => 'hidden', 'value' => $row['Analysis']['id'], 'class' => 'ids'));

        if ($row['Analysis']['workflow'] == 'chem_everything' || $row['Analysis']['workflow'] == 'chem_details' || $row['Analysis']['workflow'] == 'bio_everything' || $row['Analysis']['workflow'] == 'bio_details'){
            echo $this->Form->input($form_model.'startdate', array('label' => 'Start date (dd/mm/yyyy):', 'value' => $row['Analysis']['startdate']));


            echo $this->Form->input($form_model.'method', array('label' => 'Method File:', 'value' => $row['Analysis']['method']));
            echo $this->Form->input($form_model.'labbook_ref', array('label' => 'Reference:', 'value' => $row['Analysis']['labbook_ref'], 'placeholder' => 'Lab Book/ MS #/ Job #'));
            echo $this->My->makeInputTextEd($form_model.'prep', []);
            //echo $this->Form->input($form_model.'prep', array('label' => 'Sample Preparation:', 'value' => $row['Analysis']['prep'], 'rows' => '5', 'cols' => '100'));
            echo $this->Form->input($form_model.'details', array('label' => 'Analysis Details:', 'value' => $row['Analysis']['details'], 'rows' => '5', 'cols' => '100'));
        }
        ?>
        </fieldset>
        <?php if($row['Analysis']['workflow'] == "reagents"): ?>
            <?php echo $this->html->script('Analyses/reagents.js', ['inline' => false]); 
                echo $this->fetch('script');?>
        <table id="reagentsTable">
            <tr>
                <td><input type="text" placeholder="Compound" id="Compounds"></td>
                <td><input type="text" placeholder="Molecular Weight (mol/g)" id="Mole_Weight"></td>
                <td><input type="text" placeholder="Concentration (mmol/L)" id="Concentration"></td>
                <td><input type="text" placeholder="Volume (mL)" id="Volume"></td>
                <td><input type="text" placeholder="Quantity Required (g)" id="Quan_Required"></td>
            </tr>
        </table>
        <button type="button" class="large-button anySizeButton green-button" onclick="calculate($('reagentsTable'));">Calculate</button>       
        <button type="button" class="large-button anySizeButton green-button" onclick="$('#reagentsTable > ').append(newRow());">Add Row</button>
        <?php elseif ($row['Analysis']['workflow'] == "plates"): ?>
        
        <?php endif; ?>
    </div>
	<?php if($row['Analysis']['workflow'] == 'chem_everything' || $row['Analysis']['workflow'] == 'chem_files' || $row['Analysis']['workflow'] == 'bio_everything' || $row['Analysis']['workflow'] == 'bio_files'): ?>
    <div id="slide_<?php echo (($row['Analysis']['workflow'] == 'files') ? '2' : '3')?>_<?php echo $row['Analysis']['title'];?>pane">
        <fieldset><legend>File Locations <span>(files stored in http://storage.powerplant.pfr.co.nz/output/chemistry/cam/...)</span></legend>
        <?php
        $urlAnalysis = $row['Analysis']['raw_data'];
        $urlProcessed = $this->My->makeDataURL($row['Analysis']['processed']);
        $urlResults = $this->My->makeDataURL($row['Analysis']['derived_results']);
        ?>
        <table  class="noFormat"> <!--//makes the table of files and open buttons-->
        <?php
        echo $this->Html->tableCells([[$this->Form->input($form_model.'raw_data', array('label' => 'Raw Data Location:', 'value' => $row['Analysis']['raw_data'])),
                    ''],
                [$this->Form->input($form_model.'derived_results', array('label' => 'Processed Data:', 'value' => $row['Analysis']['derived_results'])),
                    $this->Html->link('open',$urlResults,['target'=>'_blank', 'class' => 'find-button anySizeButton']),
                    '<label for="'.$form_model.'d_data">Upload New xlsx File</label>'.$this->Form->file($form_model.'d_data', [])],
                [$this->Form->input($form_model.'processed', array('label' => 'Additional Data: ', 'value' => $row['Analysis']['processed'])),
                    $this->Html->link('open',$urlProcessed,['target'=>'_blank', 'class' => 'find-button anySizeButton']),
                    '<label for="'.$form_model.'p_data">Upload New Any File</label>'.$this->Form->file($form_model.'p_data', [])]]);
        ?>
        </table>
        </fieldset>
    </div>
    <?php endif; /* The file inputs */?>
    <?php if($row['Analysis']['workflow'] == 'chem_everything' || $row['Analysis']['workflow'] == 'chem_pictures' || $row['Analysis']['workflow'] == 'bio_everything' || $row['Analysis']['workflow'] == 'bio_pictures'): ?>
    <div id="slide_2_<?php echo $row['Analysis']['title'];?>pane">
        <h2>Upload an Image</h2>
        <?php
        echo $this->Form->hidden($form_model.'imgURL', ['value' => $row['Analysis']['imgURL'], 'id' => $row['Analysis']['id'].'imgURL']);
        ?>
        <iframe id="<?php echo $row['Analysis']['id'];?>" class="iframeNoformat" src="<?php echo $this->Html->url(['controller' => 'Analyses', 'action' => 'uploadNewImg', '?' => ['id' => $row['Analysis']['id']]]);?>"></iframe>
        <?php
        //echo $this->Form->file($form_model.'newImg', ['class' => 'take-picture', 'accept' => 'image/*;capture=camera', 'id' => $row['Analysis']['id'], 'value' => $row['Analysis']['imgURL']]);
        echo '<div class="imgDiv" style="background-color: #000;" id="imgDiv'.$row['Analysis']['id'].'">';
        echo $this->Html->image(((intval($row['Analysis']['imgURL']) != 0) ? $this->My->makeImgURL($row['Analysis']['id'].'_0') : 'about:blank'), [
            'alt' => 'img',
            'id' => 'show-picture'.$row['Analysis']['id'],
            'height' => '300px',
            'style' => 'background-color: #FFFFFF;'
            ]);
        echo '</div>';
        echo $this->Form->input($form_model.'blobURL', ['id' => 'url'.$row['Analysis']['id'], 'type' => 'hidden']);
        ?>
    </div>
    <?php endif; /* The piture input */?>

</div>
