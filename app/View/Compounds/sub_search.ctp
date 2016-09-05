<header>
<h1>Search By Substructure</h1>
<?php
echo $this->Form->create('PubChem');
echo $this->Form->input('smile', ['id' => 'smilie']);
echo $this->Form->end();
?>
<div style="text-align: center; margin-right: 20%">
<span class="large-button anySizeButton" id="search">Search</span>
<span class="large-button anySizeButton" id="showKetcher">Ketcher</span>
</div>
<div id="overlay" class="noFormat overlay">
    <img class="closeButton" id="closeButton" src="../img/close.png">
    <iframe src="<?php echo $this->Html->url('/app/webroot/ketcher/ketcher.html'); ?>" width="900" height="502" style="overflow: hidden;display: none;" id="ketcher"></iframe>
    <iframe src="" style="border: none;display: none;" id="pubchem"></iframe>
</div>
<span id="statusText"></span><img src="../img/searching.gif" id="state" style="display: none;width: 50px;height: 50px;margin-top: 1%;">
</header>
<table id="res" style="display: none;"> 
    <thead>
        <tr>
            <th>
                CID
            </th>
            <th>
                Actions
            </th>
            <th>
                Name
            </th>
            <th>
                Exact Mass
            </th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>

<script>   
//Overlay stuff
var currentOverlay = '';
var totalResults = 0;
var resultsDone = 0;
var results;
var iterator = 0;

$("#showKetcher").on('click', function(){
    currentOverlay = 'ketcher';
    $("#ketcher").show();
    $("#overlay").fadeIn('fast');   
});
function showPubChem(CID){
    currentOverlay = 'pubChem';
    $("#pubchem").attr('src', 'https://pubchem.ncbi.nlm.nih.gov/compound/'+CID).delay(10).show();
    $("#overlay").fadeIn('fast');
}

$("#overlay").on('click',function(event){
    if(event.target.id === 'overlay' || event.target.id === 'closeButton'){
        $("#overlay").fadeOut('fast'); 
        if (currentOverlay === 'ketcher'){
            $("#ketcher").hide();
            currentOverlay = '';
        } else if (currentOverlay === 'pubChem'){
            $("#pubchem").attr('src','_about:blank').hide();
            currentOverlay = '';
        }
    }
});
    
//searching stuff    
$("#search").on('click', function(){
    if (!$("#state").is(":visible")){
        startSearch();
    }    
});

var ListKey;
var CIDs;
/**
 * starts a new search process with pubchem
 * @returns {null} as the success function calls the next method
 */
function startSearch(){
    $("#state").show();
    $("#statusText").html('Waiting for response from PubChem');
    $.ajax({async:true,
        error:function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("There was an unrecoverable Error. Please try Starting the search again. Also ckeck if the smile code is correct.");
                        $("#state").hide();   
                        $("#statusText").html('');
                },
        success:function (data, textStatus) {  
                        ListKey = data['Waiting']['ListKey'];
                        showRes(data);
                },
        type:"post",
        url:"https:\/\/pubchem.ncbi.nlm.nih.gov\/rest\/pug\/compound\/substructure\/smiles\/"+ encodeURIComponent($("#smilie").val())+"\/json?MaxRecords=1000000"}); 
}
/**
 * checks if PubChem has finished
 * @param {String} listKey The key that PubChem returns when starting the search
 * @returns {undefined}
 */
function checkResult(listKey){
    $.ajax({async:true, error:function (XMLHttpRequest, textStatus, errorThrown) {
                        startSearch();
                }, success:function (data, textStatus) {                         
                        showRes(data);
                }, type:"post", url:"https:\/\/pubchem.ncbi.nlm.nih.gov\/rest\/pug\/compound\/listkey\/"+listKey+"\/cids\/json"});  
}
/**
 * starts the filtering process
 * @param {array} data (array of CIDs or the listKey)
 * @returns nothing
 */
function showRes(data){
    if (typeof data['Waiting'] !== 'undefined'){ //if the query has not finished try again
        setTimeout(function() {
            checkResult(ListKey);
        }, 10000);              
        return;
    }
    $("#statusText").html('Filtering Results');
    CIDs = [];
    resultsDone = 0;
    totalResults = data['IdentifierList']['CID'].length;
    results = data;
    iterator = 0;
    filterResults();
}
/**
 * recursivly filters the results using ajax.
 * does the next ajax call after the current one has finished
 * slower than doing them all at the same time but the requests will not time put
 * @returns {null}
 */
function filterResults(){
    <?php
    echo $this->Js->request(['controller' => 'Compounds', 'action' => 'filterSubStructRes'], [
            'async' => true,
            'method' => 'post',
            'data' => '{CID: results["IdentifierList"]["CID"][iterator]}',
            'dataExpression' => true,
            'type' => 'json',
            'success'=> ' 
                        resultsDone++; /* increase the number of results done so that the percentage is increased */
                        $("#statusText").html("Filtering Results: "+Math.round((resultsDone/totalResults)*100)+"% ");
                        
                        if (data.length !== 0){
                            CIDs.push(data);
                        }
                        if (iterator+1 >= totalResults){
                            drawRes();
                        } else {
                            iterator++
                            filterResults();
                        }
                                                
                    ',
            'error' => '
                iterator++;
                filterResults();
             '
            ]);
    ?>
}

/**
 * turns the results into a table to be displayed and changes the staus text
 * @returns {null} sets output to elements in the page
 */
function drawRes(){
    $("#statusText").html('Results: '+CIDs.length); 
    for (var i = 0;i<CIDs.length;i++){
        $('#res > tbody:last-child').append('<tr id="'+CIDs[i]["Compound"]["pub_chem"]+'"><td>'+CIDs[i]["Compound"]["pub_chem"]+'</td><td><span class="find-button blue-button" onclick="showPubChem('+CIDs[i]["Compound"]["pub_chem"]+')">Pub Chem</span></td><td>'+CIDs[i]["Compound"]["compound_name"]+'</td><td>'+CIDs[i]["Compound"]["exact_mass"]+'</td></tr>');
    } // loops throught the array of positive matches and adds a row to the table
    $("#res").show(); //shows the results table
    $("#state").hide(); //hides the gif
}

</script>
    
