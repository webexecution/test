/**
 * Created by shramee on 6/10/15.
 */
jQuery(function($, undef){
	var api = wp.customize;

	api.lib_alpha_color_control = api.Control.extend({
		ready: function() {
			var control = this,
				picker = this.container.find('.color-picker-hex');

			picker.val( control.setting() ).libColorPicker({
				change: function() {
					try {
						try {
							control.setting.set( picker.libColorPicker('color') );
						}
						catch (e) {
							console.log(e); // pass exception object to error handler
						}
					} catch ( e ) {}
				},
				clear: function() {
					control.setting.set( '' );
				}
			});

			control.setting.bind( function( value ) {
				picker.val( value );
				picker.libColorPicker( 'color', value );
			});
		}
	});

	api.controlConstructor['lib_color'] = api.lib_alpha_color_control;
});