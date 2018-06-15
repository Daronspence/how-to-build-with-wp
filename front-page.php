<?php
/**
 * Home Template File
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$context = Timber::get_context();

$templates = array( 'front-page.twig' );

Timber::render( $templates, $context );