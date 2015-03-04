<?php defined('_JEXEC') or die('Restricted access');?>
<?
//print_r($this);
$form = array('3 - 4 - 3','3 - 5 - 2','4 - 5 - 1','4 - 4 - 2','4 - 3 - 3','5 - 4 - 1','5 - 3 - 2');
?>
<h2 class="item-page-title">Le squadre</h2>
<hr width="100">
<?if($this->user>0):?>
    <a id="data" class="modal" href="/index.php?option=com_users&view=profile&layout=modal&tmpl=component" rel="{handler: 'iframe', size: {x: 300, y: 300}}">
        <span class="hasTip" title="tip title::tip text">Modifica dati log-in</span>
    </a>
<? endif; ?>
<table border="0" cellpadding="0" cellspacing="0" class="profile">
<!--    <thead><tr style="height: 25px"><th colspan='2'><b>TUO PROFILO</b></th></tr></thead>-->
    <? foreach ($this->squadra as $conta => $squadra):?>
    <tr><td style="width:400px"><h2>DATI <?=$conta+1?>° SQUADRA</h2></td><td style="width: 260px;"><h2>VOTI</h2></td></tr>
    <tr>
        <td class="dati">
            <ul>
                <li>
<!--                    <a href="'index.php?option=com_jfantamanager&view=profile&layout=edit&id=1">-->
                        <?php echo JText::_($squadra->nome); ?>
