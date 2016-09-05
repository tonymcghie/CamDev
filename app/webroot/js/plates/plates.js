/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function strToCoor(str, isEnd){
    var rowStr = str.substr(0, 1);
    var row;
    if(rowStr === 'a' || rowStr === 'A'){row = 0;}
    if(rowStr === 'b' || rowStr === 'B'){row = 1;}
    if(rowStr === 'c' || rowStr === 'C'){row = 2;}
    if(rowStr === 'd' || rowStr === 'D'){row = 3;}
    if(rowStr === 'e' || rowStr === 'E'){row = 4;}
    if(rowStr === 'f' || rowStr === 'F'){row = 5;}
    if(rowStr === 'g' || rowStr === 'G'){row = 6;}
    if(rowStr === 'h' || rowStr === 'H'){row = 7;}
    if(isEnd){
        var x = (str.substr(1))
        if(x === 12 || x === "12"){
            x = 0;
            row++;
        }
        return [x - 0, row];
    } else {
        return [(str.substr(1)) - 1, row];
    }   
}

function startStrToCoor(str, color){
    var arr = strToCoor(str, false);
    arr[2] = color;
    return arr;
}

function drawPlate(c, points){ 
    if(points === null)points = [[20,20,""]];
    var ctx = c.getContext("2d");
    var color = "";
    for (y=0;y<8;y++){
        for (x=0;x<12;x++){
            ctx.beginPath();
            ctx.arc(x*22 + 20, y*22 + 20, 10, 0, 2 * Math.PI);            
            for (count = 0;count < points.length; count++){
                if (points[count][0] === x && points[count][1] === y){
                    if(color !== ""){
                        color = "";                        
                    } else {
                        color = points[count][2];
                        break;
                    }
                    
                }
            }
            if(color === "Sample"){
                ctx.fillStyle = 'blue'; 
            }else if(color === "Standard"){
                ctx.fillStyle = 'red'; 
            } else if(color === "QC"){
                ctx.fillStyle = 'yellow'; 
            } else {
                ctx.fillStyle = 'white'; 
            }            
            ctx.fill();
        }
    }
    alert("Drawn");
}


