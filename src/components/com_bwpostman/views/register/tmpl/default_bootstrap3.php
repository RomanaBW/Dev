<?php
/**
 * BwPostman Newsletter Component
 *
 * BwPostman register bootstrap 3 template for frontend.
 *
 * @version %%version_number%%
 * @package BwPostman-Site
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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

JLoader::register('ContentHelperRoute', JPATH_SITE . '/components/com_content/helpers/route.php');

HTMLHelper::_('bootstrap.tooltip');

JHtml::_('stylesheet', 'com_bwpostman/bwpostman_bs3.css', array('version' => 'auto', 'relative' => true));
$templateName	= Factory::getApplication()->getTemplate();
$css_filename	= 'templates/' . $templateName . '/css/com_bwpostman.css';
JHtml::_('stylesheet', $css_filename, array('version' => 'auto'));

$remote_ip  = Factory::getApplication()->input->server->get('REMOTE_ADDR', '', '');

$formclass	= ''; // '' = default inputs or 'sm' = smaller Inputs
?>

<div id="bwpostman">
	<div id="bwp_com_register">
		<div class="content_inner">
		<?php // displays a message if no availible mailinglist
		if ($this->lists['available_mailinglists'])
		{
			if (($this->params->get('show_page_heading') != 0) && ($this->params->get('page_heading') != ''))
			{ ?>
				<h1 class="componentheading<?php echo $this->params->get('pageclass_sfx'); ?>">
					<?php echo $this->escape($this->params->get('page_heading')); ?>
				</h1>
			<?php
			} ?>

			<form action="<?php echo Route::_('index.php?option=com_bwpostman'); ?>" method="post"
					id="bwp_com_form" name="bwp_com_form" class="form-validate">
				<?php // Spamcheck 1 - Input-field: class="user_highlight" style="position: absolute; top: -5000px;" ?>
				<p class="user_hightlight">
					<label for="falle"><strong><?php echo addslashes(Text::_('COM_BWPOSTMAN_SPAMCHECK')); ?></strong></label>
					<input type="text" name="falle" id="falle" size="20"
							title="<?php echo addslashes(Text::_('COM_BWPOSTMAN_SPAMCHECK')); ?>" maxlength="50" />
				</p>

				<div class="contentpane<?php echo $this->params->get('pageclass_sfx'); ?>">
					<?php // Show pretext only if set in basic parameters
					if ($this->params->get('pretext'))
					{
						$preText = Text::_($this->params->get('pretext'));
						?>
						<div class="pre_text mb-3"><?php echo $preText; ?></div>
						<?php
					} // End: Show pretext only if set in basic parameters ?>

					<?php // Show editlink only if the user is not logged in
					$link = Uri::base() . 'index.php?option=com_bwpostman&view=edit';
					?>
						<p class="user_edit">
							<a href="<?php echo $link; ?>">
								<?php echo Text::_('COM_BWPOSTMAN_LINK_TO_EDITLINKFORM'); ?>
							</a>
						</p>
					<?php // End: Show editlink only if the user is not logged in
					?>

					<?php // Show formfield gender only if enabled in basic parameters
					if ($this->params->get('show_gender') == 1)
					{
				        $gender_selected = isset($this->subscriber->gender) ? $this->subscriber->gender : '2';
						$class = $formclass === 'sm' ? ' class="form-control input-sm"' : ' class="form-control"';
				    ?>
						<div class="form-group row">
							<label id="gendermsg" class="col-sm-2 control-label" for="gender"> <?php echo Text::_('COM_BWPOSTMAN_GENDER'); ?>:</label>
				            <div class="col-sm-10">
								<select id="gender"<?php echo $class; ?> name="gender">
									<option value="2"<?php echo $gender_selected == '2' ? ' selected="selected"' : ''; ?>>
							            <?php echo Text::_('COM_BWPOSTMAN_NO_GENDER'); ?>
									</option>
									<option value="0"<?php echo $gender_selected == '0' ? ' selected="selected"' : ''; ?>>
							            <?php echo Text::_('COM_BWPOSTMAN_MALE'); ?>
									</option>
									<option value="1"<?php echo $gender_selected == '1' ? ' selected="selected"' : ''; ?>>
							            <?php echo Text::_('COM_BWPOSTMAN_FEMALE'); ?>
									</option>
								</select>
				            </div>
						</div>
					<?php
					} // End gender ?>

					<?php // Show first name-field only if set in basic parameters
					if ($this->params->get('show_firstname_field') || $this->params->get('firstname_field_obligation'))
					{ ?>
						<div class="form-group row user_firstname">
							<label id="firstnamemsg" class="col-sm-2 control-label" for="firstname">
								<?php echo Text::_('COM_BWPOSTMAN_FIRSTNAME'); ?>: </label>
							<?php // Is filling out the firstname field obligating
							if ($this->params->get('firstname_field_obligation'))
							{ ?>
					            <div class="col-sm-10">
					                <div class="input-group<?php echo $formclass === "sm" ? ' input-group-sm' : ''; ?>">
										<input type="text" name="firstname" id="firstname" size="40"
											value="<?php echo $this->subscriber->firstname; ?>"
											class="form-control" maxlength="50" />
										<span class="input-group-addon"><i class="fa fa-star"></i></span>
									</div>
					            </div>
							<?php
							}
							else
							{ ?>
					            <div class="col-sm-10">
									<input type="text" name="firstname" id="firstname" size="40"
											class="form-control<?php echo $formclass === "sm" ? ' input-sm' : ''; ?>"
											value="<?php echo $this->subscriber->firstname; ?>" maxlength="50" />
					            </div>
							<?php
							}

							// End: Is filling out the firstname field obligating
							?>
						</div> <?php
					}

					// End: Show first name-field only if set in basic parameters ?>


					<?php // Show name-field only if set in basic parameters
					if ($this->params->get('show_name_field') || $this->params->get('name_field_obligation'))
					{ ?>
						<div class="form-group row user_name edit_name">
							<label id="namemsg" class="col-sm-2 control-label" for="name">
								<?php echo Text::_('COM_BWPOSTMAN_NAME'); ?>: </label>
							<?php // Is filling out the name field obligating
							if ($this->params->get('name_field_obligation'))
							{ ?>
					            <div class="col-sm-10">
					                <div class="input-group<?php echo $formclass === "sm" ? ' input-group-sm' : ''; ?>">
										<input type="text" name="name" id="name" size="40"
											value="<?php echo $this->subscriber->name; ?>"
											class="form-control" maxlength="50" />
										<span class="input-group-addon"><i class="fa fa-star"></i></span>
									</div>
					            </div>
							<?php
							}
							else
							{ ?>
					            <div class="col-sm-10">
									<input type="text" name="name" id="name" size="40"
										class="form-control<?php echo $formclass === "sm" ? ' input-sm' : ''; ?>"
										value="<?php echo $this->subscriber->name; ?>" maxlength="50" />
					            </div>
							<?php
							}

							// End: Is filling out the name field obligating
							?>
						</div> <?php
					}

					// End: Show name-fields only if set in basic parameters ?>

					<?php // Show special only if set in basic parameters or required
					if ($this->params->get('show_special') || $this->params->get('special_field_obligation'))
					{
						if ($this->params->get('special_desc') != '')
						{
							$tip = Text::_($this->params->get('special_desc'));
						}
						else
						{
							$tip = Text::_('COM_BWPOSTMAN_SPECIAL');
						} ?>

						<div class="form-group row edit_special">
							<label id="specialmsg" class="col-sm-2 control-label hasTooltip" title="<?php echo HtmlHelper::tooltipText($tip); ?>" for="special">
								<?php
								if ($this->params->get('special_label') != '')
								{
									echo Text::_($this->params->get('special_label'));
								}
								else
								{
									echo Text::_('COM_BWPOSTMAN_SPECIAL');
								}
								?>:
							</label>
							<?php // Is filling out the special field obligating
							if ($this->params->get('special_field_obligation'))
							{ ?>
					            <div class="col-sm-10">
					                <div class="input-group<?php echo $formclass === "sm" ? ' input-group-sm' : ''; ?>">
										<input type="text" name="special" id="special" size="40" value="<?php echo $this->subscriber->special; ?>"
											class="form-control" maxlength="50" />
										<span class="input-group-addon"><i class="fa fa-star"></i></span>
									</div>
					            </div>
							<?php
							}
							else
							{ ?>
					            <div class="col-sm-10">
									<input type="text" name="special" id="special" size="40"
										class="form-control<?php echo $formclass === "sm" ? ' input-sm' : ''; ?>"
										value="<?php echo $this->subscriber->special; ?>" maxlength="50" />
					            </div>
							<?php
							}

							// End: Is filling out the special field obligating
							?>
						</div> <?php
					} // End: Show special field only if set in basic parameters ?>


					<div class="form-group row user_email edit_email">
						<label id="emailmsg" class="col-sm-2 control-label" for="email">
							<?php echo Text::_('COM_BWPOSTMAN_EMAIL'); ?>:
						</label>
					    <div class="col-sm-10">
							<div class="input-group<?php echo $formclass === "sm" ? ' input-group-sm' : ''; ?>">
								<input type="text" id="email" name="email" size="40" value="<?php echo $this->subscriber->email; ?>"
									class="form-control" maxlength="50" />
								<span class="input-group-addon"><i class="fa fa-star"></i></span>
							</div>
						</div>
					</div>
					<?php
					// Show formfield email format only if enabled in basic parameters
					if ($this->params->get('show_emailformat') == 1)
					{
				        $mailformat_selected = isset($this->subscriber->emailformat) ? $this->subscriber->emailformat : $this->params->get('default_emailformat');
					?>
						<div class="form-group row user_mailformat edit_emailformat">
							<label id="emailformatmsg" class="col-sm-2 control-label"> <?php echo Text::_('COM_BWPOSTMAN_EMAILFORMAT'); ?>: </label>
						    <div class="col-sm-10">
								<div id="edit_mailformat" class="btn-group<?php echo $formclass === "sm" ? ' btn-group-sm' : ''; ?>" data-toggle="buttons">
									<label class="btn btn-default<?php echo (!$mailformat_selected ? ' active' : ''); ?>" for="formatText">
										<input type="radio" name="emailformat" id="formatText" value="0"<?php echo (!$mailformat_selected ? ' checked="checked"' : ''); ?> />
										<span>&nbsp;&nbsp;&nbsp;<?php echo Text::_('COM_BWPOSTMAN_TEXT'); ?>&nbsp;&nbsp;&nbsp;</span>
									</label>
									<label class="btn btn-default<?php echo ($mailformat_selected ? ' active' : ''); ?>" for="formatHtml">
										<input type="radio" name="emailformat" id="formatHtml" value="1"<?php echo ($mailformat_selected ? ' checked="checked"' : ''); ?> />
										<span>&nbsp;&nbsp;<?php echo Text::_('COM_BWPOSTMAN_HTML'); ?>&nbsp;&nbsp;</span>
									</label>
								</div>
							</div>
						</div>
					<?php
					}
					else
					{
						// hidden field with the default email format
						?>
						<input type="hidden" name="emailformat" value="<?php echo $this->params->get('default_emailformat'); ?>" />
					<?php
					}

					// End email format
					?>

					<?php
					// Show available mailinglists
					if ($this->lists['available_mailinglists'])
					{ ?>
						<div class="lists my-3<?php echo $this->params->get('pageclass_sfx'); ?>">
							<?php
							$n = count($this->lists['available_mailinglists']);

							$descLength = $this->params->get('desc_length');

							if ($this->lists['available_mailinglists'] && ($n > 0))
							{
								if ($n == 1)
								{ ?>
									<input title="mailinglists_array" type="checkbox" style="display: none;" id="<?php echo "mailinglists0"; ?>"
											name="<?php echo "mailinglists[]"; ?>" value="<?php echo $this->lists['available_mailinglists'][0]->id; ?>" checked="checked" />
									<?php
									if ($this->params->get('show_desc') == 1)
									{ ?>
										<div class="mail_available">
											<?php echo Text::_('COM_BWPOSTMAN_MAILINGLIST'); ?>
										</div>
										<div class="mailinglist-description-single">
											<span class="mail_available_list_title strong">
												<?php echo $this->lists['available_mailinglists'][0]->title . ": "; ?>
											</span><br />
											<?php
											echo substr(Text::_($this->lists['available_mailinglists'][0]->description), 0, $descLength);

											if (strlen(Text::_($this->lists['available_mailinglists'][0]->description)) > $descLength)
											{
												echo '... ';
												echo HtmlHelper::tooltip(Text::_($this->lists['available_mailinglists'][0]->description),
													$this->lists['available_mailinglists'][0]->title, '', '<i class="fa fa-info-circle fa-lg"></i>', '');
											} ?>
										</div>
										<?php
									}
								}
								else
								{ ?>
									<div class="mail_available strong">
										<?php echo Text::_('COM_BWPOSTMAN_MAILINGLISTS') . ' <sup><i class="fa fa-star"></i></sup>'; ?>
									</div>
									<?php
									foreach ($this->lists['available_mailinglists'] as $i => $item)
									{ ?>
										<div class="checkbox mail_available_list <?php echo "mailinglists$i"; ?>">
				                            <label class="form-check-label" for="<?php echo "mailinglists$i"; ?>">
											<input class="form-check-input" title="mailinglists_array" type="checkbox" id="<?php echo "mailinglists$i"; ?>"
													name="<?php echo "mailinglists[]"; ?>" value="<?php echo $item->id; ?>"
											<?php
											if ((is_array($this->subscriber->mailinglists)) && (in_array((int) $item->id,
													$this->subscriber->mailinglists)))
											{
												echo "checked=\"checked\"";
											} ?> />
												<span class="mail_available_list_title strong">
													<?php echo $this->params->get('show_desc') == 1 ? $item->title . ": " : $item->title; ?>
												</span><br />
												<?php
												if ($this->params->get('show_desc') == 1)
												{ ?>
												<span>
													<?php
													echo substr(Text::_($item->description), 0, $descLength);
													if (strlen(Text::_($item->description)) > $descLength)
													{
														echo '... ';
														echo HtmlHelper::tooltip(Text::_($item->description), $item->title, '', '<i class="fa fa-info-circle fa-lg"></i>', '');
													} ?>
												</span>
												<?php
												} ?>
				                            </label>
										</div>
										<?php
									}
								}
							}?>
						</div>

						<?php
					}

					// End Mailinglists ?>

				</div>

				<?php // Question
				if ($this->params->get('use_captcha') == 1) : ?>
					<div class="question panel panel-default panel-body">
						<div class="question-text"><?php echo Text::_('COM_BWPOSTMAN_CAPTCHA'); ?></div>
						<div class="form-group row">
							<div class="security_question_lbl col-sm-10 offset-sm-2 my-3"><?php echo Text::_($this->params->get('security_question')); ?></div>
						</div>
						<div class="form-group row question-result">
							<label id="question" class="col-sm-2 col-form-label" for="stringQuestion"><?php echo Text::_('COM_BWPOSTMAN_CAPTCHA_LABEL'); ?>:</label>
				            <div class="col-sm-10">
				                <div class="input-group<?php echo $formclass === "sm" ? ' input-group-sm' : ''; ?>">
									<input type="text" name="stringQuestion" id="stringQuestion" class="form-control" size="40" maxlength="50" />
									<span class="input-group-addon"><i class="fa fa-star"></i></span>
								</div>
							</div>
						</div>
					</div>
				<?php endif; // End question ?>

				<?php // Captcha
				if ($this->params->get('use_captcha') == 2) :
					$codeCaptcha = md5(microtime());
					?>

					<div class="captcha panel panel-default panel-body">
						<div class="captcha-text"><?php echo Text::_('COM_BWPOSTMAN_CAPTCHA'); ?></div>
						<div class="form-group row">
							<div class="security_question_lbl col-sm-10 col-sm-offset-2 my-3">
								<img src="<?php echo Uri::base();?>index.php?option=com_bwpostman&amp;view=register&amp;task=showCaptcha&amp;format=raw&amp;codeCaptcha=<?php echo $codeCaptcha; ?>" alt="captcha" />
							</div>
						</div>
						<div class="form-group row captcha-result">
							<label id="captcha" class="col-sm-2 control-label" for="stringCaptcha"><?php echo Text::_('COM_BWPOSTMAN_CAPTCHA_LABEL'); ?>:</label>
				            <div class="col-sm-10">
				                <div class="input-group<?php echo $formclass === "sm" ? ' input-group-sm' : ''; ?>">
									<input type="text" name="stringCaptcha" id="stringCaptcha" class="form-control" size="40" maxlength="50" />
									<span class="input-group-addon"><i class="fa fa-star"></i></span>
								</div>
				            </div>
						</div>
					</div>
					<input type="hidden" name="codeCaptcha" value="<?php echo $codeCaptcha; ?>" />
				<?php endif; // End captcha ?>

				<div class="disclaimer<?php echo $this->params->get('pageclass_sfx'); ?>">
					<?php // Show Disclaimer only if enabled in basic parameters
					if ($this->params->get('disclaimer')) :
						?>
						<div class="form-check agree_check my-3">
							<input title="agreecheck" type="checkbox" id="agreecheck" class="form-check-input" name="agreecheck" />
							<?php
							// Extends the disclaimer link with '&tmpl=component' to see only the content
							$tpl_com = $this->params->get('showinmodal') == 1 ? '&amp;tmpl=component' : '';
							// Disclaimer article and target_blank or not
							if ($this->params->get('disclaimer_selection') == 1 && $this->params->get('article_id') > 0)
							{
								$disclaimer_link = Route::_(Uri::base() . ContentHelperRoute::getArticleRoute($this->params->get('article_id') . $tpl_com, 0));
							}
							// Disclaimer menu item and target_blank or not
							elseif ($this->params->get('disclaimer_selection') == 2 && $this->params->get('disclaimer_menuitem') > 0)
							{
								if ($tpl_com !== '' && Factory::getConfig()->get('sef') === '1')
								{
									$tpl_com = '?tmpl=component';
								}
								$disclaimer_link = Route::_("index.php?Itemid={$this->params->get('disclaimer_menuitem')}") . $tpl_com;
							}
							// Disclaimer url and target_blank or not
							else
							{
								$disclaimer_link = $this->params->get('disclaimer_link');
							}
							?>
							<label class="form-check-label">
								<?php
								// Show inside modalbox
								if ($this->params->get('showinmodal') == 1)
								{
									echo '<a id="bwp_com_open"';
								}
								// Show not in modalbox
								else
								{
									echo '<a href="' . $disclaimer_link . '"';
									if ($this->params->get('disclaimer_target') == 0)
									{
										echo ' target="_blank"';
									};
								}
								echo '>' . Text::_('COM_BWPOSTMAN_DISCLAIMER') . '</a> <sup><i class="fa fa-star"></i></sup>'; ?>
							</label>
						</div>
					<?php endif; // Show disclaimer ?>

					<div class="button-register mb-3">
						<button class="button validate btn btn-default" type="submit"><?php echo Text::_('COM_BWPOSTMAN_BUTTON_REGISTER'); ?></button>
					</div>

					<div class="register-required small">
						<?php echo str_replace('icon-star', 'fa fa-star', Text::_('COM_BWPOSTMAN_REQUIRED')); ?>
					</div>
				</div>

			<input type="hidden" name="option" value="com_bwpostman" />
			<input type="hidden" name="task" value="save" />
			<input type="hidden" name="view" value="register" />
			<input type="hidden" name="id" value="<?php echo $this->subscriber->id; ?>" />
			<input type="hidden" name="bwp-<?php echo $this->captcha; ?>" value="1" />
			<input type="hidden" name="name_field_obligation" id="name_field_obligation"
					value="<?php echo $this->params->get('name_field_obligation'); ?>" />
			<input type="hidden" name="firstname_field_obligation" id="firstname_field_obligation"
					value="<?php echo $this->params->get('firstname_field_obligation'); ?>" />
			<input type="hidden" name="special_field_obligation" id="special_field_obligation"
					value="<?php echo $this->params->get('special_field_obligation'); ?>" />
			<input type="hidden" name="show_name_field" value="<?php echo $this->params->get('show_name_field'); ?>" />
			<input type="hidden" name="show_firstname_field" value="<?php echo $this->params->get('show_firstname_field'); ?>" />
			<input type="hidden" name="show_special" value="<?php echo $this->params->get('show_special'); ?>" />
			<input type="hidden" name="registration_ip" value="<?php echo $remote_ip; ?>" />
			<?php echo HtmlHelper::_('form.token'); ?>
			</form>

			<?php

			// The Modal
			if ($this->params->get('showinmodal') == 1)
			{ ?>
				<input type="hidden" id="bwp_com_Modalhref" value="<?php echo $disclaimer_link; ?>" />
				<div id="bwp_com_Modal" class="bwp_com_modal">
					<div id="bwp_com_modal-content">
						<h4 id="bwp_modal-title">Information</h4>
						<span class="bwp_com_close">&times;</span>
						<div id="bwp_com_wrapper"></div>
					</div>
				</div>
			<?php
			}
		}
		else
		{
			echo Text::_('COM_BWPOSTMAN_MESSAGE_NO_AVAILIBLE_MAILINGLIST');
		}

		if ($this->params->get('show_boldt_link') === '1')
		{ ?>
			<p class="bwpm_copyright"><?php echo BwPostman::footer(); ?></p>
		<?php
		} ?>
		</div>
	</div>
</div>
<?php
if ($this->params->get('showinmodal') == 1)
{ ?>
<script type="text/javascript">
jQuery(document).ready(function()
{
	function setComModal() {
		// Set the modal height and width 90%
		if (typeof window.innerWidth != 'undefined')
		{
			viewportwidth = window.innerWidth,
				viewportheight = window.innerHeight
		}
		else if (typeof document.documentElement != 'undefined'
			&& typeof document.documentElement.clientWidth !=
			'undefined' && document.documentElement.clientWidth != 0)
		{
			viewportwidth = document.documentElement.clientWidth,
				viewportheight = document.documentElement.clientHeight
		}
		else
		{
			viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
				viewportheight = document.getElementsByTagName('body')[0].clientHeight
		}
		var modalcontent = document.getElementById('bwp_com_modal-content');
		modalcontent.style.height = viewportheight-(viewportheight*0.10)+'px';
		modalcontent.style.width = viewportwidth-(viewportwidth*0.10)+'px';

		// Get the modal
		var commodal = document.getElementById('bwp_com_Modal');
		var commodalhref = document.getElementById('bwp_com_Modalhref').value;

		// Get the Iframe-Wrapper and set Iframe
		var wrapper = document.getElementById('bwp_com_wrapper');
		var html = '<iframe id="BwpFrame" name="BwpFrame" src="'+commodalhref+'" frameborder="0" style="width:100%; height:100%;"></iframe>';

		// Get the button that opens the modal
		var btnopen = document.getElementById("bwp_com_open");

		// Get the <span> element that closes the modal
		var btnclose = document.getElementsByClassName("bwp_com_close")[0];

		// When the user clicks the button, open the modal
		btnopen.onclick = function() {
			wrapper.innerHTML = html;
			// Hack for Beez3 template
			var iframe = document.getElementById('BwpFrame');
			iframe.onload = function() {
				this.contentWindow.document.head.insertAdjacentHTML("beforeend", `<style>.contentpane #all{max-width:unset;}</style>`)
			}
			commodal.style.display = "block";
		}

		// When the user clicks on <span> (x), close the modal
		btnclose.onclick = function() {
			commodal.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.addEventListener('click', function(event) {
			if (event.target == commodal) {
				commodal.style.display = "none";
			}
		});
	}
	setComModal();
})
</script>
<?php
} ?>