<!--                    </a>-->
                </li>
                <li>
                    <label>logo: </label><img src="/<?=$squadra->logo?>" align="texttop" width="100" height="100"> </li>
            </ul>
            <div class="elem" style="margin-bottom:2px">
                <h3>Gestione</h3>
                <div class="text" style="border-right: 2px solid rgb(255, 255, 255)">Bilancio</div>
                <div class="text" style="border-right: 2px solid rgb(255, 255, 255)">Cambi</div>
                <div class="text">Da pagare</div>
                <div class="init"><?=$squadra->bilancio?></div>
                <div class="green"><?=$squadra->cambi?></div>
                <div class="red"><?=$squadra->pagato?></div>
            </div>
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
                                                enabled: false,
						formatter: function() {
				                return '<b>'+ this.series.name +'</b><br/>' +
								'Giornata '+this.x +' in '+ (9-this.y) +'posizione';
						}
					},
					legend: {enabled: false},
                                        title: {text: null},
					series: [{
						name: '<?=$squadra->nome?>',
						data: [<?=$squadra->grafico_posizioni?>]
					}]
				});
				
				
			});
                        $(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container2',
						marginRight: 25,
						marginBottom: 25
					},
                                        plotOptions: {
                                             line: {
                                                dataLabels: {
                                                   enabled: true
                                                },
                                                enableMouseTracking: true
                                            },
                                            spline: {
                                                dataLabels: {
                                                   enabled: false
                                                },
                                                marker: {enabled: false},
                                                enableMouseTracking: false
                                            }
                                        },
                                        xAxis: {
                                            categories: [],
                                            min: 1
					},
					yAxis: {
                                            title: {text: 'Punti'},
                                            min: 40,
                                            plotBands: [{ // Light air
                                                from: 60.5,
                                                to: 65,
                                                color: 'rgba(68, 170, 213, 0.1)'
                                             },
                                            { // Light air
                                                from: 70.5,
                                                to: 75,
                                                color: 'rgba(68, 170, 213, 0.1)'
                                             },
                                            { // Light air
                                                from: 80.5,
                                                to: 85,
                                                color: 'rgba(68, 170, 213, 0.1)'
                                             },
                                            { // Light air
                                                from: 90.5,
                                                to: 95,
                                                color: 'rgba(68, 170, 213, 0.1)'
                                             },]
					},
					tooltip: {
                                                enabled: false,
						formatter: function() {
				                return '<b>'+ this.series.name +'</b><br/>'+
								'Giornata '+this.x +' in '+ (9-this.y) +'posizione';
						}
					},
					legend: {enabled: false},
                                        title: {text: null},
					series: [{
                                                type: 'line',
						name: '<?=$squadra->nome?>',
						data: [<?=$squadra->grafico_punti['punti']?>]
                                                } , {
                                                type: 'spline',
                                                name: 'media',
						data: [<?=$squadra->grafico_punti['media']?>]
					}]
				});
				
				
			});
		</script>
            <div class="elem" style="margin-bottom:2px">
                <h3>Punti</h3>
                <div id="container2" style="width: 400px; height: 200px; margin: 0 auto"></div>
            </div>
            <div class="elem" style="margin-bottom:2px">
                <h3>Posizione</h3>
                <div id="container" style="width: 400px; height: 200px; margin: 0 auto"></div>
            </div>
        </td>
        <td>
            <div class="elem_dx" >
                <table style="font-weight: bold;">
                    <thead>
                        <tr>
                            <th>G.</th><th>Pos</th><th>Punti</th><th>Tot.</th><th>Goal</th><th>Modulo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach($squadra->partecipa as $i => $row)
                        {
                            $somma+=$row->punti;
                            if ($row->punti>0)
                                echo "<tr class='riga".($i % 2)."'><td>$row->giornata</td><td class='violet'>$row->posizione</td><td>$row->punti</td><td>$somma</td><td class='rosso'>".(($row->punti<60)?0:floor(($row->punti - 55.5)/5))."</td><td>".$form[$row->modulo]."</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="lista">
            <h2 style="float: none;width: 670px;margin-bottom: 5px">STATISTICHE</h2>
            <dl class="legenda-2">
                <dt>Legenda</dt>
                <dd>
                    <strong>P</strong> = Partite Giocate</dd>
                <dd>
                    <strong>M</strong> = Media Voto</dd>
                <dd>
                    <strong>F</strong> = Fanta Media</dd>
                <dd>
                    <strong>Gs</strong> = Gol Subit</dd>
                <dd>
                    <strong>G</strong> = Gol Segnato</dd>
                <dd>
                    <strong>Rs</strong> = Rigore Sbagliato</dd>
                <dd>
                    <strong>Rp</strong> = Rigore Parato</dd>
                <dd>
                    <strong>As</strong> = Assist</dd>
                <dd>
                    <strong>A</strong> = Ammonizione</dd>
                <dd>
                    <strong>E</strong> = Espulsione</dd>
            </dl>
            <table class="statis">
                <tr><th colspan='3'>PORTIERI</th><th>P</th><th>M</th><th>FM</th><th>Gs</th><th>Rp</th><th>As</th><th>A</th><th>E</th></tr>
                <?php 
                $chg="P";
                foreach($squadra->lista as $i => $row)
                {
                    if($chg != $row->pos)
                    {
                        echo "<tr><th colspan='3'>".cmp($row->pos)."</th><th>P</th><th>M</th><th>FM</th><th>G</th><th>Rs</th><th>As</th><th>A</th><th>E</th></tr>";
                        $chg=$row->pos;
                    }
                    echo "<tr class='riga".($i % 2)."'>
                            <td>$row->valore_acq €</td>
                            <td class='squadra_nome'>$row->nome</td>
                            <td class='squadra'>$row->squadra</td>
                            <td class='N'>".SP($row->P)."</td>
                            <td class='N'>".round($row->V/$row->P,2)."</td>
                            <td class='N'>".round($row->T/$row->P,2)."</td>
                            <td ".(($row->pos=='P')?"class='Gs'>".SP($row->Gs):"class='G'>".SP($row->G))."</td>
                            <td ".(($row->pos=='P')?"class='Rp'>".SP($row->Rp):"class='Rs'>".SP($row->Rs))."</td>
                            <td class='As'>".SP($row->Ass)."</td>
                            <td class='A'>".SP($row->A)."</td>
                            <td class='E'>".SP($row->E)."</td>                            
                          </tr>";
                }
                ?>
            </table>
            
        </td> 
    </tr>
    <? endforeach;?>
</table>
<?
function SP($n)
{
    if($n > 0)
        return $n;
    else 
        return "-";
}
function cmp($P)
{
    if ($P=="D")
        return "DIFENSORI";
    if ($P=="C")
        return "CENTROCAMPISTI";
    if ($P=="A")
        return "ATTACCANTI";
}
//print_r($this);
?>