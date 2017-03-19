<?php

/**
 * Load a template part into a template
 *
 * Makes it easy for a theme to reuse sections of code in a easy to overload way
 * for child themes.
 *
 * Includes the named template part for a theme or if a name is specified then a
 * specialised part will be included. If the theme contains no {slug}.php file
 * then no template will be included.
 *
 * The template is included using require, not require_once, so you may include the
 * same template part multiple times.
 *
 * For the $name parameter, if the file is called "{slug}-special.php" then specify
 * "special".
 *
 * @since 1.0.0
 *
 * @param string $slug The slug name for the generic template.
 * @param string $name The name of the specialised template.
 */
function _s_get_template_part( $slug, $name = null ) {

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates[] = "{$slug}-{$name}.php";

	$templates[] = "{$slug}.php";

	if ( true === apply_filters( '_s_load_template_part', true, $slug, $name, $templates ) ) {

		/**
		 * Fires before the specified template part file is loaded.
		 *
		 * The dynamic portion of the hook name, `$slug`, refers to the slug name
		 * for the generic template part.
		 *
		 * @since 1.0.0
		 *
		 * @param string      $slug     The slug name for the generic template.
		 * @param string|null $name     The name of the specialized template.
		 * @param array       $templates Template file(s) to search for, in order.
		 */
		do_action( "_s_before_get_template_part", $slug, $name, $templates );

		$located_template = locate_template( $templates, true, false );

		/**
		 * Fires after the specified template part file is loaded.
		 *
		 * The dynamic portion of the hook name, `$slug`, refers to the slug name
		 * for the generic template part.
		 *
		 * @since 1.0.0
		 *
		 * @param string      $slug             The slug name for the generic template.
		 * @param string|null $name             The name of the specialized template.
		 * @param array       $templates        Template file(s) to search for, in order.
		 * @param string      $located_template The template filename if one is located.
		 */
		do_action( "_s_after_get_template_part_{$slug}", $slug, $name, $templates, $located_template );

		/**
		 * Fires after the specified template part file is loaded.
		 *
		 * @since 1.0.0
		 *
		 * @param string      $slug             The slug name for the generic template.
		 * @param string|null $name             The name of the specialized template.
		 * @param array       $templates        Template file(s) to search for, in order.
		 * @param string      $located_template The template filename if one is located.
		 */
		do_action( "_s_after_get_template_part", $slug, $name, $templates, $located_template );
	}
}