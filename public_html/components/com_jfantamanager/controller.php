<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT.'/helpers/fantacalcio.php';
/**
 * Hello World Component Controller
 */
class jFantaManagerController extends JController
{
    function display($cachable = false)
	{
		
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'all'));


		// call parent behavior
		parent::display($cachable);
	}
	
	function aSalva(){
		
		$data = JRequest::get('data');
		$squadra_id = $data->id;
		$modulo = $data->sc_formazione;
		$txt_formazione = $data->txt_formazione;
		$formazione =   explode(',',$txt_formazione);
		$numgiornata= jFantaManagerHelper::getGiornata();
					
		echo "squadra: $squadra_id <br>modulo: $modulo <br> giornata $numgiornata";
		print_r($formazione);
		exit;
		
	}

	function getStoriaCoppa(){
		
		$girone = JRequest::getVar('girone', 99);

		$model = $this->getModel('Scontri');
//		$items = $model->queryRooms($city, true, 3, $filters);

		$squadras = $model->getVotiSquadras();
 		$calendario = $model->getCalendario(0,$girone);
// 		getSquadrasVoti
		
		
		//for ($gior=0; $gior<count($calendario);$gior++){// as $gior => $cal){
		foreach($calendario as $gior => $calens){
		   echo "<table id=\"classifica\" class=\"greyrounded\" style=\"width:48%;\">
            		<thead>
                		<tr><th colspan=\"2\"><h2>giornata ".$gior."</h2></th></tr>
			</thead>
			<tbody>";
		   foreach($calens as $cal){	
                	echo "<tr> 
				<td class=\"colwide rgrey\">".
				$squadras[$cal->casa][1]->nome . "<br>".
				$squadras[$cal->trasferta][1]->nome . "
				</td><td class=\"rgrey\">".
				(0 + $squadras[$cal->casa][$cal->giornata]->punti) . "<br>".
				(0 + $squadras[$cal->trasferta][$cal->giornata]->punti) . "
				</td>
			</tr>";
		   }
		   echo "</tbody><tfoot>
			<tr><td colspan=\"2\">
				<a href=\"index.php?option=com_jfantamanager&view=all&lega=1\" class=\"btnright\">
					Dettagli ".$gior."ª giornata
				</a></td></tr>
	            </tfoot></table>";
		}
	}
}
