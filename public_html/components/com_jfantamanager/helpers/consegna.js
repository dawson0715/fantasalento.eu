function scrivi(id,pos,nome,squ)
{
    if(modulo_scelto=='')
    {
        alert("Devi selezionare prima un modulo")
        return
    }
    nome=nome.toUpperCase()
    switch (pos)
    {
        case 'P':
        {
            indice=0;
            inizio=0;
            break;
        }
        case 'D':
        {
            indice=1;
            inizio=1;
            break;
        }
        case 'C':
        {
            indice=2;
            inizio=1+modulo_scelto[1];
            break;
        }
        case 'A':
        {
            indice=3;
            inizio=1+modulo_scelto[1]+modulo_scelto[2];
            break;
        }              
    }
    cosa="<img src='/images/com_jfantamanager/giocatori/t_"+squ.toLowerCase()+".png' width='75' alt='"+squ+"'><br><span>"+nome+"</span>"
    rimuovi = formazione.indexOf(id, 0)
    if (rimuovi >= 0 )
    {//RIMUOVI
        if (rimuovi >= 11)
        {
            if(panchina)
                rimuovi_panchina_fissa(id,rimuovi,indice)
            else
                rimuovi_panchina_libera(id,rimuovi)
        }
        else
        {
            fine = modulo_scelto[indice]+inizio-1
            //alert(inizio +" - rimuovi:" + rimuovi + "fine:"+fine)
            for(i=rimuovi;i<fine;i++)
                formazione[i]=formazione[i+1]
            formazione[fine]=null
            document.getElementById("list_"+id).style.textDecoration="none"
            document.getElementById("list_"+id).style.color="black"
            if (indice == 0)
                document.getElementById("portiere").innerHTML = ""
            else
                //alert(inizio +" - rimuovi:"+rimuovi)
                document.getElementById(draw_in[indice]).deleteCell(rimuovi-inizio)
        }
    }
    else
    {//INSERISCI IN CAMPO
        index=cerca(indice,inizio)
        //alert("indice:" +indice+"index:"+index+"inizio:"+inizio)
        if(index >= 0)
        {
            //alert(index-inizio)
            formazione[index]=id
            document.getElementById("list_"+id).style.textDecoration="line-through"
            document.getElementById("list_"+id).style.color="green"
            if (indice == 0)
                document.getElementById("portiere").innerHTML = cosa
            else
                document.getElementById(draw_in[indice]).insertCell(index-inizio).innerHTML = cosa 
        }
        else
        {
        //INSERISCI IN PANCHINA  
            if(panchina)
                panchina_fissa(id,cosa,indice)
            else
                panchina_libera(id,cosa)
        }
    }   
//    alert(formazione)
}

function panchina_fissa(id, cosa,indice)
{
    if (indice==0)
    {
        if(formazione[11]==null)
        {
            document.getElementById("panchina0").innerHTML = cosa
            formazione[11]=id
            document.getElementById("list_"+id).style.textDecoration="line-through"
            document.getElementById("list_"+id).style.color="green"
        }
    }
    else
        if(formazione[11+indice]==null)
        {
            document.getElementById("panchina"+indice).innerHTML = cosa
            formazione[11+indice]=id
            document.getElementById("list_"+id).style.textDecoration="line-through"
            document.getElementById("list_"+id).style.color="green"
        }else if(formazione[14+indice]==null)
        {
            document.getElementById("panchina"+(3+indice)).innerHTML = cosa
            formazione[14+indice]=id
            document.getElementById("list_"+id).style.textDecoration="line-through"
            document.getElementById("list_"+id).style.color="green"
        }

    //alert("panchina fissa")
    return
}

function panchina_libera(id,cosa)
{
    var i=0
    var offset=11
    while((i < 7) && (formazione[offset+i]!=null))
    {
        i++
    }
    if (i < 7)
    {
        formazione[offset+i]=id
        document.getElementById("list_"+id).style.textDecoration="line-through"
        document.getElementById("list_"+id).style.color="green"
        document.getElementById("panchina"+i).innerHTML = cosa
        //alert("posizione" + (offset+i))
    }
    //alert("panchin libera")
    return
}

function rimuovi_panchina_fissa(id, rimuovi, indice)
{
    if (indice==0)
    {
        document.getElementById("panchina0").innerHTML = ""
        formazione[11]=null 
        document.getElementById("list_"+id).style.textDecoration="none"
        document.getElementById("list_"+id).style.color="black"
    }else    
    {
        if(rimuovi<14)
        {
            document.getElementById("panchina"+indice).innerHTML = document.getElementById("panchina"+(3+indice)).innerHTML
            formazione[11+indice]=formazione[14+indice]
        }
        document.getElementById("panchina"+(3+indice)).innerHTML = ""
        formazione[14+indice]=null
        document.getElementById("list_"+id).style.textDecoration="none"
        document.getElementById("list_"+id).style.color="black"
    }
}

function rimuovi_panchina_libera(id, rimuovi)
{
    //alert(id)
    for(i=rimuovi;i<17;i++)
    {    
        formazione[i]=formazione[i+1]
        document.getElementById("panchina"+(i-11)).innerHTML = document.getElementById("panchina"+(i-10)).innerHTML
    }
    formazione[17]=null 
    document.getElementById("panchina6").innerHTML = ""
    document.getElementById("list_"+id).style.textDecoration="none"
    document.getElementById("list_"+id).style.color="black"
    
}
            
//cerca indice inserimento nella formazione
function cerca(indice, inizio)
{
    //    alert("indice: " + indice)
    var i=0
    while((i < modulo_scelto[indice]) && (formazione[inizio+i]!=null))
    {
        i++
    }
    if (i == modulo_scelto[indice])
        return -1
    else
        return (inizio+i)
}

function  inviaform()
{
    for(i=0;i<=17;i++)
        if (formazione[i]==null || formazione[i]==0)
        {
            alert("Formazione incompleta")
            return false
        }
    //alert(" "+ vett_POS + "\n"+vett_ID)
    document.forms["f1"].txt_formazione.value=formazione.join(',')
    
    if(confirm("Sei sicuro della rosa che hai scelto?"))
        return true
    else
        return false
}
function resetta()
{
    document.getElementById("portiere").innerHTML=""
    var difesa = document.getElementById("difesa")
    while (difesa.hasChildNodes())
        difesa.removeChild(difesa.firstChild)
    var centro = document.getElementById("centro")
    while (centro.hasChildNodes())
        centro.removeChild(centro.firstChild)
    var attacco = document.getElementById("attacco")
    while (attacco.hasChildNodes())
        attacco.removeChild(attacco.firstChild)
    for(i=0;i<=17;i++)
    {   
        if(formazione[i]!= null)
        {
            document.getElementById("list_"+formazione[i]).style.textDecoration="none"
            document.getElementById("list_"+formazione[i]).style.color="black"
            formazione[i] = null
        }
    }
    for(i=0;i<7;i++)
        document.getElementById("panchina"+i).innerHTML=""
    modulo_scelto=''
    document.getElementById('mod_active').style.display="none"
}

function show_mod(element)
{
    resetta()
    if (modificatore)
        if(vet_mod[element-1][1]>=4)
            document.getElementById('mod_active').style.display="block"
        else
            document.getElementById('mod_active').style.display="none"
    modulo_scelto=vet_mod[element-1]
}