<?php

class S_Debugging {

	public function __construct() {
		if ( true === $this->_enabled() ) {
			add_action( '_s_before_get_template_part', array( $this, 'before_get_template_part' ), 10, 4 );
			add_action( '_s_after_get_template_part', array( $this, 'after_get_template_part' ), 10, 4 );
			add_action( '_s_template_not_loaded', array( $this, 'template_not_loaded' ), 10, 4 );
		}
	}

	private function _enabled() {
		return ( true === isset( $_GET['debug'] ) && 'true' === $_GET['debug'] );
	}

	private function template_loaded( $located_template ) {
		return ( '' != $located_template );
	}

	private function debug_loaded( $located_template, $before ) {
		$located_template = str_replace( ABSPATH, '', $located_template );
		echo PHP_EOL;
		if ( true === $before ) {
			printf( '<!-- Following code is located in %s -->', esc_html( $located_template ) );
		} else {
			printf( '<!-- End of code located in %s -->', esc_html( $located_template ) );
		}
		echo PHP_EOL;
	}

	private function debug_not_found( $slug, $name ) {
		echo PHP_EOL;
		printf( '<!-- Requested template was not found. Slug: %s , name: %s -->', esc_html( $slug ), esc_html( $name ) );
		echo PHP_EOL;
	}

	public function before_get_template_part( $slug, $name, $templates, $located_template = null ) {
		if ( null !== $located_template && $this->template_loaded( $located_template ) ) {
			$this->debug_loaded( $located_template, true );
		}
	}

	public function after_get_template_part( $slug, $name, $templates, $located_template ) {
		if ( $this->template_loaded( $located_template ) ) {
			$this->debug_loaded( $located_template, false );
		}
	}

	public function template_not_loaded( $slug, $name, $templates, $located_template ) {
		$this->debug_not_found( $slug, $name );
	}
}

$debugging = new S_Debugging();