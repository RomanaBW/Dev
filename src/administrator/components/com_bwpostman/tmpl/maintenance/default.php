<?php
/**
 * BwPostman Newsletter Component
 *
 * BwPostman maintenance default template for backend.
 *
 * @version %%version_number%%
 * @package BwPostman-Admin
 * @author Romana Boldt
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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$jinput	= JFactory::getApplication()->input;

if ($this->queueEntries)
{
	JFactory::getApplication()->enqueueMessage(JText::_('COM_BWPOSTMAN_ENTRIES_IN_QUEUE'), 'warning');
}
?>

<div id="view_bwpostman_maintenance">
	<div class="top-spacer row">
		<div class="bw-icons col-md-12 module-wrapper">
			<?php
			if (BwPostmanHelper::canAdmin('maintenance')) {
				$option = $jinput->getCmd('option', 'com_bwpostman');
				$link = 'index.php?option=' . $option . '&view=maintenance&layout=checkTables';
				BwPostmanHTMLHelper::quickiconButton(
					$link,
					'icon-48-tablecheck.png',
					JText::_("COM_BWPOSTMAN_MAINTENANCE_CHECK_TABLES"),
					'',
					''
				);

				$link = 'index.php?option=' . $option . '&view=maintenance&task=maintenance.saveTables';
				BwPostmanHTMLHelper::quickiconButton(
					$link,
					'icon-48-tablestore.png',
					JText::_("COM_BWPOSTMAN_MAINTENANCE_SAVE_TABLES"),
					0,
					0
				);

				$link = 'index.php?option=' . $option . '&view=maintenance&task=maintenance.restoreTables';
				BwPostmanHTMLHelper::quickiconButton(
					$link,
					'icon-48-tablerestore.png',
					JText::_("COM_BWPOSTMAN_MAINTENANCE_RESTORE_TABLES"),
					0,
					0
				);

				$link	= 'index.php?option=com_config&amp;view=component&amp;component=' . $option . '&amp;path=';
				BwPostmanHTMLHelper::quickiconButton($link, 'icon-48-config.png', JText::_("COM_BWPOSTMAN_SETTINGS"), '', '');
			}

			// trigger BwTimeControl event
			JFactory::getApplication()->triggerEvent('onBwPostmanMaintenanceRenderLayout');

			$link = BwPostmanHTMLHelper::getForumLink();
			BwPostmanHTMLHelper::quickiconButton($link, 'icon-48-forum.png', JText::_("COM_BWPOSTMAN_FORUM"), 0, 0, 'new');
			?>
		</div>
		<div id="loading" style="display: none;"></div>
	</div>
	<div class="clr clearfix"></div>
	<p class="bwpm_copyright"><?php echo BwPostmanAdmin::footer(); ?></p>
</div>