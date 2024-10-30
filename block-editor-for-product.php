<?php
/**
 * Block Editor for Product
 *
 * Plugin Name: Block Editor for Product
 * Description: Simple toolkit to enable Block Editor ( Gutenberg ) for WooCommerce product edit page.
 * Version:     1.0.2
 * Author:      Khokan Sardar
 * Author URI:  https://github.com/itzmekhokan/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: block-editor-product
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 5.6 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

if ( ! class_exists( 'Block_Editor_WC_Product' ) ) :

    class Block_Editor_WC_Product {

        private function __construct() {}

        public static function init() {

            // If plugin - 'WooCommerce' not exist then return.
            if ( ! class_exists( 'WooCommerce' ) ) {
                return;
            }

            add_filter( 'gutenberg_can_edit_post_type', array( __CLASS__, 'gutenberg_can_edit_product' ), 10, 2 );
            add_filter( 'use_block_editor_for_post_type', array( __CLASS__, 'gutenberg_can_edit_product' ), 10, 2 );

            add_filter( 'woocommerce_taxonomy_args_product_cat', array( __CLASS__, 'enable_taxonomy_rest_args' ) );
            add_filter( 'woocommerce_taxonomy_args_product_tag', array( __CLASS__, 'enable_taxonomy_rest_args' ) );
        }

        /**
         * Enable Gutenberg for products.
         *
         * @param bool   $can_edit Whether the post type can be edited or not.
         * @param string $post_type The post type being checked.
         * @return bool
         */
        public static function gutenberg_can_edit_product( $can_edit, $post_type ) {
            return 'product' === $post_type ? true : $can_edit;
        }

        /**
         * Enable Rest args Taxonomy for products if gutenberg is active.
         *
         * @param bool   $args Taxonomy arguments.
         * @return array
         */
        public static function enable_taxonomy_rest_args( $args ) {
            $args['show_in_rest'] = true;
            return $args;
        }
    }

    add_action( 'plugins_loaded', array( 'Block_Editor_WC_Product', 'init' ) );

endif;