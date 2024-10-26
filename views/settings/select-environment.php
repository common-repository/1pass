<?php $option = get_option( 'onepass_environment' );?>
<p>
    <?php $othermode = array_diff( ['test', 'live'], [$option] ); ?>
    <?php $othermode = reset( $othermode ); ?>
    <button class="button button-secondary" onclick="jQuery('#onepass_environment').val('<?php echo $othermode; ?>').closest('form').submit()">Switch to <?php echo $othermode; ?> mode</button>
</p>
<input type="hidden" id="onepass_environment" name="onepass_environment" value="<?php echo $option; ?>" />
