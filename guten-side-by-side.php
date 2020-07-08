<?php
/**
 * Plugin Name: Guten Side By Side.
 * Description: Gutenberg isn't WYSIWYG. but with this plugin, you can see a side-by-side of the frontend right beside gutenberg.
 * Author: Phil Johnston
 * Version: 1.0.0
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package GUTEN SIDE BY SIDE
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add an "Edit side by side" option to each page and post.
 *
 * @param  array   $actions The list of actions to be shown with each page and post in wp-admin.
 * @param  WP_Post $post The post object.
 * @return array   $actions
 */
function gutensidebyside_modify_list_row_actions( $actions, $post ) {

	$actions['gutensidebyside'] = '<a href="' . esc_url( admin_url( 'post.php?post=' . $post->ID . '&action=edit&gutensidebyside' ) ) . '">' . __( 'Edit Side By Side', 'gutensidebyside' ) . '</a>';	
	return $actions;
}
add_filter( 'post_row_actions', 'gutensidebyside_modify_list_row_actions', 10, 2 );
add_filter( 'page_row_actions', 'gutensidebyside_modify_list_row_actions', 10, 2 );

/**
 * The page where you see them side by side.
 *
 * @return void
 */
function gutensidebyside_view() {

	if ( ! isset( $_GET['gutensidebyside'] ) ) {
		return;
	}

	if ( ! isset( $_GET['post'] ) ) {
		return;
	}

	$post_id = absint( $_GET['post'] );

	?>
	<!doctype html>
		<html lang="en">
		<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Side By Side</title>
		<meta name="theme-color" content="#563d7c">
		<style>
			body{
				margin: 0px;
				padding: 0px;
				width: 100%;
				height: 100%;
				background-color: #222222;
				background: linear-gradient(130deg, #3c91e7 0, #78378c 100%);
				color: #FFFFFF;;
				position: fixed;
				display: grid;
				font-family: sans-serif;
				overflow:scroll;
			}
			#gutensidebyside-container{
			width:100%;
				display:grid;
				grid-auto-columns: 50% 50%;
				height:100%;
			}
			#gutensidebyside-container > * > * {
				width: 100%;
				height:100%;
			}
			#gutensidebyside-admin {
				grid-column: 1;
				height:100%;
			}
			#gutensidebyside-frontend {
				grid-column: 2;
				height:100%;
			}
		</style>
		</head>
		<body>
			<div id="gutensidebyside-container">
				<div id="gutensidebyside-admin">
					<iframe src="<?php echo esc_url( admin_url( 'post.php?post=' . $post_id . '&action=edit' ) ); ?>"></iframe>
				</div>
				<div id="gutensidebyside-frontend">
					<iframe src="<?php echo esc_url( get_permalink( $post_id ) ); ?>"></iframe>
				</div>
			</div>	
		</body>
	</html>
	<?php
	exit;
}
add_action( 'init', 'gutensidebyside_view' );
