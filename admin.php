<?php
// Activating plugin
register_activation_hook(__FILE__, 'supersized_activate');

function supersized_activate() {
    add_option('supersized_autoplay', '1');
	add_option('supersized_navigation', '1');
}

//Deactivating plugin
register_deactivation_hook( __FILE__, 'supersized_deactivate' );
function supersized_deactivate() {
	delete_option('supersized_autoplay');
	delete_option('supersized_navigation');
}

//Post type for supersized images
add_action('init', 'supersized_custom_init');

function supersized_custom_init() {
    $labels = array(
        'name' => _x('Supersized', 'post type general name'),
        'singular_name' => _x('Supersized', 'post type singular name'),
        'add_new' => _x('Add New', 'supersized'),
        'add_new_item' => __('Add New Background Image'),
        'edit_item' => __('Edit Background Image'),
        'new_item' => __('New Background Image'),
        'view_item' => __('View Background Image'),
        'search_items' => __('Search Background Image'),
        'not_found' => __('No Background Image found'),
        'not_found_in_trash' => __('No Background Images found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Supersized'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 20,
        'supports' => array('title', 'editor', 'thumbnail')
    );
    register_post_type('supersized', $args);
}

//Settings menu item
add_action('admin_menu', 'supersized_menu');
function supersized_menu() {
	add_options_page('Supersized Plugin Options', 'Supersized', 'manage_options', 'supersized_options', 'supersized_page_content');
}

//Form for plugin settings
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
		<div class="input">
			<label>Autoplay</label>
			<input type="checkbox" value="1" id="supersized_autoplay" name="supersized_autoplay" <?php if(get_option('supersized_autoplay') == 1) echo 'checked="true"'; ?>  />
		</div>
		<div class="input">
			<label>Show navigation</label>
			<input type="checkbox" value="1" id="supersized_navigation" name="supersized_navigation" <?php if(get_option('supersized_navigation') == 1) echo 'checked="true"'; ?>  />
		</div>
	</fieldset>
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="supersized_autoplay, supersized_navigation" />
	<input type="submit" value="<?php esc_attr_e('Save Changes') ?>" class="button-primary" id="save" name="save">
</form>
<?php
}
?>