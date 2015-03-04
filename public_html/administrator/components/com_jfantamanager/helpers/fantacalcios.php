<?php
/**
 * @version		$Id: users.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Users component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_users
 * @since		1.6
 */
class jFantaManagersHelper
{
	/**
	 * @var		JObject	A cache for the available actions.
	 * @since	1.6
	 */
	protected static $actions;
        protected static $giornata;
        protected static $legas;

	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName)
       {
          JSubMenuHelper::addEntry(
             JText::_('COM_FANTACALCIO_SUBMENU_LEGAS'),
             'index.php?option=com_jfantamanager&view=legas',
             $vName == 'legas');
          JSubMenuHelper::addEntry(
             JText::_('COM_FANTACALCIO_SUBMENU_SQUADRAS'),
             'index.php?option=com_jfantamanager&view=squadras',
             $vName == 'squadras');
//          JSubMenuHelper::addEntry(
//             JText::_('COM_FANTACALCIO_SUBMENU_GIOCATORE'),
//             'index.php?option=com_jfantamanager&view=giocatore&layout=edit',
//             $vName == 'giocatore');
          JSubMenuHelper::addEntry(
             JText::_('COM_FANTACALCIO_SUBMENU_CALENDARIOS'),
             'index.php?option=com_jfantamanager&view=calendarios',
             $vName == 'calendarios');
       }

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		if (empty(self::$actions)) {
			$user	= JFactory::getUser();
			self::$actions	= new JObject;

			$actions = array(
				'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
			);

			foreach ($actions as $action) {
				self::$actions->set($action, $user->authorise($action, 'com_users'));
			}
		}

		return self::$actions;
	}

	/**
	 * Get a list of filter options for the blocked state of a user.
	 *
	 * @return	array	An array of JHtmlOption elements.
	 * @since	1.6
	 */
	static function getStateOptions()
	{
		// Build the filter options.
		$options	= array();
		$options[]	= JHtml::_('select.option', '0', JText::_('JENABLED'));
		$options[]	= JHtml::_('select.option', '1', JText::_('JDISABLED'));

		return $options;
	}

	/**
	 * Get a list of filter options for the activated state of a user.
	 *
	 * @return	array	An array of JHtmlOption elements.
	 * @since	1.6
	 */
	static function getActiveOptions()
	{
		// Build the filter options.
		$options	= array();
		$options[]	= JHtml::_('select.option', '0', JText::_('COM_USERS_ACTIVATED'));
		$options[]	= JHtml::_('select.option', '1', JText::_('COM_USERS_UNACTIVATED'));

		return $options;
	}

	/**
	 * Get a list of the user groups for filtering.
	 *
	 * @return	array	An array of JHtmlOption elements.
	 * @since	1.6
	 */
	public static function getLista($id)
	{
                $db = JFactory::getDbo();
		$db->setQuery(
			"SELECT #__fanta_giocatore.nome, #__fanta_giocatore.squadra
                        FROM #__fanta_giocatore, #__fanta_squadra, #__fanta_possiede
                        WHERE #__fanta_squadra.id = $id
                            AND #__fanta_possiede.squadra_id    =   #__fanta_squadra.id
                            AND #__fanta_possiede.giocatore_id  =   #__fanta_giocatore.id
                            AND #__fanta_giocatore.valore_att  !=  999
                            AND #__fanta_possiede.data_ces =  '0000-00-00'
                        ORDER BY #__fanta_giocatore.pos DESC"
		);
		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseNotice(500, $db->getErrorMsg());
			return null;
		}

		foreach ($options as &$option) {
			$option->text = $option->text . "(".substr($option->squadra, 0, 3).")";
		}

		return $options;
	}
        
        public static function getGiornata()
        {
            $db     =& JFactory::getDBO();
            $data_fine = date('Y-m-d', mktime(0,0,0,date(m),date(d)-1,date(Y)));

            $query ="SELECT MIN(`giornata`) as giornata FROM `#__fanta_calendario` WHERE `data` >= '$data_fine'";
            $db->setQuery( $query );
            $giornata = $db->loadResult();

            return $giornata;
        }
        
}