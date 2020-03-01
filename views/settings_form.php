<div class="wrap">
	<h2><?php _e( 'ASA Crawler', 'asa-crawler' ); ?></h2>
	<?php do_action("asa_crawler_before_settings_form"); ?>

	<form method="post" id="mainform" action="">
		<input type="hidden" name="action" value="crawl_now">

		<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Crawl Homepage Now', 'asa-crawler');?>"/></p>
	</form>
</div>
