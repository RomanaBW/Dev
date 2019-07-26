<?php
/**
 * BwPostman Newsletter Component
 *
 * BwPostman all mailinglists default template for backend.
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

use Joomla\CMS\Layout\LayoutHelper;

JHtml::_('bootstrap.tooltip');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.multiselect');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));

?>

<script type="text/javascript">
/* <![CDATA[ */
	Joomla.submitbutton = function (pressbutton)
	{
		if (pressbutton == 'archive')
		{
			ConfirmArchive = confirm("<?php echo JText::_('COM_BWPOSTMAN_ML_CONFIRM_ARCHIVE' , true); ?>");
			if (ConfirmArchive == true)
			{
				Joomla.submitform(pressbutton, document.adminForm);
			}
		}
		else
		{
			Joomla.submitform(pressbutton, document.adminForm);
		}
	};
/* ]]> */
</script>

<div id="bwp_view_lists">
	<form action="<?php echo JRoute::_('index.php?option=com_bwpostman&view=mailinglists'); ?>"
			method="post" name="adminForm" id="adminForm">
		<div class="row">
			<div class="col-md-12">
				<div id="j-main-container" class="j-main-container">
					<?php
						// Search tools bar
						echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this));
					?>

					<table id="main-table" class="table">
						<thead>
							<tr>
								<th style="width: 1%;" class="text-center">
									<input class="hasTooltip" type="checkbox" name="checkall-toggle" value=""
											title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
								</th>
								<th class="d-none d-md-table-cell" style="min-width: 100px;" scope="col">
									<?php echo JHtml::_('searchtools.sort',  'COM_BWPOSTMAN_ML_TITLE', 'a.title', $listDirn, $listOrder); ?>
								</th>
								<th class="d-none d-md-table-cell" style="min-width: 250px;" scope="col">
									<?php echo JHtml::_('searchtools.sort',  'COM_BWPOSTMAN_ML_DESCRIPTION', 'a.description', $listDirn, $listOrder); ?>
								</th>
								<th class="d-none d-md-table-cell" style="width: 10%;" scope="col">
									<?php echo JHtml::_('searchtools.sort',  'PUBLISHED', 'a.published', $listDirn, $listOrder); ?>
								</th>
								<th class="d-none d-md-table-cell" style="width: 10%;" scope="col">
									<?php echo JHtml::_('searchtools.sort',  'ACCESS_LEVEL', 'a.access', $listDirn, $listOrder); ?>
								</th>
								<th class="d-none d-md-table-cell" style="width: 7%;" scope="col">
									<?php echo JHtml::_('searchtools.sort',  'COM_BWPOSTMAN_ML_SUB_NUM', 'subscribers', $listDirn, $listOrder); ?>
								</th>
								<th class="d-none d-md-table-cell" style="width: 3%;" scope="col" aria-sort="ascending">
									<?php echo JHtml::_('searchtools.sort',  'NUM', 'a.id', $listDirn, $listOrder); ?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (count($this->items) > 0) {
								foreach ($this->items as $i => $item) :
								?>
								<tr class="row<?php echo $i % 2; ?>">
									<td align="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
									<td>
										<?php if ($item->checked_out) : ?>
											<?php echo JHtml::_(
												'jgrid.checkedout',
												$i,
												$item->editor,
												$item->checked_out_time,
												'mailinglists.',
												BwPostmanHelper::canCheckin('mailinglist', $item->checked_out)
											); ?>
										<?php endif; ?>
										<?php if (BwPostmanHelper::canEdit('mailinglist', $item)) : ?>
											<a href="<?php echo JRoute::_('index.php?option=com_bwpostman&task=mailinglist.edit&id=' . $item->id);?>">
												<?php echo $this->escape($item->title); ?>
											</a>
										<?php else : ?>
											<?php echo $this->escape($item->title); ?>
										<?php endif; ?>
									</td>
									<td><?php echo $item->description; ?></td>
									<td align="center">
										<?php echo JHtml::_(
											'jgrid.published',
											$item->published,
											$i,
											'mailinglists.',
											BwPostmanHelper::canEditState('mailinglist', (int) $item->id),
											'cb'
										); ?>
									</td>
									<td><?php echo $this->escape($item->access_level); ?></td>
									<td align="center"><?php echo $item->subscribers; ?></td>
									<td align="center"><?php echo $item->id; ?></td>
								</tr>
								<?php endforeach;
							}
							else { ?>
								<tr class="row1">
									<td colspan="7"><strong><?php echo JText::_('COM_BWPOSTMAN_NO_DATA'); ?></strong></td>
								</tr><?php
							}
							?>
						</tbody>
					</table>
				</div>

				<input type="hidden" name="task" value="" />
				<input type="hidden" name="boxchecked" value="0" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
			<div class="pagination"><?php echo $this->pagination->getListFooter(); ?></div>
			<p class="bwpm_copyright"><?php echo BwPostmanAdmin::footer(); ?></p>
		</div>
	</form>
</div>