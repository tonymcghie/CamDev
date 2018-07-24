<?php
$this->assign('title', 'New Compound');
?>
<header>
<h1><?php echo $this->String->get_string('title', 'Compound_form'); ?></h1>
<br>
<!--<p><?php echo $this->String->get_string('sub_title', 'Compound_form'); ?></p>-->
</header>
<div id="unique"> </div>
<?php
echo $this->BootstrapForm->create_horizontal('Compound', ['type' => 'file' ,'action' => 'addCompound']);
//to do make a clone button in the table
echo $this->BootstrapForm->input_horizontal('cas', ['label' => ['text' => $this->String->get_string('cas', 'Compound_form')],
    'required',
    'id' => 'CompoundCas']);
echo $this->BootstrapForm->input_horizontal('pub_chem', ['label' => $this->String->get_string('pub_chem', 'Compound_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('compound_name', ['label' => $this->String->get_string('compound_name', 'Compound_form'),
    'required',
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
    'type' => 'text',
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('canonical_smiles', ['label' => $this->String->get_string('canonical_smiles', 'Compound_form'),
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('metlin_id', ['label' => $this->String->get_string('metlin_id', 'Compound_form'),
    'type' => 'text',
    'autocomplete' => 'off']);
echo $this->BootstrapForm->input_horizontal('compound_type', ['label' => $this->String->get_string('compound_type', 'Compound_form'),
    'required', 'options' => $this->My->getChemicalClassOptions()]);
echo $this->BootstrapForm->input_horizontal('chemfinder_ref', ['label' => $this->String->get_string('chemfinder_ref', 'Compound_form')]);
echo $this->BootstrapForm->input_horizontal('comment', ['label' => $this->String->get_string('comment', 'Compound_form'),
    'placeholder' => $this->String->get_string('comment_ph', 'Compound_form'),
    'rows' => '3']);
echo $this->BootstrapForm->addActionButtons();

$this->BootstrapForm->add_validator('requires', 'compound_name');
$this->BootstrapForm->add_validator('requires', 'sys_name');
$this->BootstrapForm->add_validator('requires', 'formula');
$this->BootstrapForm->add_validator('requires', 'exact_mass');

echo $this->BootstrapForm->get_js();
echo $this->BootstrapForm->end();
?>
    
<script>
    <?php if (isset($alert)) :?>
        alert('<?php echo $alert;?>');
    <?php endif; ?>
    $('#CompoundCas').on('input',function(event){
        $.ajax({
            data:{value_to_send: $("#CompoundCas").val()},
            url: 'http://localhost/CAM4-test/Compounds/checkCAS/cas',
            cache: false,
            type: 'post',
            dataType: 'HTML',
            success: function (data) {
                //$('#unique').html(data);
                 if (data === "true"){
                        $("#unique").attr("style", "color: green");
                        $("#unique").html("Compound is not in Database");                        
                    } else {
                        $("#unique").attr("style", "color: red");
                        $("#unique").html("Compound is already in Database");
                    }
            }
        });
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
        
        
        
    });
</script>
