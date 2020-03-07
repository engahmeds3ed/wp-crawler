<?php if ( $data['links'] ) { ?>
<table class="<?php echo ! empty( $data['classes'] ) ? esc_attr( $data['classes'] ) : ''; ?>">
	<tbody>
	<?php foreach ( $data['links'] as $rocket_link ) { ?>
	<tr>
		<td><a href="<?php echo esc_url( $rocket_link['url'] ); ?>" target="_blank"><?php echo esc_attr( $rocket_link['text'] ); ?></a></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
