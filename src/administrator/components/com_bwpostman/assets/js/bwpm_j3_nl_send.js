//
// BwPostman Newsletter Component
//
// BwPostman Javascript for newsletter sending process.
//
// @version %%version_number%%
// @package BwPostman-Admin
// @author Romana Boldt, Karl Klostermann
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
	function doAjax(data, successCallback) {
		var	url = starturl,
			data = data,
			type = 'POST';
		var request = new XMLHttpRequest();
		request.onreadystatechange = function()
		{
			if (this.readyState === 4) {
				if (this.status >= 200 && this.status < 300)
				{
					successCallback(parse(this.responseText));
				}
				else
				{
					var message = document.createElement('div');
					message.innerHTML = '<p class="bw_tablecheck_error">AJAX Error: ' + this.statusText + '<br />' + this.responseText + '</p>';
					document.getElementById('loading2').style.display = "none";
					document.getElementById('error').setAttribute('class', 'alert alert-error');
					var resultdiv = document.getElementById('result');
					resultdiv.insertBefore(message, resultdiv.firstChild);
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
			}
		};
		request.open(type, url, true);
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.send(data);
	}

	function parse(text){
		try {
			return JSON.parse(text);
		} catch(e){
			return text;
		}
	}

	function processUpdateStep(data) {
		var timeout = document.getElementById('delay').value;
		// Do AJAX post
		post = 'mailsDone=' + data.mailsDone;
		doAjax(post, function (data) {
			var res_container = document.getElementById('sendResult');
			if (data.ready !== "1") {
				setStatusDivs(data);
				var alerts = res_container.getElementsByClassName('alert');
                for (var i = 0; i < alerts.length; i++) {
					alerts[i].classList.remove('hidden');
				}
				var alerts_sec = res_container.getElementsByClassName('alert-secondary');
				for (var i = 0; i < alerts_sec.length; i++) {
					alerts_sec[i].classList.add('hidden');
				}
				if (data.delay_msg === "success") {
					setTimeout(function() {
						document.getElementById('sending').setAttribute('class', 'alert alert-success');
						document.getElementById('delay_msg').classList.add('hidden');
						processUpdateStep(data);
					}, timeout);
				} else {
					processUpdateStep(data);
				}
			} else {
				setStatusDivs(data);
				var progress = res_container.getElementsByClassName('progress');
                for (var i = 0; i < progress.length; i++) {
					progress[i].classList.remove('active');
				}
				var alerts = res_container.getElementsByClassName('alert');
                for (var i = 0; i < alerts.length; i++) {
					alerts[i].classList.remove('hidden');
				}
				var alerts_sec = res_container.getElementsByClassName('alert-secondary');
				for (var i = 0; i < alerts_sec.length; i++) {
					alerts_sec[i].classList.add('hidden');
				}
				document.getElementById('loading2').style.display = 'none';
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
		function setStatusDivs(data) {
			var nl_bar = document.getElementById('nl_bar');
			nl_bar.textContent = data.percent+'%';
			nl_bar.style.width = data.percent+'%';
			nl_bar.setAttribute('aria-valuenow', data.percent);
			document.getElementById('nl_to_send_message').innerHTML = data.nl2sendmsg;
			var result = document.createElement('div');
			result.innerHTML = data.result;
			var resultdiv = document.getElementById('result');
			resultdiv.insertBefore(result, resultdiv.firstChild);
			document.getElementById('sending').setAttribute('class', 'alert alert-'+data.sending);
			document.getElementById('delay_msg').setAttribute('class', 'alert alert-'+data.delay_msg);
			document.getElementById('complete').setAttribute('class', 'alert alert-'+data.complete);
			document.getElementById('published').setAttribute('class', 'alert alert-'+data.published);
			document.getElementById('nopublished').setAttribute('class', 'alert alert-'+data.nopublished);
			document.getElementById('error').setAttribute('class', 'alert alert-'+data.error);
		}
	}

	var res_container = document.getElementById('sendResult');
	var alerts_sec = res_container.getElementsByClassName('alert-secondary');
	for (var i = 0; i < alerts_sec.length; i++) {
		alerts_sec[i].classList.add('hidden');
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
	var starturl = document.getElementById('startUrl').value;
	var data = {mailsDone: "0"};
	processUpdateStep(data);
});