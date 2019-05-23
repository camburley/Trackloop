/*
 * jQuery File Upload Plugin JS Example 8.3.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, regexp: true */
/*global $, window, blueimp */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'artist/upload',		
		progressall: function (e, data) {
			// Update the progress bar while files are being uploaded
			var progress = parseInt(data.loaded / data.total * 100, 10);
			console.log(progress);
			if (100 == progress) {
				$('#progress').css({'display': 'none'});
				$('#progress .bar').css({'width': 0 + '%'});
			} else {
				$('#progress').css({'display': 'block'});
				$('#progress .bar').css({'width': progress + '%'});
			}
		}
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

	// Load existing files:
	$('#fileupload').addClass('fileupload-processing');
	/*$.ajax({
		// Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
		url: '/stage/artist/server/php/uhandle.php',
		dataType: 'json',
		context: $('#fileupload')[0]
	}).always(function () {
		$(this).removeClass('fileupload-processing');
	}).done(function (result) {
		$(this).fileupload('option', 'done')
			.call(this, null, {result: result});
	});*/
});
