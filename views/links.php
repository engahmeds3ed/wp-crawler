<?php if ( $data['links'] ) { ?>
	<h3><?php esc_attr_e( 'Kindly find below links found on Homepage.', 'rocket' ); ?></h3>
<table class="wp-list-table widefat fixed striped posts">
	<tbody>
	<?php foreach ( $data['links'] as $link ) { ?>
	<tr>
		<td><a href="<?php echo $link['url']; ?>" target="_blank"><?php echo $link['text']; ?></a></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
