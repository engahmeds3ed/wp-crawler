<div class="wrap">
	<h2><?php esc_attr_e( 'ASA Crawler', 'rocket' ); ?></h2>
	<?php do_action( 'asa_crawler_before_settings_form' ); ?>

	<form method="post" id="mainform" action="">
		<input type="hidden" name="action" value="crawl_now">

		<p class="submit"><input type="submit" class="button-primary" value="<?php esc_attr_e( 'Crawl Homepage Now', 'rocket' ); ?>"/></p>
	</form>
</div>
