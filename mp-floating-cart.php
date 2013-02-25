<?php
/*
Plugin Name: MP Floating Cart
Plugin URI: http://www.smashingadvantage.com
Description: A shopping cart that hovers or "floats" above your MarketPress site.
Author: Nathan Onn (MarketPressThemes.com)
Version: 1.0.0
Author URI: http://www.smashingadvantage.com

Copyright 2012 - 2013 Smashing Advantage Enterprise.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

	class MPFloatingCart {

	    private $plugin_path;
	    private $plugin_url;
	    private $l10n;
	    private $floatcart;

	    function __construct() 
	    {	
	        $this->plugin_path = plugin_dir_path( __FILE__ );
	        $this->plugin_url = plugin_dir_url( __FILE__ );
	        $this->l10n = 'floating-cart';
	        add_action( 'admin_menu', array(&$this, 'admin_menu'), 99 );
	        
	        // Include and create a new FloatCartSettingsFramework
	        require_once( $this->plugin_path .'settings.php' );
	        $this->floatcart = new FloatCartSettingsFramework( $this->plugin_path .'inc/fc-settings.php' );
	        // Add an optional settings validation filter (recommended)
	        add_filter( $this->floatcart->get_option_group() .'_settings_validate', array(&$this, 'fc_validate_settings') );

	        // register related CSS & JS
			add_action('wp_enqueue_scripts', array(&$this, 'register_related_css_style') , 9999);
			add_action('wp_enqueue_scripts', array(&$this, 'register_related_js'));

			// add action to wp_head
			add_action('wp_head' , array(&$this, 'floating_cart_postion') );

			// add action to wp_footer
			add_action('wp_footer' , array(&$this, 'mp_floating_shopping_cart') );

		  	//updater
		  	add_action( 'init', array(&$this, 'floating_cart_plugin_updater_init') );

	    }
	    
	    function admin_menu()
	    {
	        add_submenu_page( 'edit.php?post_type=product', __( 'Floating Cart', $this->l10n ), __( 'Floating Cart', $this->l10n ), 'manage_options', 'mpt-floating-cart', array(&$this, 'settings_page') );
	    }
	    
	    function settings_page()
		{
		    // Your settings page
		    ?>
			<div class="wrap">
				<div id="icon-options-general" class="icon32"></div>
				<h2>Floating Cart</h2>
				<?php 
				// Output your settings form
				$this->floatcart->settings(); 
				?>
			</div>
			<?php
			
			// Get settings
			//$settings = wpsf_get_settings( $this->plugin_path .'inc/fc-settings.php' );
			//echo '<pre>'.print_r($settings,true).'</pre>';
			
			// Get individual setting
			//$setting = wpsf_get_setting( wpsf_get_option_group( $this->plugin_path .'inc/fc-settings.php' ), 'general', 'text' );
			//var_dump($setting);
		}
		
		function fc_validate_settings( $input )
		{
		    // Do your settings validation here
		    // Same as $sanitize_callback from http://codex.wordpress.org/Function_Reference/register_setting
	    	return $input;
		}

	    // register bootstrap CSS
		function register_bootstrap_css_style() {
			$current_theme = wp_get_theme();

			switch ($current_theme->Template) {
				case 'flexmarket':
					break;

				case 'pro':
					break;
				
				default:
					wp_enqueue_style('bootstrap-css', $this->plugin_url . 'css/bootstrap.min.css', null, null);
					break;
			}
		}

		// register CSS 
		function register_related_css_style() {
			wp_enqueue_style('floating-cart-css', plugin_dir_url( __FILE__ ) . 'css/floating-cart-style.css', null, null);
		}

		// register JS
		function register_related_js() {
			wp_enqueue_script('bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array('jquery'));
		}

		function floating_cart_postion() {

			$settings = wpsf_get_settings( plugin_dir_path( __FILE__ ) .'inc/fc-settings.php' );

			$position = esc_attr($settings['fcsettings_general_button_position']);

			$enablefc = esc_attr($settings['fcsettings_general_enable_floating_cart']);

			if ($enablefc == 'yes') {

				?>

				<style type="text/css" media="all">

				<?php if ($position == 'top-left') { ?>

					.floating-cart button {
						position:fixed;
						top: 5%;
						right:auto;
						left: 0px;
						z-index: 1050;
						-webkit-border-top-left-radius: 0px;
						border-top-left-radius: 0px;
						-webkit-border-bottom-left-radius: 0px;
						border-bottom-left-radius: 0px;
						-webkit-border-top-right-radius: 4px;
						border-top-right-radius: 4px;
						-webkit-border-bottom-right-radius: 4px;
						border-bottom-right-radius: 4px;
					}

				<?php } ?>

				<?php if ($position == 'top-right') { ?>

					.floating-cart button {
						position:fixed;
						top: 5%;
						right:0px;
						z-index: 1050;
						-webkit-border-top-right-radius: 0px;
						border-top-right-radius: 0px;
						-webkit-border-bottom-right-radius: 0px;
						border-bottom-right-radius: 0px;
					}

				<?php } ?>

				<?php if ($position == 'middle-left') { ?>

					.floating-cart button {
						position:fixed;
						top: 50%;
						right:auto;
						left: 0px;
						z-index: 1050;
						-webkit-border-top-left-radius: 0px;
						border-top-left-radius: 0px;
						-webkit-border-bottom-left-radius: 0px;
						border-bottom-left-radius: 0px;
						-webkit-border-top-right-radius: 4px;
						border-top-right-radius: 4px;
						-webkit-border-bottom-right-radius: 4px;
						border-bottom-right-radius: 4px;
					}

				<?php } ?>

				<?php if ($position == 'middle-right') { ?>

					.floating-cart button {
						position:fixed;
						top: 50%;
						right:0px;
						z-index: 1050;
						-webkit-border-top-right-radius: 0px;
						border-top-right-radius: 0px;
						-webkit-border-bottom-right-radius: 0px;
						border-bottom-right-radius: 0px;
					}

				<?php } ?>

				<?php if ($position == 'bottom-left') { ?>

					.floating-cart button {
						position:fixed;
						top: 92%;
						right:auto;
						left: 0px;
						z-index: 1050;
						-webkit-border-top-left-radius: 0px;
						border-top-left-radius: 0px;
						-webkit-border-bottom-left-radius: 0px;
						border-bottom-left-radius: 0px;
						-webkit-border-top-right-radius: 4px;
						border-top-right-radius: 4px;
						-webkit-border-bottom-right-radius: 4px;
						border-bottom-right-radius: 4px;
					}

				<?php } ?>

				<?php if ($position == 'bottom-right') { ?>

					.floating-cart button {
						position:fixed;
						top: 92%;
						right:0px;
						z-index: 1050;
						-webkit-border-top-right-radius: 0px;
						border-top-right-radius: 0px;
						-webkit-border-bottom-right-radius: 0px;
						border-bottom-right-radius: 0px;
					}

				<?php } ?>

				</style>

				<?php
			}
		}

		function mp_floating_shopping_cart() {

			$settings = wpsf_get_settings( plugin_dir_path( __FILE__ ) .'inc/fc-settings.php' );

			$enablefc = esc_attr($settings['fcsettings_general_enable_floating_cart']);

			$showcartitem = esc_attr($settings['fcsettings_general_show_cart_total_item']);
			$showcartamount = esc_attr($settings['fcsettings_general_show_cart_total_amount']);

			switch ($settings['fcsettings_general_button_color_predefined']) {
				case 'grey':
					$btnclass = '';
					$iconclass = '';
					break;
				case 'blue':
					$btnclass = ' btn-primary';
					$iconclass = ' icon-white';
					break;
				case 'lightblue':
					$btnclass = ' btn-info';
					$iconclass = ' icon-white';
					break;
				case 'green':
					$btnclass = ' btn-success';
					$iconclass = ' icon-white';
					break;
				case 'yellow':
					$btnclass = ' btn-warning';
					$iconclass = ' icon-white';
					break;
				case 'red':
					$btnclass = ' btn-danger';
					$iconclass = ' icon-white';
					break;
				case 'black':
					$btnclass = ' btn-inverse';
					$iconclass = ' icon-white';
					break;
				
				default:
					$btnclass = '';
					$iconclass = '';
					break;
			}

			if ( $enablefc == 'yes') {
				
				?>

				<div class="floating-cart hidden-phone">

					<button class="btn btn-large<?php echo $btnclass; ?>" type="button" data-toggle="modal" data-target="#cart-section"><i class="icon-shopping-cart<?php echo $iconclass; ?>"></i> <small><?php $this->floating_cart_contents_in_button( true , $settings ); ?></small></button>

				</div>

				<div id="cart-section" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="cartsection" aria-hidden="true">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="cartsection"><?php _e( 'Shopping Cart', 'floating-cart' ) ?></h3>
					</div>

					<div class="modal-body">
						<div class="mp_cart_widget_content">
							<?php echo mp_show_cart('widget'); ?>
						</div>
					</div>

					<div class="modal-footer">
						<button class="btn<?php echo $btnclass; ?>" data-dismiss="modal" aria-hidden="true"><?php _e( 'Close', 'floating-cart' ) ?></button>
					</div>
				</div>

				<!-- Load JS -->
				<script type="text/javascript">
				
				jQuery(document).ready(function () {
					
					// floating cart		
					jQuery(document).ajaxComplete(function(e, xhr, settings) {
						var tot = 0;
						var cart_tot = 0;
						
						<?php if ( $showcartitem == 'yes' ) { ?> 	
							jQuery.each(jQuery('#cart-section td.mp_cart_col_quant'),function(){
								var qty = jQuery(this).html() - 0;
								if(!isNaN(qty)){
									tot += qty;
								}
							});

							jQuery('.floating-cart span.cart-total-items').html(tot);

						<?php } ?>

						<?php if ( $showcartamount == 'yes' ) { ?> 	

							jQuery.each(jQuery('#cart-section td.mp_cart_col_total'),function(){
								cart_tot = jQuery(this).html();
							});

							jQuery('.floating-cart span.cart-total-amount').html(cart_tot);

						<?php } ?>

					});

				});

				</script>

				<?php

			}

		}

		function floating_cart_contents_in_button( $echo = true , $settings = '' ){

			$showbtntext = esc_attr($settings['fcsettings_general_show_button_text']);
			$buttontext = esc_attr($settings['fcsettings_general_button_text']);
			$showcartitem = esc_attr($settings['fcsettings_general_show_cart_total_item']);
			$showcartamount = esc_attr($settings['fcsettings_general_show_cart_total_amount']);

			$output = '';

			if ( $showcartitem == 'yes' )
				$output .= '<span class="cart-total-items">'.mp_items_count_in_cart().'</span>'.__( ' item(s)' , 'floating-cart' );

			if ( $showcartitem == 'yes' && $showcartamount ==  'yes'  )
				$output .= ' - ';

			if ( $showcartamount ==  'yes' )
				$output .= '<span class="cart-total-amount">'.$this->floating_cart_total_amount_in_cart( false ).'</span>';
			
			if ( $showbtntext == 'yes' )
				$output .= '<span class="view-cart"> - '.__( $buttontext, 'floating-cart' ).'</span>';

			if ($echo) {
			    echo $output;
			} else {
			    return $output;
			}
		}

		function floating_cart_total_amount_in_cart( $echo = true ) {

		  	global $mp, $blog_id;
		  	$blog_id = (is_multisite()) ? $blog_id : 1;
		  	$current_blog_id = $blog_id;

			$global_cart = $mp->get_cart_contents(true);
		  	if (!$mp->global_cart)  //get subset if needed
		  		$selected_cart[$blog_id] = $global_cart[$blog_id];
		  	else
		    	$selected_cart = $global_cart;

		    $totals = array();
		    
		    foreach ($selected_cart as $bid => $cart) {

			if (is_multisite())
		        switch_to_blog($bid);

		   	foreach ($cart as $product_id => $variations) {
		        foreach ($variations as $variation => $data) {
		          $totals[] = $data['price'] * $data['quantity'];
		        }
		      }
		    }

			if (is_multisite())
		      switch_to_blog($current_blog_id);

		    $total = array_sum($totals);

			if ($echo) {
			    echo $mp->format_currency('', $total);
			} else {
			    return $mp->format_currency('', $total);
			}
		}

		function floating_cart_plugin_updater_init() {

			include_once( $this->plugin_path .'inc/fc-updater.php' );

			if ( ! defined( 'WP_GITHUB_FORCE_UPDATE' ) ) {
				define( 'WP_GITHUB_FORCE_UPDATE', true );
			}

			if ( is_admin() ) {

				$config = array(
					'slug' => plugin_basename( __FILE__ ),
					'proper_folder_name' => 'mp-floating-cart',
					'api_url' => 'https://api.github.com/repos/nathanonn/mp-floating-cart',
					'raw_url' => 'https://raw.github.com/nathanonn/mp-floating-cart/master',
					'github_url' => 'https://github.com/nathanonn/mp-floating-cart',
					'zip_url' => 'https://github.com/nathanonn/mp-floating-cart/zipball/master',
					'sslverify' => true,
					'requires' => '3.5',
					'tested' => '3.5',
					'readme' => 'README.md',
					'access_token' => '',
				);

				new WP_GitHub_Updater( $config );

			}
		}

	}

	new MPFloatingCart();

?>