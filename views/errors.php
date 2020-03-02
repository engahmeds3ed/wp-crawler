<div class="notice notice-error">
	<?php foreach ( $data['rocket_errors'] as $rocket_error ) { ?>
	<p><?php esc_attr_e( $rocket_error ); ?></p>
	<?php } ?>
</div>
