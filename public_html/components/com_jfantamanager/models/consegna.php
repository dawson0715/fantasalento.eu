<?php 
/**
 * Hello Model for Hello World Component
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license    GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class jFantaManagerModelConsegna extends JModel
{
	protected $formazione;
        /**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */

        function getDatiSquadra()
        {
            $user = &JFactory::getUser();
            $db =& JFactory::getDBO();

            $query ="SELECT nome,logo,pagato FROM #__fanta_squadra WHERE created_by = $user->id";
            $db->setQuery( $query );
            $datisquadra = $db->loadAssoc();
            return $datisquadra;
        }

        function getSquadra()
        {
            $user = &JFactory::getUser();
            $db =& JFactory::getDBO();
            $data = date('Y-m-d');

            $query ="SELECT #__fanta_giocatore.id,#__fanta_giocatore.nome,pos,squadra FROM #__fanta_squadra, #__fanta_possiede, #__fanta_giocatore WHERE #__fanta_squadra.created_by = $user->id AND #__fanta_possiede.squadra_id = #__fanta_squadra.id AND #__fanta_possiede.giocatore_id = #__fanta_giocatore.id AND data_ces < $data ORDER BY pos DESC,nome ASC";
            $db->setQuery( $query );
            $datisquadra = $db->loadObjectList();
            return $datisquadra;
        }
        
        function getOld()
        {
            $user       = &JFactory::getUser();
            $db         =& JFactory::getDBO();
            $giornata   = jFantaManagerHelper::getGiornata();
            $squadra_id = jFantaManagerHelper::getIdSquadra();
            
            $query ="SELECT giocatore_id,nome,squadra FROM `#__fanta_impiega`
                        LEFT JOIN #__fanta_giocatore ON (#__fanta_impiega.giocatore_id = #__fanta_giocatore.id)
                        WHERE `squadra_id`= $squadra_id 
                        AND `giornata` = $giornata
                        ORDER BY riserva ASC, pos DESC";
            $db->setQuery( $query );
            $oldsquadra = $db->loadObjectList();
            return $oldsquadra;
        }
        
        function getOldModulo()
        {
            $db         =& JFactory::getDBO();
            $squadra_id = jFantaManagerHelper::getIdSquadra();
            $giornata   = jFantaManagerHelper::getGiornata();
            
            $query ="SELECT modulo
                        FROM #__fanta_voti_squadra
                        WHERE `squadra_id`= $squadra_id
                        AND `giornata` = $giornata";
            $db->setQuery( $query );
            $oldmodulo = $db->loadResult();
            return $oldmodulo;
        }
        
        function getOptions()
        {  
            $options	= array();//3-4-3, 3-5-2. 4-5-1. 4-4-2. 4-3-3, 5-4-1, 5-3-2
            $options[]	= JHtml::_('select.option', '', JText::_('Seleziona'));
            $options[]	= JHtml::_('select.option', '0', JText::_('3-4-3'));
            $options[]	= JHtml::_('select.option', '1', JText::_('3-5-2'));
            $options[]	= JHtml::_('select.option', '2', JText::_('4-5-1'));
            $options[]	= JHtml::_('select.option', '3', JText::_('4-4-2'));
            $options[]	= JHtml::_('select.option', '4', JText::_('4-3-3'));
            $options[]	= JHtml::_('select.option', '5', JText::_('5-4-1'));
            $options[]	= JHtml::_('select.option', '6', JText::_('5-3-2'));
            return $options;
        }
        function getSalvataggio()
        {   
            
//            $formazione = explode(',', $_POST['txt_formazione']);
//            for($i=0;$i<11;$i++)
//                $query.="()";
            //$lista = JRequest::getVar('formazione');
            //$lista = JRequest::getVar();
            return $_POST['txt_formazione'];
        }
        
        function salva()
        {
                $db         =& JFactory::getDBO();
                $squadra_id = jFantaManagerHelper::getIdSquadra();
                $numgiornata= jFantaManagerHelper::getGiornata();
				
				$db->setQuery("INSERT INTO jos_fanta_voti_squadra_backup (`giornata`,`squadra_id`, `punti`,`posizione`,`data`,`ora`,`modulo`,`puntidiretti`,`goal`,`goalsubiti`,`posizionediretti`,`v`,`p`,`n`,`device`)
				SELECT `giornata`,`squadra_id`,`punti`,`posizione`,`data`,`ora`,`modulo`,`puntidiretti`,`goal`, `goalsubiti`,`posizionediretti`,`v`,`p`,`n`,`device` FROM jos_fanta_voti_squadra
					WHERE squadra_id = $squadra_id 
					AND giornata = $numgiornata");
                $db->query();
				
                //AGGIORNO LA DATA DI CONSEGNA E IL MODULO
                $db->setQuery("DELETE FROM #__fanta_voti_squadra
                                WHERE squadra_id = $squadra_id 
                                AND giornata = $numgiornata
                                LIMIT 1");
                $db->query();
                $data       =   new stdClass();
                $data->squadra_id = $squadra_id;
                $data->giornata = $numgiornata;
                $data->data=date('Y-m-d');
                $data->ora=date('G:i');
                $data->modulo=$_POST['sc_formazione'];
                $db->insertObject('#__fanta_voti_squadra', $data, id);

                ////SALVA
                $formazione =   explode(',', $_POST['txt_formazione']);
                if (count($formazione)!=18)
                {
                    $this->msg="Errore formazione";
                    return;
                }
				
				$db->setQuery("INSERT INTO #__fanta_impiega_backup (squadra_id, giocatore_id, giornata, riserva)
								SELECT squadra_id, giocatore_id, giornata, riserva FROM `#__fanta_impiega` 
                	                WHERE squadra_id = $squadra_id 
                    	            AND giornata = $numgiornata");
                $db->query();
                $db->setQuery("DELETE FROM `#__fanta_impiega` 
                                WHERE squadra_id = $squadra_id 
                                AND giornata = $numgiornata");
                $db->query();
                $data       =   new stdClass();
                if($this->parametri->p_fissa)
                {//fissa
                    for($i=0;$i<11;$i++)
                    {
                        $data->squadra_id = $squadra_id;
                        $data->giornata = $numgiornata;
                        $data->riserva = '0';
                        $data->giocatore_id = $formazione[$i];
                        $db->insertObject('#__fanta_impiega', $data, id);
                    }
                    $data->squadra_id = $squadra_id;
                    $data->giornata = $numgiornata;
                    $data->giocatore_id = $formazione[11];
                    $data->riserva = '1';
                    $db->insertObject('#__fanta_impiega', $data, id);
                    for($i=12;$i<18;$i++)
                    {
                        $data->squadra_id = $squadra_id;
                        $data->giornata = $numgiornata;
                        $data->giocatore_id = $formazione[$i];
                        $data->riserva = (($i % 2) == 0)?"1":"2";
                        $db->insertObject('#__fanta_impiega', $data, id);
                    }
               }
               else
               {//libera
                    for($i=0;$i<18;$i++)
                    {
                        $data->squadra_id = $squadra_id;
                        $data->giornata = $numgiornata;
                        $data->giocatore_id = $formazione[$i];
                        $data->riserva = ($i<11)?"0":$i-10;
                        $db->insertObject('#__fanta_impiega', $data, id);
                   }
               }
               sleep(1);
               return true;
        }
		
		function aSalva($squadra_id, $modulo, $formazione, $numgiornata){
			
//			sc_formazione:3
//			txt_formazione:241,458,409,11,495,161,470,820,314,398,209,296,191,280,292,286,453,50
//			id:1

			$db = JFactory::getDBO();
			
			$db->setQuery("INSERT INTO jos_fanta_voti_squadra_backup (`giornata`,`squadra_id`, `punti`,`posizione`,`data`,`ora`,`modulo`,`puntidiretti`,`goal`,`goalsubiti`,`posizionediretti`,`v`,`p`,`n`,`device`)
			SELECT `giornata`,`squadra_id`,`punti`,`posizione`,`data`,`ora`,`modulo`,`puntidiretti`,`goal`, `goalsubiti`,`posizionediretti`,`v`,`p`,`n`,`device` FROM jos_fanta_voti_squadra
				WHERE squadra_id = $squadra_id 
				AND giornata = $numgiornata");
			$db->query();

			//AGGIORNO LA DATA DI CONSEGNA E IL MODULO
			$db->setQuery("DELETE FROM #__fanta_voti_squadra
							WHERE squadra_id = $squadra_id 
							AND giornata = $numgiornata
							LIMIT 1");

			$db->query();
			$data       =   new stdClass();
			$data->squadra_id = $squadra_id;
			$data->giornata = $numgiornata;
			$data->data=date('Y-m-d');
			$data->ora=date('G:i');
			$data->modulo = $modulo;
			$db->insertObject('#__fanta_voti_squadra', $data, id);

			////SALVA
			if (count($formazione)!=18)
			{
				$this->msg="Errore formazione";
				return;
			}
			
			$db->setQuery("INSERT INTO #__fanta_impiega_backup (squadra_id, giocatore_id, giornata, riserva, device)
							SELECT squadra_id, giocatore_id, giornata, riserva, device FROM `#__fanta_impiega` 
								WHERE squadra_id = $squadra_id 
								AND giornata = $numgiornata");
			$db->query();
			$db->setQuery("DELETE FROM `#__fanta_impiega` 
							WHERE squadra_id = $squadra_id 
							AND giornata = $numgiornata");
			$db->query();
			$data       =   new stdClass();
			for($i=0;$i<18;$i++)
			{
				$data->squadra_id = $squadra_id;
				$data->giornata = $numgiornata;
				$data->giocatore_id = $formazione[$i];
				$data->device = 1;
				$data->riserva = ($i<11)?"0":$i-10;
				$db->insertObject('#__fanta_impiega', $data, id);
		   }
		   sleep(1);
		   return true;
		}
}