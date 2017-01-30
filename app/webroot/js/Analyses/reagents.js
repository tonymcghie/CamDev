/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function newRow() {
    var row = $("<tr></tr>");
    var compound = $('<td><input type="text" placeholder="Compound"></td>');
    var moleWeight = $('<td><input type="text" placeholder="Molecular Weight (g/mol)"></td>');
    var Concentration = $('<td><input type="text" placeholder="Concentration (mmol/L)"></td>');
    var vol = $('<td><input type="text" placeholder="Volume (mL)"></td>');
    var quantityRequired = $('<td><input type="text" placeholder="Quantity Required (g)"></td>');

    row.append(compound);
    row.append(moleWeight);
    row.append(Concentration);
    row.append(vol);
    row.append(quantityRequired);
    return row;
}

function calculate(mw, conc_mmol, vol_ml) {
    return mw * conc_mmol * vol_ml
}

//function calculate_old(tableID){
//$('#tableID tr').each(function() {
//$(this).find('td').eq(colindex).find('input').val();
//}
//}


