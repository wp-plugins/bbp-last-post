<?php

//this function changes the bbp freshness data (time since) into a last post date for forums
function change_freshness_forum () {

// Verify forum and get last active meta
		$forum_id    = bbp_get_forum_id( $forum_id );
		$last_active = get_post_meta( $forum_id, '_bbp_last_active_time', true );

		if ( empty( $last_active ) ) {
			$reply_id = bbp_get_forum_last_reply_id( $forum_id );
			if ( !empty( $reply_id ) ) {
				$last_active = get_post_field( 'post_date', $reply_id );
			} else {
				$topic_id = bbp_get_forum_last_topic_id( $forum_id );
				if ( !empty( $topic_id ) ) {
					$last_active = bbp_get_topic_last_active_time( $topic_id );
				}
			}
		}

		$last_active = bbp_convert_date( $last_active ) ;
		$date_format = get_option( 'date_format' );
		$time_format = get_option( 'time_format' );
		$date= date( "{$date_format}", $last_active );
		$time=date( "{$time_format}", $last_active );
		$active_time = sprintf( _x( '%1$s at %2$s', 'date at time', 'bbpress' ), $date, $time );  
		return $active_time ;
		}
add_filter( 'bbp_get_forum_last_active', 'change_freshness_forum', 10, 2 );

//this function changes the bbp freshness data (time since) into a last post date for topics
function change_freshness_topic ($last_active, $topic_id) {

$topic_id = bbp_get_topic_id( $topic_id );

		// Try to get the most accurate freshness time possible
		$last_active = get_post_meta( $topic_id, '_bbp_last_active_time', true );
		if ( empty( $last_active ) ) {
		$reply_id = bbp_get_topic_last_reply_id( $topic_id );
		if ( !empty( $reply_id ) ) {
			$last_active = get_post_field( 'post_date', $reply_id );
		} else {
				$last_active = get_post_field( 'post_date', $topic_id );
			}
		}
		
		
		$last_active = bbp_convert_date( $last_active ) ;
		$date_format = get_option( 'date_format' );
		$time_format = get_option( 'time_format' );
		$date= date( "{$date_format}", $last_active );
		$time=date( "{$time_format}", $last_active );
		$active_time = sprintf( _x( '%1$s at %2$s', 'date at time', 'bbpress' ), $date, $time );  
		return $active_time ;
		}
add_filter( 'bbp_get_topic_last_active', 'change_freshness_topic', 10, 2 );

//This function changes the heading "Freshness" to the name created in Settings>bbp last post
function change_translate_text( $translated_text ) {
	if ( $translated_text == 'Freshness' ) {
	global $rlp_options;
	$translated_text = $rlp_options['heading_label'];
	}
	return $translated_text;
}
add_filter( 'gettext', 'change_translate_text', 20 );

