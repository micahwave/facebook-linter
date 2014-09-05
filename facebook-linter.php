<?php

/**
 * Plugin Name: Facebook Linter
 * Description: Automatically lints your post anytime it's updated after being published
 * Author: Micah Ernst
 * Version: 0.1
 */

class Facebook_Linter {

	/**
	 * Add a hook for save_post
	 *
	 * @return void
	 */
	function __construct() {
		add_action( 'save_post', array( $this, 'lint_post' ), 10, 2 );
	}

	/**
	 * Call Facebook lint API to re-scrape the post's open graph tags
	 *
	 * @param int $post_id
	 * @param object $post
	 * @return void
	 */
	private function lint_post( $post_id, $post ) {

		// we can't lint a post that cant be seen
		if( 'publish' === $post->post_status )
			wp_remote_post( 'https://graph.facebook.com?scrape=true&id=' . get_permalink( $post ) );
	}
}
new Facebook_Linter();