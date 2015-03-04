
function cambia(posizione)
{
    document.getElementById('porta').style.display="none"
    document.getElementById('difesa').style.display="none"
    document.getElementById('centro').style.display="none"
    document.getElementById('attacco').style.display="none"
    document.getElementById(posizione).style.display=""
}

function filter(sender, indice, dove){
    var txt = sender.value.toLowerCase(),
    rows = document.getElementById(dove).tBodies[0].rows,
    ln = rows.length;
    if ( txt!="" ){
        for(i=1;i<ln;i++)
        {
            rows[i].style.display =
            (rows[i].cells[indice].firstChild.nodeValue.toLowerCase().indexOf(txt)!= 0)?"none":"";

        }
    }else
        for(i=0;i<ln;i++)
            rows[i].style.display = "";
}