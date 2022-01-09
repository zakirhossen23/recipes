jQuery(document).ready(function ($) {

	$(document).on('click', '.upload_image_button', function (e) {

		e.preventDefault();
		var image_frame;
		if(image_frame){
			image_frame.open();
		}
		var form = $(this).closest('form');

		// var widget_id = $(this).data('widgetId');
		var widget_id = $(this).data('widgetId').replace('[image_id]', '');
		var image_element_id = form.find('.preview_image').attr('id');
		// console.log(image_element_id);
		var image_id_name = widget_id+'[image_id]';
		var input_element = $('[name="'+image_id_name+'"]');
		// console.log(widget_id);
		// console.log(image_id_name);

		// Create the media frame.
		var image_frame = wp.media({
			title: 'Select Media',
			multiple : false,
			library : {
				type : 'image',
			}
		});

		image_frame.on('close',function() {
			// On close, get selections and save to the hidden input plus other AJAX stuff to refresh the image preview.
			var selection =  image_frame.state().get('selection');
			var gallery_ids = new Array();
			var my_index = 0;
			selection.each(function(attachment) {
				gallery_ids[my_index] = attachment['id'];
				my_index++;
			});
			var ids = gallery_ids.join(",");
			// console.log(ids);
			$(input_element).val(ids);

			refresh_image(ids, image_element_id);

			$(input_element).trigger('change');
		});

		image_frame.on('open',function() {
			// On open, get the id from the hidden input and select the appropiate images in the media manager.
			var selection =  image_frame.state().get('selection');
			ids = $('input.rcps_image_id').val().split(',');
			ids.forEach(function(id) {
				attachment = wp.media.attachment(id);
				attachment.fetch();
				selection.add( attachment ? [ attachment ] : [] );
			});
		});

		// Finally, open the modal
		image_frame.open();
	});
});

// Ajax request to refresh the image preview.
function refresh_image(the_id, image_element_id){
	var data = {
		action: 'rcps_get_widget_image',
		id: the_id,
		image_element_id: image_element_id
	};

	jQuery.get(ajaxurl, data, function(response) {
		if(response.success === true) {
			// console.log(response.data.image);
			jQuery('#'+image_element_id).replaceWith( response.data.image );
		}
	});
}

// Colorpicker
// https://gist.github.com/rodica-andronache/54f3ea95bcaf76435e55
( function( $ ){
	function initColorPicker( widget ) {
		widget.find( '.rcps-colorpicker' ).wpColorPicker( {
			change: function(e, ui) {
				$(e.target).val(ui.color.toString());
				$(e.target).trigger('change');
			},
			clear: function(e, ui) {
				$(e.target).trigger('change');
			},
		});
	}

	function onFormUpdate( event, widget ) {
		initColorPicker( widget );
	}

	$( document ).on( 'widget-added widget-updated', onFormUpdate );

	$( document ).ready( function() {
		$( '#widgets-right .widget:has(.rcps-colorpicker)' ).each( function () {
			initColorPicker( $( this ) );
		} );
	} );
}( jQuery ) );
