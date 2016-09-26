$(document).ready(function() {

	var Settings = function(baseUrl) {
		this._baseUrl = baseUrl;
		this._settings = [];
	};

	Settings.prototype = {
		load: function() {
			var deferred = $.Deferred();
			var self = this;
			$.ajax({
				url: this._baseUrl,
				method: 'GET',
				async: false
			}).done(function(settings) {
				self._settings = settings;
			}).fail(function() {
				deferred.reject();
			});
			return deferred.promise();
		},

		setSystemKey: function(key, value) {
			var deferred = $.Deferred();
			$.ajax({
				url: this._baseUrl + '/' + key + '/' + value,
				method: 'POST'
			}).done(function(data) {
				deferred.resolve(data);
			}).fail(function() {
				$('.msg-template_manager').addClass("msg_error");
				$('.msg-template_manager').text(t('template_manager', 'Error') + '!');
				deferred.reject();
				// kill all JS processes, no reload
				throw new Error('Theme name could not be written to config.php (AJAX error)');
			});
		},

		getKey: function(key) {
			for (var k in this._settings)
			{
				if (k == key)
					return this._settings[k];
			}
		},
		getAll: function() {
			return this._settings;
		}
	};

	var settings = new Settings(OC.generateUrl('/xcapps/template_manager/settings'));
	settings.load();

	// check the right box
	var theme_name = settings.getKey('theme');
	if (theme_name == '') {
		$("#radio_none").prop("checked", true);
	} else {
		$("#radio_" + theme_name).prop("checked", true);
	}

	// write and reload on change
	$('#template_manager-admin input[type=radio]').change(function() {
		theme_name = $(this).val();
		if (theme_name.substr(0, 10) == 'themename_') {
			settings.setSystemKey('theme', theme_name.replace('themename_', ''));
		} else {
			settings.setSystemKey('theme', 'themename_none');
		}
		setTimeout(function() {
			window.location.href = window.location.href;
			window.location.reload(true);
		}, 1);
	});

});
