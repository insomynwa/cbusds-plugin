<div class="wrap">
	<div class="w3-accordion w3-light-grey">
		<button class="w3-btn-block w3-left-align btn-accordion w3-orange">Pengaturan Konten</button>
		<div id="pengaturan-konten" class="w3-accordion-content w3-container">
			<form action="options.php" method="post" class="w3-container">
				<?php settings_fields('cbus_dsc_option_group');
				do_settings_sections('cbus_dsc');
				submit_button('Save');
				?>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {

		$(".btn-accordion").click( function (e) {
			var content = $(this).next();
			if( ! content.hasClass("w3-show") ) {
				content.addClass("w3-show");
			}else {
				content.removeClass("w3-show");
			}
		});

	});
</script>