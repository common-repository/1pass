<?php $option = get_option( $key );?>
<input type='checkbox' name='<?php echo $key; ?>' <?php checked( $option, 'on' ); ?>>
