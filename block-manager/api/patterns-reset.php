<?php
/**
 * API Route: Reset patterns API endpoint.
 *
 * @since 1.0
 * @package blockmanager
 */

add_action(
	'rest_api_init',
	function () {
		$my_namespace = 'gbm';
		$my_endpoint  = '/patterns_reset';
		register_rest_route(
			$my_namespace,
			$my_endpoint,
			array(
				'methods'             => 'POST',
				'callback'            => 'block_manager_patterns_reset',
				'permission_callback' => function () {
					return Gutenberg_Block_Manager::has_access();
				},
			)
		);
	}
);

/**
 * Reset the block patterns.
 * @since 1.2.2
 */
function block_manager_patterns_reset() {
	if ( is_user_logged_in() && current_user_can( apply_filters( 'block_manager_user_role', 'activate_plugins' ) ) ) {
		error_reporting( E_ALL | E_STRICT ); // @codingStandardsIgnoreLine
		delete_option( BLOCK_MANAGER_PATTERNS );
		wp_send_json(
			[
				'success' => true,
				'msg'     => __( 'All patterns reset successfully', 'block-manager' ),
			]
		);
	}
}
