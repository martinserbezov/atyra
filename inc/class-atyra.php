<?php
/**
 * Atyra Class
 *
 * @author Martin Serbezov
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Atyra' ) ) {

	class Atyra {

		public function __construct() {
		 	add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 1000 );
			add_action( 'init', array( $this, 'edit_storefront_template' ) );
		 	add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ),	1000 );
			add_filter( 'storefront_setting_default_values', array( $this, 'get_atyra_defaults' ) );
		}

		public function enqueue_styles() {
			wp_dequeue_style( 'storefront-fonts' );
			wp_enqueue_style( 'atyra-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap' );
		}
		
		public function edit_storefront_template() {
			remove_action( 'storefront_header', 'storefront_secondary_navigation',  30 );
			add_action( 'storefront_header', 'storefront_secondary_navigation',  15 );
			remove_action( 'storefront_header', 'storefront_product_search',  40 );
			add_action( 'storefront_header', 'storefront_product_search', 30 );
			remove_action( 'storefront_header', 'storefront_header_cart',  60 );
			add_action( 'storefront_header', 'storefront_header_cart', 40 );
		}
   	
		public function get_atyra_defaults() {
			return apply_filters( 'atyra_default_settings', $args = array(
				'storefront_heading_color'			=> '#000000',
				'storefront_text_color'			=> '#4d4d4d',
				'storefront_accent_color'			=> '#e74c3c',
				'storefront_hero_heading_color'		=> '#000000',
				'storefront_hero_text_color'			=> '#000000',
				'storefront_header_background_color'		=> '#ffffff',
				'storefront_header_text_color'		=> '#4d4d4d',
				'storefront_header_link_color'		=> '#000000',
				'storefront_footer_background_color'		=> '#f2f2f2',
				'storefront_footer_heading_color'		=> '#000000',
				'storefront_footer_text_color'		=> '#4d4d4d',
				'storefront_footer_link_color'		=> '#000000',
				'storefront_button_background_color'		=> '#000000',
				'storefront_button_text_color'		=> '#ffffff',
				'storefront_button_alt_background_color'	=> '#e74c3c',
				'storefront_button_alt_text_color'		=> '#ffffff',
				'storefront_layout'				=> 'left',
				'background_color'				=> '#ffffff',
			) );
		}	

		public function add_customizer_css() {
			$background_color					= get_theme_mod( 'background_color' );
			$storefront_button_alt_text_color			= get_theme_mod( 'storefront_button_alt_text_color' );
			$storefront_button_alt_background_color		= get_theme_mod( 'storefront_button_alt_background_color' );
			$storefront_heading_color				= get_theme_mod( 'storefront_heading_color' );
			$storefront_accent_color				= get_theme_mod( 'storefront_accent_color' );

			$style = '
				.storefront-primary-navigation .col-full::after,
				.header-widget-region .col-full::after,
				.main-navigation ul.menu ul.sub-menu, 
				.main-navigation ul.nav-menu ul.children,
				.main-navigation ul ul li,
				.main-navigation ul li a, 
				.main-navigation li:first-child a:not(.sub-menu li:first-child a),
				.secondary-navigation ul ul li,
				.storefront-secondary-navigation.woocommerce-active .site-header .secondary-navigation,
				.site-header-cart .widget_shopping_cart,
				.woocommerce-tabs ul.tabs,
				.woocommerce-tabs ul.tabs li,
				.widget .widget-title, 
				.widget .widgettitle,
				.footer-widgets,
				.hentry .entry-content .woocommerce-MyAccount-navigation ul,
				.hentry .entry-content .woocommerce-MyAccount-navigation ul li {
					border-color: ' . storefront_adjust_color_brightness( $background_color, -25 ) . ';
				}
				.wc-block-grid__product-onsale,
				ul.products li.product .onsale,
				.onsale {
					color: ' . $storefront_button_alt_text_color . ';
					background: ' . $storefront_accent_color . ';
					border-color: ' . $storefront_accent_color . ';
				}
				.price ins,
				.woocommerce-grouped-product-list-item__price ins {
					color: ' . $storefront_accent_color . ';
				}
				ul.products li.product .price,
				.single-product div.product .price,
				.site-branding .site-title a,
				.site-branding .site-description,
				.widget .widget-title, 
				.widget .widgettitle,
				.woocommerce-breadcrumb a, 
				a.woocommerce-review-link, 
				.product_meta a,
				.woocommerce-tabs ul.tabs li a,
				a.remove::before,
				.woocommerce-cart-form__cart-item a,
				.hentry .entry-content .woocommerce-cart-form__cart-item,
				.site-header .widget_shopping_cart p.total,
				.secondary-navigation ul.menu a,
				.woocommerce-MyAccount-navigation ul li a,
				.widget-area .widget a:hover,
				ul.menu li.current-menu-item > a,
				.widget_categories ul li.current-cat a,
				.widget_layered_nav .chosen a {
					color: ' . $storefront_heading_color . ';
				}
				';

			wp_add_inline_style( 'storefront-child-style', $style );
		}	
	
	}

}

return new Atyra();
