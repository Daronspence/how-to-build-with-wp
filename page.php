<?php
/**
 * Home Template File
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$context = Timber::get_context();
$context['post'] = Timber::get_post();

$templates = array( 'page.twig' );

Timber::render( $templates, $context );