<?php
/**
 * BwPostman Newsletter Component
 *
 * BwPostman template tpl model for backend.
 *
 * @version %%version_number%%
 * @package BwPostman-Admin
 * @author Karl Klostermann
 * @copyright (C) %%copyright_year%% Boldt Webservice <forum@boldt-webservice.de>
 * @support https://www.boldt-webservice.de/en/forum-en/forum/bwpostman.html
 * @license GNU/GPL, see LICENSE.txt
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace BoldtWebservice\Component\BwPostman\Administrator\Model;

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die ('Restricted access');

use Exception;
use Joomla\CMS\Form\Form;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Table\Table;
use Joomla\Registry\Registry;

/**
 * BwPostman campaign model
 * Provides methods to add and edit campaigns
 *
 * @package		BwPostman-Admin
 *
 * @subpackage	Campaigns
 *
 * @since 1.1.0
 */
class TemplatesTplModel extends AdminModel
{
	/**
	 * Alias Constructor
	 *
	 * @throws Exception
	 *
	 * @since 1.1.0
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Returns a Table object, always creating it.
	 *
	 * @param	string $name    The table type to instantiate
	 * @param	string $prefix  A prefix for the table class name. Optional.
	 * @param	array  $options Configuration array for model. Optional.
	 *
	 * @return	boolean|Table	A database object
	 *
	 * @throws Exception
	 *
	 * @since  1.1.0
	 */
	public function getTable($name = 'TemplatesTpl', $prefix = 'Administrator', $options = array())
	{
		return parent::getTable($name, $prefix, $options);
	}

	/**
	 * Method to get a single record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  bool|CMSObject    Object on success, false on failure.
	 *
	 * @since   1.1.0
	 */

	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);

		// convert header_tpl string to array
		if (is_string($item->header_tpl))
		{
			$registry = new Registry;
			$registry->loadString($item->header_tpl);
			$item->header_tpl = $registry->toArray();
		}

		return $item;
	}

	/**
	 * Alias Method
	 *
	 * @param array   $data     Data for the form.
	 * @param boolean $loadData True if the form is to load its own data (default case), false if not.
	 *
	 * @return    Form    A JForm object on success, false on failure
	 *
	 * @throws Exception
	 *
	 * @since    1.1.0
	 */
	public function getForm($data = array(), $loadData = true): Form
	{
		// Get the form.
		return $this->loadForm('com_bwpostman.template', 'Template', array('control' => 'jform', 'load_data' => $loadData));
	}
}
