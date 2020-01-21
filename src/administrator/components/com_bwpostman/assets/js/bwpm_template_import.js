//
// BwPostman Newsletter Component
//
// BwPostman Javascript for template import.
//
// @version %%version_number%%
// @package BwPostman-Admin
// @author Romana Boldt
// @copyright (C) %%copyright_year%% Boldt Webservice <forum@boldt-webservice.de>
// @support https://www.boldt-webservice.de/en/forum-en/forum/bwpostman.html
// @license GNU/GPL v3, see LICENSE.txt
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//

window.onload = function() {
	function doAjax(data, successCallback) {
		var structure =
			{
				success: function (data) {
					// Call the callback function
					successCallback(data);
				},
				error  : function (req) {
					var message = '<p class="bw_tablecheck_error">AJAX Loading Error: ' + req.statusText + '</p>';
					jQuery('p#' + data.step).removeClass('alert-info').addClass('alert-error');
					jQuery('div#result').html(message);
					jQuery('div.resultSet').css('background-color', '#f2dede');
					jQuery('div.resultSet').css('border-color', '#eed3d7');
					jQuery('div#toolbar').find('button').removeAttr('disabled');
				}
			};

		structure.url = starturl;
		structure.data = data;
		structure.type = 'POST';
		structure.dataType = 'json';
		jQuery.ajax(structure);
	}

	function processUpdateStep(data) {
		jQuery('p#step' + (data.step - 1)).removeClass('alert-info').addClass('alert-' + data.aClass);
		jQuery('p#step' + data.step).addClass('alert alert-info');
		// Do AJAX post
		post = {step: 'step' + data.step};
		doAjax(post, function (data) {
			if (data.ready !== "1") {
				jQuery('div#result').append(data.result);
				processUpdateStep(data);
			} else {
				jQuery('p#step' + (data.step - 1)).removeClass('alert-info').addClass('alert alert-' + data.aClass);
				jQuery('div#result').append(data.result);
				if (data.aClass !== 'error') {
					jQuery('div.resultSet').css('background-color', '#dff0d8');
					jQuery('div.resultSet').css('border-color', '#d6e9c6');
				} else {
					jQuery('div.resultSet').css('background-color', '#f2dede');
					jQuery('div.resultSet').css('border-color', '#eed3d7');
				}
				jQuery('div#toolbar').find('button').removeAttr('disabled');
			}
		});
	}

	jQuery('div#toolbar').find('button').attr("disabled", "disabled");
	var starturl = document.getElementById('startUrl').value;
	var data = {step: "1"};
	processUpdateStep(data);
};