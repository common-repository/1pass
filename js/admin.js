(function($) {
  $(document).ready(function(){
		onePassMakeToggle('#advanced-options');
		onePassMakeToggle('#api-keys');

		$('#onepass-quick-input-keys').submit(function(e) {
			e.preventDefault();
			var keys = $('#api-keys-combined', this).val().split(':')
			if( keys ) {
				var publishableField = $('input[type="text"]').filter(function() {
					return this.name.match(/publishable/);
				});
				var secretField = $('input[type="text"]').filter(function() {
					return this.name.match(/secret/);
				});
				// Keys[] should have two parts
				if( publishableField.length && secretField.length && (keys.length == 2) ) {
					$(publishableField).val(keys[0]);
					$(secretField).val(keys[1]);
					$('#api-keys-form').submit();
				}
			}
			return false;
		});
  });

	function onePassMakeToggle(id) {
		$(id+'-toggle').click(function() {
			var panel = $(id).toggle();
			$(this).toggleClass('opened', panel.is(':visible'));
		});
	}
})(jQuery);
