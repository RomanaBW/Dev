//
// BwPostman Newsletter Component
//
// BwPostman Javascript for template import.
//
// @version %%version_number%%
// @package BwPostman-Admin
// @author Romana Boldt, Karl Klostermann
// @copyright (C) 2021 Boldt Webservice <forum@boldt-webservice.de>
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

function ready(callbackFunc) {
	if (document.readyState !== 'loading') {
		// Document is already ready, call the callback directly
		callbackFunc();
	} else if (document.addEventListener) {
		// All modern browsers to register DOMContentLoaded
		document.addEventListener('DOMContentLoaded', callbackFunc);
	} else {
		// Old IE browsers
		document.attachEvent('onreadystatechange', function() {
			if (document.readyState === 'complete') {
				callbackFunc();
			}
		});
	}
}

ready(function() {
	function processUpdateStep(data) {
		var alert_step_old = document.getElementById('step' + (data.step - 1));
		if(typeof alert_step_old !== 'undefined' && alert_step_old !== null) {
			alert_step_old.querySelector('span.fa').classList.remove('fa-spinner');
			alert_step_old.classList.remove('alert-info');
			alert_step_old.classList.add('alert-' + data.aClass);
		}
		var pstep = document.getElementById('step' + data.step);
		pstep.classList.remove('alert-secondary');
		pstep.classList.add('alert-info');
		pstep.querySelector('span.fa').classList.add('fa-spinner');
		// Do AJAX post
		post = 'step=step' + data.step;
		doAjax(post, function (data) {
			if (data.ready !== "1") {
				document.getElementById('result').innerHTML = document.getElementById('result').innerHTML + data.result;
				processUpdateStep(data);
			} else {
				var alert_step_old = document.getElementById('step' + (data.step - 1));
				if(typeof alert_step_old !== 'undefined' && alert_step_old !== null) {
					alert_step_old.querySelector('span.fa').classList.remove('fa-spinner');
					alert_step_old.classList.remove('alert-info');
					alert_step_old.classList.add('alert-' + data.aClass);
				}
				document.getElementById('loader').style.display = 'none';
				document.getElementById('result').innerHTML = document.getElementById('result').innerHTML + data.result;
				if (typeof data.error !== 'undefined' && data.error !== null) {
					document.getElementById('resultSet').style.backgroundColor = '#f3d4d4';
					document.getElementById('resultSet').style.borderColor = '#eebfbe';
					var alert_step = document.getElementById(data.step);
					if(typeof alert_step !== 'undefined' && alert_step !== null) {
						alert_step.querySelector('span.fa').classList.remove('fa-spinner');
						alert_step.classList.remove('alert-info');
						alert_step.classList.add('alert-danger');
					}
				} else {
					document.getElementById('resultSet').style.backgroundColor = '#e1f5ec';
					document.getElementById('resultSet').style.borderColor = '#0f2f21';
				}

				var toolbar = document.getElementById('toolbar');
				var buttags = toolbar.getElementsByTagName('button');
				for (var i = 0; i < buttags.length; i++) {
					buttags[i].removeAttribute('disabled');
				}
				var atags = toolbar.getElementsByTagName('a');
				for (var i = 0; i < atags.length; i++) {
					atags[i].removeAttribute('disabled');
				}
			}
		});
	}

	var toolbar = document.getElementById('toolbar');
	var buttags = toolbar.getElementsByTagName('button');
	for (var i = 0; i < buttags.length; i++) {
		buttags[i].setAttribute("disabled", "disabled");
	}
	var atags = toolbar.getElementsByTagName('a');
	for (var i = 0; i < atags.length; i++) {
		atags[i].setAttribute("disabled", "disabled");
	}
	var data = {step: "1"};
	setTimeout(function(){
		processUpdateStep(data);
	}, 1000);

});