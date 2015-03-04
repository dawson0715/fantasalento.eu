<script language="javascript" type="text/javascript">
        <!--
        var dom = (document.getElementById) ? true : false;
        var ns5 = ((navigator.userAgent.indexOf("Gecko")>-1) && dom) ? true: false;
        var ie5 = ((navigator.userAgent.indexOf("MSIE")>-1) && dom) ? true : false;
        var ns4 = (document.layers && !dom) ? true : false;
        var ie4 = (document.all && !dom) ? true : false;
        var nodyn = (!ns5 && !ns4 && !ie4 && !ie5) ? true : false;

        var origWidth, origHeight;
        if (ns4) {
                origWidth = window.innerWidth; origHeight = window.innerHeight;
                window.onresize = function() { if (window.innerWidth != origWidth || window.innerHeight != origHeight) history.go(0); }
        }

        if (nodyn) { event = "nope" }

        var tipFollowMouse= true;

        var tipWidth= 110; //larghezza area del tooltip
        var offX= -20;	// distanza orizzontale dal mouse
        var offY= -312;  //distanza verticale dal mouse
        var tipFontFamily= "Verdana, arial, helvetica, sans-serif";
        var tipFontSize= "8pt";

        var tipFontColor= "#000000";
        var tipBgColor= "#c6c6c6";
        var tipBorderColor= "#ff0000";
        var tipBorderWidth= 2;
        var tipBorderStyle= "ridge";
        var tipPadding= 8;
        var messages = new Array();

        if (document.images) {
                var theImgs = new Array();
                for (var i=0; i<messages.length; i++) {
                theImgs[i] = new Image();
                        theImgs[i].src = messages[i][0];
          }
        }

        var startStr = '<table width="' + tipWidth + '"><tr><td align="center" width="40%"><img src="/images/com_jfantamanager/squadre/';
        var midStr = '.gif" height="35px" width="35px" border="0"></td><td>';
        var midStr_2 = '</td></tr><tr><td valign="top" colspan="2">';
        var endStr = '</td></tr></table>';
        
        function mostra()
        {
            if (document.getElementById("probabili").style.display=='none')
                document.getElementById("probabili").style.display='block'
            else
                document.getElementById("probabili").style.display='none'
        }
        -->
</script>
<table id="probabili" cellspacing="0px" cellpadding="0px" bgcolor="#ffffff" border="1" style="border-collapse: collapse; display: none;margin-left:3px; width:665px;padding-left: 0px">
    <tbody><tr>
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/atalanta/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Atalanta" src="/images/com_jfantamanager/squadre/atalanta.png"></a></td>
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/bologna/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Bologna" src="/images/com_jfantamanager/squadre/bologna.gif"></a></td>
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/cagliari/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Cagliari" src="/images/com_jfantamanager/squadre/cagliari.gif"></a></td>
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/catania/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Catania" src="/images/com_jfantamanager/squadre/catania.gif"></a></td>
            <td>                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/chievo/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">                    <img height="32" border="0" width="32" alt="Chievo" src="/images/com_jfantamanager/squadre/chievo.gif"></a></td>            <td>
            <td valign="top" style="border: 0pt solid rgb(255, 255, 255);" rowspan="6">
                <iframe scrolling="no" height="195" frameborder="0" align="right" width="483" border="0" src="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/atalanta/formazione/formazione.xml&allowScriptAccess=value=always" style="border: 0pt solid rgb(255, 255, 255);" src="/images/com_jfantamanager/squadre/probform2.swf" marginheight="1" marginwidth="1" name="I1">Il browser in uso non supporta frame non ancorati oppure è configurato in modo che i frame non ancorati non siano visualizzati.</iframe>
            </td>
        </tr><tr>
            
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/fiorentina/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Fiorentina" src="/images/com_jfantamanager/squadre/fiorentina.gif"></a></td>
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/genoa/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Genoa" src="/images/com_jfantamanager/squadre/genoa.gif"></a></td>
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/inter/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Inter" src="/images/com_jfantamanager/squadre/inter.gif"></a></td>
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/juventus/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Juventus" src="/images/com_jfantamanager/squadre/juventus.gif"></a></td>					<td>                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/lazio/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">                    <img height="32" border="0" width="32" alt="Lazio" src="/images/com_jfantamanager/squadre/lazio.gif"></a></td>
        </tr><tr></tr><tr>
            
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/livorno/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Livorno" src="/images/com_jfantamanager/squadre/livorno.gif"></a></td>
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/milan/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Milan" src="/images/com_jfantamanager/squadre/milan.gif"></a></td>
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/napoli/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Napoli" src="/images/com_jfantamanager/squadre/napoli.gif"></a></td>			<td>                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/parma/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">                    <img height="32" border="0" width="32" alt="Parma" src="/images/com_jfantamanager/squadre/parma.gif"></a></td>            <td>                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/roma/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">                    <img height="32" border="0" width="32" alt="Roma" src="/images/com_jfantamanager/squadre/roma.gif"></a></td>
            
        </tr><tr>
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/sampdoria/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="sampdoria" src="/images/com_jfantamanager/squadre/sampdoria.gif"></a></td>								<td>                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/sassuolo/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">                    <img height="32" border="0" width="32" alt="sassuolo" src="/images/com_jfantamanager/squadre/sassuolo.png"></a></td>			<td>                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/torino/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">                    <img height="32" border="0" width="32" alt="torino" src="/images/com_jfantamanager/squadre/torino.gif"></a></td>
            <td>
                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/udinese/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">
                    <img height="32" border="0" width="32" alt="Udinese" src="/images/com_jfantamanager/squadre/udinese.gif"></a></td>								<td>                <a href="http://www.gazzetta.it/ssi/swf/campetto_oriz.swf?xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/verona/formazione/formazione.xml&amp;allowScriptAccess=value=always" target="I1">                    <img height="32" border="0" width="32" alt="verona" src="/images/com_jfantamanager/squadre/verona.png"></a></td>
        </tr>
        <tr><td colspan="5">
                <font size="1" face="Arial" color="#333333">&nbsp;Clicca sul logo per vedere la probabile formazione.</font>
            </td></tr>
    </tbody></table>