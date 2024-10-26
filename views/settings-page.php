
<?php $working = onepass_is_set_up() ?>
<div class="wrap onepass-settings">
	<?php if( isset($_GET['settings-updated']) ) : ?>
		<div class="notice updated inline">
			<p><strong><?php _e('Settings saved.') ?></strong></p>
		</div>
	<?php endif; ?>
	<div class="onepass-settings-block lead">
		<h2>1Pass for WordPress</h2>
		<?php if ( $working ) : ?>
			<p>&#x2713; Setup complete</p>
			<p><strong>Congratulations!</strong></p>
		<?php else : ?>
			<p>Enter your API keys below to finish installing the plugin</p>
		<?php endif; ?>
	</div>

	<?php if( $working ) : ?>
		<div class="onepass-settings-block api-keys <?php echo $working ? 'ok' : null; ?>">
			<p>A 1Pass 'buy' button will now appear wherever you put a WordPress 'Read More...' tag into a post.</p>
			<img src="<?php echo ONEPASS_PLUGIN_URL . 'img/read-more-tag.png'; ?>" alt="Read more tag" />
		</div>
	<?php else : ?>
		<div class="onepass-settings-block quick-config">
			<h2>To finish...</h2>
			<h4>1. Copy your API keys from <a href="<?php echo onepass_get_onepass_domain(); ?>/publisher-signup" target="_blank">your settings page at http://1pass.me</a>.</h4>
			<h4>2. Paste your keys into the box below and click “Continue”</h4>

			<form id="onepass-quick-input-keys">
				<table class="form-table api-keys">
					<tbody>
						<tr>
							<th scope="row">Your keys:</th>
							<td>
								<div class="onepass-credentials">
	    							<input type="text" class="large-text" id="api-keys-combined" value="">
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Continue"></p>
			</form>
		</div>
	<?php endif; ?>

    <form action='options.php' id="api-keys-form" method='post' class="<?php echo $working ? 'show' : ''; ?>">
		<div class="onepass-settings-block api-keys">
			<h2 id="api-keys-toggle" class="toggle">API keys</h2>
			<div id="api-keys">
		        <?php settings_fields( 'onepass' );
		        do_settings_sections( 'default' );
		        do_settings_sections( 'onepass_settings_page' );
				submit_button( 'Save', 'primary', 'save' );
				?>
			</div>
		</div>
	</form>
	<form action='options.php' method='post'>
		<div class="onepass-settings-block minor">
			<h2 id="advanced-options-toggle" class="toggle">Advanced options</h2>
			<div id="advanced-options">
				<?php settings_fields( 'onepass_options' );
		        do_settings_sections( 'default' );
		        do_settings_sections( 'onepass_settings_options' );
				submit_button( 'Save' );
		        ?>
			</div>
		</div>
	</form>

    <p class="description">1Pass WordPress plugin v<?php echo ONEPASS_PLUGIN_VERSION; ?></p>
</div>
