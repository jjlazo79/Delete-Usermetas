<?php

/**
 * Plugin Name: Delete usermetas
 * Plugin URI: http://joselazo.es/plugins/delete-usermetas
 * Description: This plugin delete any usermeta user by user or all user at same time.
 * Version: 1.1.1
 * Author: Jose Lazo
 * Author URI: http://joselazo.es
 * Requires at least: 4.2
 * Tested up to: 5.8
 *
 * Text Domain: delete-usermetas
 * Domain Path: /languages/
 */
defined( 'ABSPATH' ) or die( 'Bad dog. No biscuit!' );

// First locate
function delumet_translate()
{
	$domain = 'delete-usermetas';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	load_textdomain( $domain, trailingslashit( WP_LANG_DIR) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	load_plugin_textdomain( $domain, FALSE, basename( dirname(__FILE__) ) . '/languages' );
}
add_action( 'init', 'delumet_translate' );

// Second add to admin menu
function delumet_register_options_page()
{
	add_options_page( 'Delete Usermetas', 'Delete Usermetas', 'manage_options', 'delete_usermetas', 'delumet_options_page' );
}
add_action(is_multisite() ? 'network_admin_menu' : 'admin_menu', 'delumet_register_options_page' );

// Thirth enqueue admin script
function delete_usermetas_enqueue_script()
{
	wp_enqueue_script( 'delumet_alert_script', plugin_dir_url(__FILE__) . 'js/alert.js', array( 'jquery' ), '1.0.0', true);
}
add_action( 'admin_enqueue_scripts', 'delete_usermetas_enqueue_script' );

// Core Function to remove values of usermeta
function delumet_remove_metadata( $usermeta, $user_id = false )
{
	if ( $user_id) {
		delete_user_meta( $user_id, $usermeta );
		return $user_id;
	} else {
		$users = get_users();
		foreach ( $users as $user) {
			delete_user_meta( $user->ID, $usermeta );
		}
		return $users;
	}
}

// Functions to sanitize query
function delumet_options_page()
{
	if ( isset( $_POST['send_reset']) ) {
		if ( !empty( $_POST['user_userid']) && !is_numeric( $_POST['user_userid']) ) {
			echo '<div class="notice notice-error"><p>' . __( 'Please, enter a number in User ID field.', 'delete-usermetas' ) . '</p></div>';
			exit;
		} // end if/else numeric
		if ( !$_POST['user_usermeta'] ) {
			echo '<div class="notice notice-error is-dismissible"><p>' . __( 'What about User_meta?', 'delete-usermetas' ) . '</p></div>';
		} else {
			$usermeta   = sanitize_key( $_POST['user_usermeta'] );
			$user_id    = ( is_numeric( $_POST['user_userid']) ) ? $_POST['user_userid'] : false;
			$ouput      = delumet_remove_metadata( $usermeta, $user_id);
			if (is_array( $ouput)) {
				$display = '<div class="notice notice-success is-dismissible"><p>' . __( 'Done it!', 'delete-usermetas' ) . '</p>';
				$display .= '<p>' . __( 'Updated users:', 'delete-usermetas' ) . '</p>';
				foreach ( $ouput as $user) {
					$display .= '<hr>' . __( 'User Name: ', 'delete-usermetas' ) . $user->data->user_nicename . '<br>';
					$display .= __( 'User ID: ', 'delete-usermetas' ) . $user->data->ID . '<br>';
					$display .= __( 'User email: ', 'delete-usermetas' ) . $user->data->user_email . '<br>';
				}
				$display .= '</div>';
			} else {
				$user = get_user_by( 'id', $ouput);
				$display = '<div class="notice notice-success is-dismissible"><p>' . __( 'Done it!', 'delete-usermetas' ) . '</p>';
				$display .= '<p>' . __( 'Updated users:', 'delete-usermetas' ) . '</p>';
				$display .= '<hr>' . __( 'User Name: ', 'delete-usermetas' ) . $user->data->user_nicename . '<br>';
				$display .= __( 'User ID: ', 'delete-usermetas' ) . $user->data->ID . '<br>';
				$display .= __( 'User email: ', 'delete-usermetas' ) . $user->data->user_email . '<br>';
				$display .= '</div>';
			}
			echo $display;
		} // end if/else !$_POST['user_usermeta']
	} // end if (isset( $_POST['send_reset']))
?>

	<!-- Display form -->
	<div class="wrap">
		<h1><?php _e( 'Delete UserMetas', 'delete-usermetas' ); ?></h1>
		<div class="section panel">
			<h3><?php _e( 'This tool is very powerfull! Use it with care', 'delete-usermetas' ); ?></h3>
			<small><?php _e( 'This tool can erase user´s data of <b>ALL</b> the users of the web. The first drop-down is a list of all the metadata that are currently stored on this website. Those preceded by a hyphen under "_" are system data or hidden from the users themselves. Please, do not try to eliminate these.', 'delete-usermetas' ); ?></small>
			<form id="js-reset-usermeta" method="post" enctype="multipart/form-data" action="">
				<table class="form-table">
					<tbody>
						<tr class="">
							<th scope="row">
								<label for="user_usermeta"><?php _e( 'User meta to delete', 'delete-usermetas' ); ?></label>
							</th>
							<td>
								<?php
								global $wpdb;
								$select     = "SELECT distinct $wpdb->usermeta.meta_key FROM $wpdb->usermeta";
								$usermetas  = $wpdb->get_results( $select );

								?>
								<select required class="regular-text" type="text" id="user_usermeta" name="user_usermeta">
									<option value=""><?php _e( 'Select a metadata', 'delete-usermetas' ); ?></option>
									<?php
									foreach ( $usermetas as $usermeta ) {
										if ( substr( $usermeta->meta_key, 0, 1) === "_" ) continue;
										echo '<option value="' . $usermeta->meta_key . '">' . $usermeta->meta_key . '</option>';
									} ?>
								</select>
								<br>
								<span class="description"><?php _e( 'Enter the usermeta to delete e.g. first_name. NOTE: the values of this usermeta will be deleted.', 'delete-usermetas' ); ?></span>
							</td>
						</tr>
						<tr class="">
							<th scope="row">
								<label for="user_userid"><?php _e( 'User ID to delete metadata', 'delete-usermetas' ); ?></label>
							</th>
							<td>
								<input class="regular-text" type="number" id="user_userid" name="user_userid" value="">
								<br>
								<span class="description"><?php _e( 'Enter the user ID to delete the above usermeta. <b>Leave blank </b> to delete the above usermeta to <b>ALL users.</b>', 'delete-usermetas' ); ?></span>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" name="send_reset" value="<?php _e( 'Delete usermeta', 'delete-usermetas' ) ?>" />
				</p>
			</form>
		</div>
	</div>
<?php
}
