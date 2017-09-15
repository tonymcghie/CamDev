<?php
$this->assign('title', 'New Compound');
?>
<header>
<h1><?php echo $this->String->get_string('title', 'Compound_form'); ?></h1>
<!--<p><?php echo $this->String->get_string('sub_title', 'Compound_form'); ?></p>-->
</header>
<?php
echo $this->BootstrapForm->create_horizontal('Compound', ['type' => 'file' ,'action' => 'createCompound']);
//to do make a clone button in the table
echo $this->BootstrapForm->input_horizontal('cas', ['label' => ['text' => $this->String->get_string('cas', 'Compound_form')],
    'required',]);
echo $this->BootstrapForm->input_horizontal('pub_chem', ['label' => $this->String->get_string('pub_chem', 'Compound_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('compound_name', ['label' => $this->String->get_string('compound_name', 'Compound_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('pseudonyms', ['label' => $this->String->get_string('pseudonyms', 'Compound_form'),
    'placeholder' => $this->String->get_string('pseudonyms_ph', 'Compound_form')]);
echo $this->BootstrapForm->input_horizontal('sys_name', ['label' => $this->String->get_string('sys_name', 'Compound_form'),
    'required']);
echo $this->BootstrapForm->input_horizontal('formula', ['label' => $this->String->get_string('formula', 'Compound_form'),
    'placeholder' => $this->String->get_string('formula_ph', 'Compound_form'), 'required']);
echo $this->BootstrapForm->input_horizontal('exact_mass', ['label' => $this->String->get_string('exact_mass', 'Compound_form'),
    'required']);
echo $this->BootstrapForm->input_horizontal('chemspider_id', ['label' => $this->String->get_string('chemspider_id', 'Compound_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('metlin_id', ['label' => $this->String->get_string('metlin_id', 'Compound_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('compound_type', ['label' => $this->String->get_string('compound_type', 'Compound_form'),
    'required', 'options' => $this->My->getChemicalClassOptions()]);
echo $this->BootstrapForm->input_horizontal('chemfinder_ref', ['label' => $this->String->get_string('chemfinder_ref', 'Compound_form')]);
echo $this->BootstrapForm->input_horizontal('comment', ['label' => $this->String->get_string('comment', 'Compound_form'),
    'placeholder' => $this->String->get_string('comment_ph', 'Compound_form'),
    'rows' => '3']);

$this->BootstrapForm->add_validator('requires', 'compound_name');
$this->BootstrapForm->add_validator('requires', 'sys_name');
$this->BootstrapForm->add_validator('requires', 'formula');
$this->BootstrapForm->add_validator('requires', 'exact_mass');

echo $this->BootstrapForm->input_maker('save', [
        'onclick' => 'submit_first_form(\'main_content\'); return false;'
    ], [
        'horizontal' => true,
        'type' => 'button'
]);

echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();
?>
    <?php
/**$compoundType_options = ['Known Compound' => 'Known Compound', 'Compound Class' => 'Compound Class', 'Label or Tag' => 'Label or Tag'];

echo $this->Form->create('Compound');
?><span id="unique"></span><?php
echo $this->My->makeInputRow('cas', ['id' => 'cas'], 'CAS Number:');
echo $this->My->makeInputRow('pub_chem', ['id' => 'cid'], 'PubChem CID: *');
echo $this->My->makeInputRow('compound_name', ['id' => 'name'], 'Compound Name:');
echo $this->My->makeInputRow('pseudonyms', [], 'Synonyms:');
echo $this->My->makeInputRow('sys_name', [], 'Systematic Name:');
echo $this->My->makeInputRow('formula', ['id' => 'formula'], 'Formula (CHNO...):');
echo $this->My->makeInputRow('exact_mass', ['id' => 'mass'], 'Exact (monoisotopic) mass:');
echo $this->My->makeInputRow('chemspider_id', ['type' => 'text'], 'ChemSpider ID:');
echo $this->My->makeInputRow('metlin_id', ['type' => 'text'], 'Metlin ID:');
//echo $this->My->makeInputRow('compound_type', ['options' => $compoundType_options], 'Chemical Class:');
echo $this->My->makeInputRow('compound_type', ['options' => $this->My->getChemicalClassOptions()], 'Chemical Class');
echo $this->My->makeInputRow('chemfinder_ref', [], 'ChemFinder Ref:');
echo $this->My->makeInputRow('comment', [], 'Additional Info:');
echo $this->Form->end(['label' => 'Save', 'class' => 'large-button anySizeButton green-button']);*/
?>
<script>
    <?php if (isset($alert)) :?>
        alert('<?php echo $alert;?>');
    <?php endif; ?>
    $('#cas').on('input',function(event){
        <?php
        echo $this->Js->request(['controller' => 'Compounds', 'action' => 'checkCAS'], [
            'async' => true,
            'method' => 'post',
            'data' => '{CAS: $("#cas").val()}',
            'dataExpression' => true,
            'success'=> ' 
                //$("#unique").html(data);
                    if (data === "true"){
                        $("#unique").attr("style", "color: green");
                        $("#unique").html("Compound is not in Database");                        
                    } else {
                        $("#unique").attr("style", "color: red");
                        $("#unique").html("Compound is already in Database");
                    }
                    ',
            'error' => '
                        alert(errorThrown);
                '
            ]);
        ?>
    });
    $('#cid').focusout(function(){
        $.ajax({async:true,
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
            success:function (data, textStatus) {
                for(var i = 0 ; i < data["PC_Compounds"][0]["props"].length ; i++){
                        if (data["PC_Compounds"][0]["props"][i]["urn"]["label"] === "Weight" && data["PC_Compounds"][0]["props"][i]["urn"]["name"] === "MonoIsotopic" &&  $('#mass').val() === ''){
                            $('#mass').val(data["PC_Compounds"][0]["props"][i]["value"]["fval"]);
                        }
                        if (data["PC_Compounds"][0]["props"][i]["urn"]["label"] ===  "Molecular Formula" &&  $('#formula').val() === ''){
                            $('#formula').val(data["PC_Compounds"][0]["props"][i]["value"]["sval"]);
                        }   
                    } 
                },
                type:"post",
                url:'http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/cid/'+$('#cid').val()+'/json'
            }); 
            $.ajax({async:true,
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
            success:function (data, textStatus) {
                if ($('#name').val() === ''){
                    $('#name').val(data["InformationList"]["Information"][0]["Synonym"][0]); 
                }
                },
                type:"post",
                url:'http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/cid/'+$('#cid').val()+'/synonyms/json'
            }); 
        
        
        <?php
        /*echo $this->Js->request('http://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/cid/'.$('#cid').val().'/json', [
            'async' => true,
            'method' => 'post',
            'data' => '{CAS: $("#cas").val()}',
            'dataExpression' => true,
            'success'=> ' 
                    $("body").html(JSON.stringify(data["PC_Compounds"][0]["props"]));
                    for(var i = 0 ; i < data["PC_Compounds"][0]["props"].length ; i++){
                        if (data["PC_Compounds"][0]["props"][i]["urn"]["label"] === "Weight" && data["PC_Compounds"][0]["props"][i]["urn"]["name"] === "MonoIsotopic"){
                            alert(data["PC_Compounds"][0]["props"][i]["value"]["fval"]);
                        }
                        if (data["PC_Compounds"][0]["props"][i]["urn"]["label"] ===  "Molecular Formula"){
                            alert(data["PC_Compounds"][0]["props"][i]["value"]["sval"]);
                        }   
                    }
                    ',
            'error' => '
                    alert(errorThrown);
                '
            ]);*/
        ?>
    });
</script>
