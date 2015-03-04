<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class jFantaManagerViewConsegna extends JView
{
        // Overwriting JView display method
        function display($tpl = null)
	{
                $user = &JFactory::getUser();
                $aid = max ($user->getAuthorisedViewLevels()) == 2;
                $ora = date("H:i",strtotime("+30 minutes"));
                $data_fine = date('Y-m-d', mktime(0,0,0,date(m),date(d)-1,date(Y)));
                $data = date('Y-m-d');
                //Check permission
                $this->permessi = jFantaManagerHelper::getPermessi();
                $this->parametri = jFantaManagerHelper::getParameters(1);
                
                if($user->id<=0)
                     $this->msg="COM_FANTACALCIO_PERMESSI_USER";
                else if ($this->permessi['permesso']==0)
                    $this->msg="COM_FANTACALCIO_PERMESSI_PERMESSO";
                else if ($data > date($this->permessi['data']) && $aid)
                {
                    $this->msg="COM_FANTACALCIO_PERMESSI_DATA";
                    $this->scaduto='0';
                    $this->consegnate=jFantaManagerHelper::getConsegnateList();
                }
                else if((date($data) == date($this->permessi['data'])) && (date($ora) > date($this->permessi['ora'])) && $aid)
                {
                    $this->msg="COM_FANTACALCIO_PERMESSI_ORA";//.date($this->permessi['cal_data']) . " ALLE ORE: " . date($this->permessi['cal_ora']) . "</span>";
                    $this->scaduto='1';
                    $this->consegnate=jFantaManagerHelper::getConsegnateList();
                }
                if($this->msg == '')
                {   //3-4-3, 3-5-2. 4-5-1. 4-4-2. 4-3-3, 5-4-1, 5-3-2                  
                    if($_POST['txt_formazione']!="")
                    {
                        $this->salvato = jFantaManagerModelConsegna::salva();
                    }
                    //CARICO LE VECCHIE IMPOSTAZIONI E DATI FORMAZIONE
                    
                    $moduli = Array (Array (1,3,4,3), Array (1,3,5,2), Array (1,4,5,1), Array (1,4,4,2), Array (1,4,3,3), Array (1,5,4,1), Array (1,5,3,2));
                    foreach ($moduli as $modulo)
                        $js_moduli.="new Array ($modulo[0],$modulo[1],$modulo[2],$modulo[3]),";
                    $js_moduli =substr($js_moduli,0,-1);
                    $this->js_moduli=$js_moduli;
                    $index=$this->get('OldModulo');
                    $options=$this->get('Options');
                    
                    
                    if($this->permessi['inserita'] > 0 || ($_POST['txt_formazione']!=""))
                    {   
                        $vecchia=$this->get('Old');
                        foreach ($vecchia as $i => $singolo)
                        {
                            $this->lista.=$singolo->giocatore_id.",";
                            $old_team[]="<img src='/images/com_jfantamanager/giocatori/t_". strtolower($singolo->squadra) .".png' width='75' alt='". strtoupper($singolo->squadra) ."'><br><span>". strtoupper($singolo->nome) ."</span>";
                        }
                        $this->lista=substr($this->lista, 0, -1);
                        $this->old_team=$old_team;
                        $this->old_index=$index;
                        $this->old_modulo=$moduli[$index];
                    }
                    $squadra=$this->get('Squadra');
                    $dati=$this->get('DatiSquadra');
                }
                    
                // Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
                
                $this->squadra=$squadra;
                $this->dati=$dati;
                $this->vecchia=$vecchia;
                $this->options=$options;
                
                $this->root=JURI::root();
                //include css file
                $document = &JFactory::getDocument();
                $document->addStyleSheet('components'.DS.'com_jfantamanager'.DS.'helpers'.DS.'consegna.css');
                $document->addScriptDeclaration('components'.DS.'com_jfantamanager'.DS.'helpers'.DS.'consegna.js');
		// Display the view
		parent::display($tpl);
	}
}

?>