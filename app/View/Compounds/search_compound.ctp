<?php
$title = "Find Compounds";
$model = "Compound";
$options = ['compound_name' => 'Compound Name',
'all' => 'All', 
'cas' => 'CAS',
'compound_type' => 'Chemical Class',
'exact_mass' => 'Exact Mass',
'[M-H]-' => '[M-H]-',
'[M+COOH-H]-' => '[M+COOH-H]-',
'[M+H]+' => '[M+H]+',
'[M+Na]+' => '[M+Na]+',
'pub_chem' => 'PubChem CID',
'chemspider_id' => 'ChemSpider ID',
'comment' => 'Additional Info'];

echo $this->element('search_form', ['model' => $model, 'title' => $title, 'category_options' => $options]); ?>
    
<?php
/**$this->Html->script('HelperScripts_'.getenv('CSS_VERSION'), array('inline' => false));
if (!isset($box_nums)){$box_nums=1;} //sets the box nums for the first time
echo $this->element('search_form', ['title' => $title, 'model' => $model, 'options' => $options, 'box_nums' => $box_nums]);

if (isset($results[0]['Compound'])){ 
 
    echo $this->Html->tableCells([$this->Form->radio('display',['monoisotopic mass' => 'monoisotopic mass', 'negative ions' => 'negative ions', 'positive ions' => 'positive ions'], ['id' => 'display', 'value' => 'monoisotopic mass'])]);
}
echo '</table></header>';

echo '<div  id="resultsTable">'; 
if (isset($results[0]['Compound'])){     
    foreach ($results as &$row){ //sets the colums for the negative and positive view
        $row['Compound']['[M-H]-']=$row['Compound']['exact_mass']-1.0078;
        $row['Compound']['[M+COOH-H]-']=$row['Compound']['exact_mass']+44.9977;
        $row['Compound']['[M+H]+']=$row['Compound']['exact_mass']+1.0078;
        $row['Compound']['[M+Na]+']=$row['Compound']['exact_mass']+22.9898;
    }    
    $names = array($this->Paginator->sort('compound_name', 'Name', ['data' => $data]),
        'Actions' ,
        $this->Paginator->sort('exact_mass', 'Exact Mass', ['data' => $data]),
        $this->Paginator->sort('exact_mass', '[M-H]-', ['data' => $data]),
        $this->Paginator->sort('exact_mass', '[M+COOH-H]-', ['data' => $data]),
        $this->Paginator->sort('exact_mass', '[M+H]+', ['data' => $data]),
        $this->Paginator->sort('exact_mass', '[M+Na]+', ['data' => $data]),
        $this->Paginator->sort('cas', 'CAS', ['data' => $data]),
        $this->Paginator->sort('formula', 'Formula', ['data' => $data]));
    $cols = array('compound_name', 'Actions', 'exact_mass', '[M-H]-', '[M+COOH-H]-','[M+H]+','[M+Na]+','cas', 'formula');
    $model = 'Compound';
    $type = 'Compound';
    echo $this->element('results_table', ['results' => $results, 'names' => $names, 'cols' => $cols, 'model' => $model, 'type' => $type, 'data' => $data, 'num' => $num]);      
} else if (isset($results)) {
    echo "No Compounds Found";
}
 echo '</div>';
?>
<div id="overlay" class="noFormat overlay">
    <img class="closeButton" id="closeButton" src="../img/close.png">
    <img src="" id="AtomImg" class="AtomImg">
    <iframe src="" id="3DAtom" class="AtomFrame"></iframe>
</div>
<script> //This just hides and unhides the colums when the radio buttons are pressed
    function popUp(cid){
        $("#AtomImg").attr('src', "https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/cid/"+cid+"/PNG");
        $("#3DAtom").attr('src', "http://pubchem.ncbi.nlm.nih.gov/vw3d/vw3d.cgi?axis=y&atm=-80&cid="+cid);        
        $("#overlay").fadeIn('fast');
    }
    $("#overlay").on('click',function(event){
        if(event.target.id === 'overlay' || event.target.id === 'closeButton'){
            $("#overlay").fadeOut('fast',function(){
                $("#AtomImg").attr('src', "_about:blank");
                $("#3DAtom").attr('src', ""); 
            }); 
        }
    });
        
    $("document").ready(function(){
        $('td:nth-child(4)').hide();
        $('td:nth-child(5)').hide();
        $('td:nth-child(6)').hide();
        $('td:nth-child(7)').hide();

        $('th:nth-child(4)').hide();
        $('th:nth-child(5)').hide();
        $('th:nth-child(6)').hide();
        $('th:nth-child(7)').hide();       
    });
    $("#displayMonoisotopicMass").change(function(){
        $('td:nth-child(4)').fadeOut('fast');
        $('td:nth-child(5)').fadeOut('fast');
        $('td:nth-child(6)').fadeOut('fast');
        $('td:nth-child(7)').fadeOut('fast');

        $('th:nth-child(4)').fadeOut('fast');
        $('th:nth-child(5)').fadeOut('fast');
        $('th:nth-child(6)').fadeOut('fast');
        $('th:nth-child(7)').fadeOut('fast'); 
    });
    $("#displayNegativeIons").change(function(){       
        $('td:nth-child(6)').fadeOut('fast',function(){
            $('td:nth-child(4)').fadeIn('fast'); 
        });
        $('td:nth-child(7)').fadeOut('fast', function(){
            $('td:nth-child(5)').fadeIn('fast');
        });
                
        $('th:nth-child(6)').fadeOut('fast', function(){
            $('th:nth-child(4)').fadeIn('fast');
        });
        $('th:nth-child(7)').fadeOut('fast', function(){
            $('th:nth-child(5)').fadeIn('fast');
        }); 
            
    });
    $("#displayPositiveIons").change(function(){
        $('td:nth-child(4)').fadeOut('fast',function(){
            $('td:nth-child(6)').fadeIn('fast');
        });
        $('td:nth-child(5)').fadeOut('fast',function(){
            $('td:nth-child(7)').fadeIn('fast');
        });                

        $('th:nth-child(4)').fadeOut('fast', function(){
            $('th:nth-child(6)').fadeIn('fast');
        });
        $('th:nth-child(5)').fadeOut('fast', function(){
            $('th:nth-child(7)').fadeIn('fast'); 
        });                
    });
    
    var boxnum=<?php echo $box_nums; ?>;    
    var cols =<?php echo json_encode(array_keys($options)); ?>;
    var names = <?php echo json_encode(array_values($options)); ?>;
    cols.splice(cols.length-1,1);  //removes the date option
    names.splice(names.length-1,1); //removes the date option
 * 
 * 
 */

    /**
     * adds another input pair    
     */
    //function add(){
    //    $('#boxes').append(getNewBox(boxnum, cols,names,'<?php echo $model; ?>')); //adds the new boxes the the section
    //    boxnum++; //increases the number of boxes passed to and from the view and controller
    //    $('#box_nums').val(boxnum); //updates the hidden input
    //}
    
//</script>
