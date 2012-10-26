<?php
// Activating plugin
register_activation_hook(__FILE__, 'supersized_activate');

function supersized_activate() {
    add_option('supersized_autoplay', '1');
}

register_deactivation_hook( __FILE__, 'supersized_deactivate' );
function supersized_deactivate() {
	delete_option('supersized_autoplay');
}

add_action('admin_menu', 'supersized_menu');
function supersized_menu() {
	add_options_page('Supersized Plugin Options', 'Supersized', 'manage_options', 'supersized_options', 'supersized_page_content');
}

function supersized_page_content() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('Sorry. You do not have permission to access this page.') );
	}
?>
<div class="icon32" id="icon-options-general"><br /></div>
<h2><?php _e('Supersized Background Settings'); ?></h2>
<form action="options.php" method="post">
	<?php wp_nonce_field('update-options'); ?>
	<fieldset>
		<label>Autoplay</label>
		<input type="checkbox" value="1" id="supersized_autoplay" name="supersized_autoplay" <?php if(get_option('supersized_autoplay') == 1) echo 'checked="true"'; ?>  />
	</fieldset>
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="supersized_autoplay" />
	<input type="submit" value="<?php esc_attr_e('Save Changes') ?>" class="button-primary" id="save" name="save">
</form>
<?php
}
?>