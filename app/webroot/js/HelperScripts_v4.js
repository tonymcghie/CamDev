/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function getNewBox(count, cols, names, model){
    var newPair = "<table class='noFormat search'>";
    newPair += "<tr><td><div class='input select'><label for='"+model+"Cri"+count+"'></label><select name='data["+model+"][cri_"+count+"]' id='"+model+"Cri"+count+"'>";
    for (var i=0;i<cols.length;i++){
        newPair += "<option value="+cols[i]+">"+names[i]+"</option>";
    }
    newPair += "</select></div></td>";
    newPair += "<td><div class='input text'><label for='"+model+"Val"+count+"'></label><input name='data["+model+"][val_"+count+"]' type='text' id='"+model+"Val"+count+"'></div></td>"
    newPair += '<td><div class="input select"><label for="'+model+'Log'+count+'"></label><select id="'+model+'Log'+count+'" name="data['+model+'][log_'+count+']"><option value="AND">AND</option><option value="OR">mOR</option><option value="XOR">XOR</option><option value="NOT">NOT</option></select></div></td>';
    //newPair += '<td><div class="input select"><label for="'+model+'Match'+count+'"></label><select id="'+model+'Match'+count+'" name="data['+model+'][match_'+count+']"><option value="include">Includes</option><option value="exact">Exactly</option><option value="starts_with">Start with</option></select></div></td>';
    newPair += "</tr></table>";
    return newPair;
}
/**
 * #not used#
 * toggles the second feild depending on whether the first feild is checked
 * @param {type} checkbox
 * @param {type} dateField
 * @returns nothing
 */
function toggleDate(checkbox, dateField){
    dateField.toggle(checkbox.checked);
}

