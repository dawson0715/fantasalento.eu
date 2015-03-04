<?php defined('_JEXEC') or die('Restricted access');?>
<h2 class="item-page-title"><img align="middle" src="<?=$this->root?>/components/com_jfantamanager/images/soccer_3_32.png">Classifica</h2>
<!--<hr width="100">-->
<?
//print_r($this);
?>
<table width="100%" style="line-height: 100%;">
    <tr style="vertical-align: top">
        <td width="65%">
            <table width="50%" class="visualizza" border="0" cellpadding="0" cellspacing="0">
                <thead><tr style="height: 25px"><th colspan='4' style="vertical-align: middle"><b>SQUADRE PARTECIPANTI</b></th></tr></thead>
                <?php
                $i = 0;
                foreach($this->items as $row)
                {
                    $row->punti = ($row->punti=='')?'0.0':$row->punti;
                    $i++;
                    echo (($i % 2) == 1)?"<tr>":"";
                    $classe= ($classe=="") ? "azzurro" : "";
                    $tabella.="<tr class='$classe'><td>$i</td><td class='centro'><a href='index.php?option=com_jfantamanager&view=profile&id=$row->id'>$row->nome</a><br><span class='nick'>$row->username</span></td><td class='c1z'>$row->punti</td></tr>";
                    echo "<td>
                            <a href='index.php?option=com_jfantamanager&view=profile&id=$row->id'>
                                <img src='/$row->logo' class='squadra_logo'><br>
                                <span class='squadra_nome'>$row->nome</span>
                            </a>
                           <div id='Punti'>Punti: <b>$row->punti</b><br><span class='mini'>".(($this->items[0]->punti - $row->punti>0)?($this->items[0]->punti - $row->punti)." dal primo":"")."</span></div>
                         </td>";
                    echo (($i % 2) == 0)?"</tr>":"";
                }
                ?>
            </table>
        </td>
        <td>
            <table cellspacing="1" id="claz">
                <thead>
                    <tr >
                        <th style="vertical-align: middle">#</th>
                        <th style="vertical-align: middle">Nome Squadra</th>
                        <th style="vertical-align: middle">Punti</th>
                    </tr>
                </thead>
                <tbody>
                    <?=$tabella?>
                </tbody>
            </table>
            <div id="punteggio" style="width: 250px; height: 450px; margin: 0 auto"></div>
        </td>
    </tr>
</table>

<?

?>
<style type="text/css">
.cTitle {
    background: url("/images/h2_blu.png") no-repeat scroll right top transparent;
    color: #FFFFFF;
    font-size: 20px;
    height: 29px;
    padding: 4px 0;
    text-indent: 9px;
    width: 670px;
    margin-top: 15px;
}
    
</style>
<h2 class="cTitle">Statistiche squadra</h2>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript" src="<?=$this->root?>components/com_jfantamanager/views/profile/helpers/highcharts.js"></script>
<script type="text/javascript">
    var chart;
    $(document).ready(function() {
            chart = new Highcharts.Chart({
                    chart: {
                            renderTo: 'container',
                            defaultSeriesType: 'line',
                            marginRight: 25,
                            marginBottom: 25
                    },
                    title: {text: null},
                    xAxis: {
                        categories: [],
                        min: 1
                    },
                    yAxis: {
                        title: {text: 'Posizione'},
                        categories: [' ','8','7','6','5','4','3','2','1',' '],
                        min: 0,
                        max: 9
                    },
                    tooltip: {
                            formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                                            'Giornata '+this.x +' in '+ (9-this.y) +' posizione';
                            }
                    },
                    legend: {enabled: false},
                    series: [<?=$this->chart[0]?>]
            });
    });

    $(document).ready(function() {
            chart = new Highcharts.Chart({
                    chart: {
                            renderTo: 'punteggio',
                            defaultSeriesType: 'column',
                            marginRight: 25,
                            marginBottom: 25
                    },
                    title: {text: null},
                    xAxis: {
                        categories: []
                    },
                    yAxis: {
                        title: {text: 'Posizione'},
                        min: <?=$this->items[count($this->items)-1]->punti?>
                    },
                    tooltip: {
                            formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                                            this.y +' punti';
                            }
                    },
                    legend: {enabled: false},
                    series: [<?=$this->chart[1]?>]
            });
    });
</script>

<div id="container" style="width: 670px; height: 275px; margin: 0 auto"></div>