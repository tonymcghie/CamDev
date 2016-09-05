/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function newRow(){
    var row = $("<tr></tr>");
    var compound = $('<td><input type="text" placeholder="Compounds"></td>');
    var moleWeight = $('<td><input type="text" placeholder="Molicular Weight"></td>');
    var Concentration  = $('<td><input type="text" placeholder="Concentration"></td>');
    var vol = $('<td><input type="text" placeholder="Volume"></td>');
    var quantityRequired = $('<td><input type="text" placeholder="Quantity Required"></td>');        
    
    row.append(compound);
    row.append(moleWeight);
    row.append(Concentration);
    row.append(vol);
    row.append(quantityRequired);
    return row;
}

function calculate(tableID){
    $('#tableID tr').each(function() {
        $(this).find('td').eq(colindex).find('input').val();
    }
}


