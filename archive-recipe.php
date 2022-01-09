<?php
/**
 * Archive-recipe.php
 *
 * @package Recipes WordPress Theme
 */

get_header(); ?>

<?php get_template_part( 'templates/template', 'filters' ); ?>

<?php get_template_part( 'templates/template', 'recipe-grid' ); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
