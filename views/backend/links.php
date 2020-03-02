<?php if ( $data['links'] ) { ?>
	<h3><?php esc_attr_e( 'Kindly find below internal links found on Homepage.', 'rocket' ); ?></h3>
<table class="wp-list-table widefat fixed striped posts">
	<tbody>
	<?php foreach ( $data['links'] as $rocket_link ) { ?>
	<tr>
		<td><a href="<?php echo esc_url( $rocket_link['url'] ); ?>" target="_blank"><?php echo esc_attr( $rocket_link['text'] ); ?></a></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
