<?php

namespace wpcl\wpconsole;

class Console {
	/**
	 * Log an item
	 *
	 * Saves an item to a transient, for later printing to the browser console
	 * Useful for saving and displaying ajax items
	 *
	 * @param  mixed $item : Whatever needs printed to the console
	 * @return void
	 * @since 1.0.0
	 */
	public static function log( $item ) {
		/**
		 * 1. Get the log
		 */
		$log = self::getLog();
		/**
		 * 2. Add our saved item
		 */
		$log[] = $item;
		/**
		 * 3. Update the log for 24 hours
		 */
		set_transient( __CLASS__ . '_log', $log, 60*60*24 );
		/**
		 * Add the action to the shutdown event
		 */
		if ( !has_action( 'shutdown', [__CLASS__, 'printLog'] ) ) {
			add_action( 'shutdown', [__CLASS__, 'printLog'] );
		}
	}
	/**
	 * Get the log from a wp transient
	 *
	 * @return array $log : array of saved log items
	 * @since 1.0.0
	 */
	public static function getLog() {
		/**
		 * 1. Get the log transient, or false
		 */
		$log = get_transient( __CLASS__ . '_log' );
		/**
		 * 2. Ensure we have an array
		 */
		$log = is_array( $log ) ? $log : [];
		/**
		 * Return the log
		 */
		return $log;
	}
	/**
	 * Get the log an dprint to console
	 *
	 * Attached to the shutdown event
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function printLog() {
		/**
		 * 1. Get the log
		 */
		$log = self::getLog();
		/**
		 * 2. Loop over the log and print
		 */
		foreach ( $log as $item ) {
			self::print( $item, current_filter() );
		}
		/**
		 * 3. Clear the log
		 */
		delete_transient( __CLASS__ . '_log' );
	}
	/**
	 * Print log to console
	 *
	 * Use an anon function to print a json representation of the provided
	 * object to browser console
	 *
	 * @param  mixed $item : Whatever needs printed to the console
	 * @param  string $action : WordPress action to attach the function to
	 * @return void
	 */
	public static function print( $item = [], $action = 'shutdown' ) {
		add_action( $action, function() use( $item ) {
			printf( '<script>console.log(%s);</script>', json_encode( $item, JSON_PARTIAL_OUTPUT_ON_ERROR, JSON_PRETTY_PRINT ) );
		}, 9999 );
	}
}