<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HTML View class for the jFantaManager Component
 */
class jFantaManagerViewAll extends JViewLegacy
{
	var $options;
	
	// Overwriting JViewLegacy display method
	function display($tpl = null)
	{
		$giornata=JRequest::getVar('giornata', 1);
        $last=$this->get('Giornata');
//                if($last>1)
//                    $last--;

        if($giornata<1 || $giornata>38 || $giornata=='')
        	$giornata=$last;
		                
        $this->ufficiale = jFantaManagerModelAll::Ufficiale($giornata);
        $this->giornata = $giornata;
        $this->carico = $giornata==$last;
                
        $options = array();
        for($i=1;$i<=$last;$i++)
        	$options[] = JHtml::_('select.option', $i, $i);
                
		$this->options=$options;

		$lista = null;

		// Assign data to the view
        $squadre=$this->get('Squadre');
        foreach ($squadre as $i=> $squadra){
	        $lista[$i] = jFantaManagerModelAll::getGiocatoriMobile($squadra->id,$giornata,3,1);
	        //$lista[$i] = jFantaManagerModelLega::CalcolaMobile($squadra->id,$giornata,3,1);
	        if($lista[$i]=="")
	        $lista[$i]="FORMAZIONE NON CONSEGNATA";
        }
                
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->squadre  =$squadre;
		$this->giocatori=$lista;
		$this->root=JURI::root();
		// Display the view
		
		$document = &JFactory::getDocument();
		if (JRequest::getVar('tmpl', '') == 'component')
			$document->addStyleSheet('components'.DIRECTORY_SEPARATOR.'com_jfantamanager'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'visualizza_mobile.css');
		else
			$document->addStyleSheet('components'.DIRECTORY_SEPARATOR.'com_jfantamanager'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'visualizza.css');
		parent::display($tpl);
	}
}
