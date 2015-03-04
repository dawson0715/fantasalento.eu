var rosa=new Array(25)
var valore=0;
var conta=0;
function inserisci(id,nome,pos,valore_att)
{
    if (conta>25)
        return
    rimuovi = rosa.indexOf(id, 0)
    if (rimuovi>=0)
        return
    if(resto-valore_att<0)
    {
       alert("Non hai abbastanza soldi per comprare questo giocatore") 
       return
    }    
    switch (pos)
    {
        case 'P':
            indice=cerca(0,3)
            break;
        case 'D':
            indice=cerca(3,8)
            break;
        case 'C':
            indice=cerca(11,8)
            break;
        case 'A':
            indice=cerca(19,6)
            break;
    }
//    alert(indice)
    if (indice>=0)
    {
        cosa=nome+"<img src=\"/components/com_jfantamanager/images/del.png\" onclick=\"elimina("+id+","+valore_att+")\" /><br><span>"+valore_att+"€</span>"
        document.getElementById('p'+(indice+1)).innerHTML=cosa
        rosa[indice]=id
        valore+=valore_att;
        resto-=valore_att;
        conta++;
        document.getElementById('resto').innerHTML="€" + resto
        document.getElementById('valore').innerHTML="€" + valore
        document.getElementById('conta').innerHTML=conta
    }
}

function cerca(inizio,offset)
{
    //    alert("indice: " + indice)
    var i=inizio
    while((i < inizio+offset) && (rosa[i]!=null))
        i++
    if (i == (inizio+offset))
        return -1
    else
        return (i)
}

function elimina(id,valore_att)
{
//    alert(document.forms['squadraForm'].p[1].innerHTML)
    rimuovi = rosa.indexOf(id, 0)
    if (rimuovi<0)
        return
    rosa[rimuovi]=null
    document.getElementById('p'+(rimuovi+1)).innerHTML=""
    valore-=valore_att;
    resto+=valore_att;
    conta--;
    document.getElementById('resto').innerHTML="€" + resto
    document.getElementById('valore').innerHTML="€" + valore
    document.getElementById('conta').innerHTML=conta
    //alert(document.getElementById('p1').innerHTML)
}
function cambia(posizione)
{
    document.getElementById('porta').style.display="none"
    document.getElementById('difesa').style.display="none"
    document.getElementById('centro').style.display="none"
    document.getElementById('attacco').style.display="none"
    document.getElementById(posizione).style.display="block"
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

function resetta()
{
    for(i=0;i<25;i++)
    {
        rosa[i]=null
        document.getElementById('p'+(i+1)).innerHTML=""
    }
    resto=back
    valore=0
    conta=0
    document.getElementById('resto').innerHTML="€" + resto
    document.getElementById('valore').innerHTML="€" + valore
    document.getElementById('conta').innerHTML=conta
}

function casuale()
{
    alert("caso")
}

function validate()
{
    if(document.forms.squadraForm.nome.value=="")
    {
        alert("NOME")
        return false
    }
    if(conta!=25)
    {
        alert("CONTA")
        return false
    }
//    alert(document.forms['squadraForm'].rosa.value)
    document.forms['squadraForm'].rosa.value=rosa.join(',')
    document.forms['squadraForm'].resto.value=resto
    return true
}