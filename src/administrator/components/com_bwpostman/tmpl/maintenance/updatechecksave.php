<?php
/**
 * BwPostman Newsletter Component
 *
 * BwPostman maintenance updateCheckSave template for backend.
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

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use BoldtWebservice\Component\BwPostman\Administrator\Helper\BwPostmanHTMLHelper;

$uncompressed = Factory::getConfig()->get('debug') ? '-uncompressed' : '';
HTMLHelper::_('script', 'system/modal' . $uncompressed . '.js', array('relative' => true, 'detectBrowser' => true));
HTMLHelper::_('stylesheet', 'media/system/css/modal.css');

$model		= $this->getModel();

$session	= Factory::getSession();
$update		= $session->get('update', false, 'bwpostman');
$release	= $session->get('release', null, 'bwpostman');

$lang = Factory::getLanguage();
//Load first english files
$lang->load('com_bwpostman.sys', JPATH_ADMINISTRATOR, 'en_GB', true);
$lang->load('com_bwpostman', JPATH_ADMINISTRATOR, 'en_GB', true);

//load specific language
$lang->load('com_bwpostman.sys', JPATH_ADMINISTRATOR, null, true);
$lang->load('com_bwpostman', JPATH_ADMINISTRATOR, null, true);

$show_update	= false;
$show_right		= false;
$lang_ver		= substr($lang->getTag(), 0, 2);
$forum	        = BwPostmanHTMLHelper::getForumLink();

$manual	= "https://www.boldt-webservice.de/$lang_ver/downloads/bwpostman/bwpostman-$lang_ver-$release.html";

if ($update)
{
	$string_special		= Text::_('COM_BWPOSTMAN_INSTALLATION_UPDATE_SPECIAL_NOTE_DESC');
}
else
{
	$string_special		= Text::_('COM_BWPOSTMAN_INSTALLATION_INSTALL_SPECIAL_NOTE_DESC');
}
$string_new			= Text::_('COM_BWPOSTMAN_INSTALLATION_UPDATE_NEW_DESC');
$string_improvement	= Text::_('COM_BWPOSTMAN_INSTALLATION_UPDATE_IMPROVEMENT_DESC');
$string_bugfix		= Text::_('COM_BWPOSTMAN_INSTALLATION_UPDATE_BUGFIX_DESC');

if (($string_bugfix != '' || $string_improvement != '' || $string_new != '') && $update)
{
	$show_update	= true;
}
if ($show_update || $string_special != '')
{
	$show_right	= true;
}
?>

<div id="com_bwp_install_header">
	<a href="https://www.boldt-webservice.de" target="_blank">
		<img class="img-fluid" src="components/com_bwpostman/assets/images/bw_header.png" alt="Boldt Webservice" />
	</a>
</div>
<div class="top_line"></div>

<div id="com_bwp_install_outer">
</div>
	<div id="checkResult" class="row">
		<div class="col-12 alert"><?php echo Text::_('COM_BWPOSTMAN_MAINTENANCE_UPDATECHECKSAVE_WARNING'); ?></div>
		<div class="col-lg-6 inner well mx-3">
			<h2><?php echo Text::_('COM_BWPOSTMAN_MAINTENANCE_SAVE_TABLES'); ?></h2>
			<p id="step0" class="well mb-3"><?php echo Text::_('COM_BWPOSTMAN_MAINTENANCE_CHECK_AND_REPAIR_STEP_0'); ?></p>
			<h2><?php echo Text::_('COM_BWPOSTMAN_MAINTENANCE_CHECK_TABLES'); ?></h2>
			<p id="step1" class="well"><?php echo Text::_('COM_BWPOSTMAN_MAINTENANCE_CHECK_AND_REPAIR_STEP_1'); ?></p>
			<p id="step2" class="well"><?php echo Text::_('COM_BWPOSTMAN_MAINTENANCE_CHECK_AND_REPAIR_STEP_2'); ?></p>
			<p id="step3" class="well"><?php echo Text::_('COM_BWPOSTMAN_MAINTENANCE_CHECK_AND_REPAIR_STEP_3'); ?></p>
			<p id="step4" class="well"><?php echo Text::_('COM_BWPOSTMAN_MAINTENANCE_CHECK_AND_REPAIR_STEP_4'); ?></p>
			<p id="step5" class="well"><?php echo Text::_('COM_BWPOSTMAN_MAINTENANCE_CHECK_AND_REPAIR_STEP_5'); ?></p>
	</div>
	<div class="col-lg-5 well mx-3">
		<h2 class="mb-3"><?php echo Text::_('COM_BWPOSTMAN_MAINTENANCE_CHECK_AND_REPAIR_RESULT'); ?></h2>
		<div id="loading2"></div>
		<div id="result"></div>
</div>
</div>
<?php echo LayoutHelper::render('footer', null, JPATH_ADMINISTRATOR . '/components/com_bwpostman/layouts/footer'); ?>

<input type="hidden" id="startUrl" value="index.php?option=com_bwpostman&task=maintenance.tCheck&format=json&<?php echo Session::getFormToken(); ?>=1" />

<?php
Factory::getDocument()->addScript(Uri::root(true) . '/administrator/components/com_bwpostman/assets/js/bwpm_maintenance_doAjax.js');
Factory::getDocument()->addScript(Uri::root(true) . '/administrator/components/com_bwpostman/assets/js/bwpm_update_checksave.js');