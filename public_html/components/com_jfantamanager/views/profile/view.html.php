<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class jFantaManagerViewProfile extends JView
{
	// Overwriting JView display method
	function display($tpl = null)
	{
                JHTML::_('behavior.modal');
		// Assign data to the view
                $squadra = $this->get('Squadra');
                $user = &JFactory::getUser();
//		$this->lista = $this->get('ListaGiocatori');
                foreach($squadra as $single_squadra)
                {
                    $single_squadra->lista = jFantaManagerModelProfile::getListaGiocatori($single_squadra->id);
                    $single_squadra->partecipa= jFantaManagerModelProfile::getListaPartecipa($single_squadra->id);
                    $single_squadra->grafico_punti = jFantaManagerModelProfile::getGraficoPunti($single_squadra->id);
                    $single_squadra->grafico_posizioni = jFantaManagerModelProfile::getGraficoPartecipa($single_squadra->id);
                }
                 
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
                $this->user         = $user->id;
                $this->squadra      = $squadra;
                
		$this->root=JURI::root();
		// Display the view
                
                $document = &JFactory::getDocument();
		if (JRequest::getVar('tmpl', '') == 'component')
			$document->addStyleSheet('components'.DS.'com_jfantamanager'.DS.'helpers'.DS.'profile_mobile.css');
		else
			$document->addStyleSheet('components'.DS.'com_jfantamanager'.DS.'helpers'.DS.'profile.css');

		parent::display($tpl);
	}
}
