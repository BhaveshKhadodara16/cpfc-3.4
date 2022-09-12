<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Conditional_Product_Fees_For_Checkout_Pro
 * @subpackage Woocommerce_Conditional_Product_Fees_For_Checkout_Pro/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Conditional_Product_Fees_For_Checkout_Pro
 * @subpackage Woocommerce_Conditional_Product_Fees_For_Checkout_Pro/public
 * @author     Multidots <inquiry@multidots.in>
 */
class Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Public {

	private static $admin_object = null;
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version     The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name  = $plugin_name;
		$this->version      = $version;
		self::$admin_object = new Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Admin( '', '' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-conditional-product-fees-for-checkout-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . 'font-awesome', WCPFC_PRO_PLUGIN_URL . 'admin/css/font-awesome.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-conditional-product-fees-for-checkout-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	/**
	 * Override WooCommerce file in our plugin
	 *
	 * @param string $template
	 * @param string $template_name
	 * @param mixed  $template_path
	 *
	 * @return string $template
	 * @since    1.0.0
	 *
	 *
	 */
	function woocommerce_locate_template_product_fees_conditions( $template, $template_name, $template_path ) {
		global $woocommerce;
		$_template = $template;
		if ( ! $template_path ) {
			$template_path = $woocommerce->template_url;
		}
		$plugin_path = wcpfc_pro_path() . '/woocommerce/';
		$template    = locate_template(
			array(
				$template_path . $template_name,
				$template_name,
			)
		);
		// Modification: Get the template from this plugin, if it exists
		if ( ! $template && file_exists( $plugin_path . $template_name ) ) {
			$template = $plugin_path . $template_name;
		}
		if ( ! $template ) {
			$template = $_template;
		}

		// Return what we found
		return $template;
	}

	/**
	 * Add fees in cart based on rule
	 *
	 * @param array $package
	 * //package->fees_api()->add_fee
	 *
	 * @since    1.0.0
	 *
	 * @uses     Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Admin::wcpfc_pro_get_default_langugae_with_sitpress()
	 * @uses     wcpfc_pro_get_woo_version_number()
	 * @uses     WC_Cart::get_cart()
	 * @uses     wcpfc_pro_fees_per_qty_on_ap_rules_off()
	 * @uses     wcpfc_pro_cart_subtotal_before_discount_cost()
	 * @uses     wcpfc_pro_cart_subtotal_after_discount_cost()
	 * @uses     wcpfc_pro_match_country_rules()
	 * @uses     wcpfc_pro_match_state_rules__premium_only()
	 * @uses     wcpfc_pro_match_postcode_rules__premium_only()
	 * @uses     wcpfc_pro_match_zone_rules__premium_only()
	 * @uses     wcpfc_pro_match_variable_products_rule__premium_only()
	 * @uses     wcpfc_pro_match_simple_products_rule()
	 * @uses     wcpfc_pro_match_category_rule__premium_only()
	 * @uses     wcpfc_pro_match_tag_rule()
	 * @uses     wcpfc_pro_match_user_rule()
	 * @uses     wcpfc_pro_match_user_role_rule__premium_only()
	 * @uses     wcpfc_pro_match_coupon_rule__premium_only()
	 * @uses     wcpfc_pro_match_cart_subtotal_before_discount_rule()
	 * @uses     wcpfc_pro_match_cart_subtotal_after_discount_rule__premium_only()
	 * @uses     wcpfc_pro_match_cart_total_cart_qty_rule()
	 * @uses     wcpfc_pro_match_cart_total_weight_rule__premium_only()
	 * @uses     wcpfc_pro_match_shipping_class_rule__premium_only()
	 * @uses     wcpfc_pro_match_payment_gateway_rule__premium_only()
	 * @uses     wcpfc_pro_match_shipping_method_rule__premium_only()
	 * @uses     wcpfc_pro_fee_array_column_public()
	 * @uses     wcpfc_pro_match_product_per_qty__premium_only()
	 * @uses     wcpfc_pro_match_category_per_qty__premium_only()
	 * @uses     wcpfc_pro_match_total_cart_qty__premium_only()
	 * @uses     wcpfc_pro_match_product_per_weight__premium_only()
	 * @uses     wcpfc_pro_match_category_per_weight__premium_only()
	 * @uses     wcpfc_pro_match_total_cart_weight__premium_only()
	 * @uses     wcpfc_pro_calculate_advance_pricing_rule_fees()
	 *
	 */
	public function wcpfc_pro_conditional_fee_add_to_cart( $package ) {
		global $woocommerce_wpml, $sitepress, $woocommerce;
		$default_lang = self::$admin_object->wcpfc_pro_get_default_langugae_with_sitpress();
		$fees_args    = array(
			'post_type'        => 'wc_conditional_fee',
			'post_status'      => 'publish',
			'posts_per_page'   => - 1,
			'suppress_filters' => false,
		);
		$get_all_fees = get_transient( 'get_all_fees' );
		if ( false === $get_all_fees ) {
			$get_all_fees_query = new WP_Query( $fees_args );
			$get_all_fees       = $get_all_fees_query->get_posts();
			set_transient( 'get_all_fees', $get_all_fees );
		}
		$wc_curr_version             = $this->wcpfc_pro_get_woo_version_number();
		$cart_array                  = $this->wcpfc_pro_get_cart();
		$cart_main_product_ids_array = $this->wcpfc_pro_get_main_prd_id( $sitepress, $default_lang );
		$cart_product_ids_array      = $this->wcpfc_pro_get_prd_var_id( $sitepress, $default_lang );
		$cart_sub_total              = WC()->cart->subtotal;
		$total_fee                   = 0;
		$chk_enable_custom_fun       = get_option( 'chk_enable_custom_fun' );
		if ( ! empty( $get_all_fees ) ) {
			foreach ( $get_all_fees as $fees ) {
				if ( ! empty( $sitepress ) ) {
					$fees_id = apply_filters( 'wpml_object_id', $fees->ID, 'wc_conditional_fee', true, $default_lang );
				} else {
					$fees_id = $fees->ID;
				}
				if ( ! empty( $sitepress ) ) {
					if ( version_compare( ICL_SITEPRESS_VERSION, '3.2', '>=' ) ) {
						$language_information = apply_filters( 'wpml_post_language_details', null, $fees_id );
					} else {
						$language_information = wpml_get_language_information( $fees_id );
					}
					$post_id_language_code = $language_information['language_code'];
				} else {
					$post_id_language_code = $default_lang;
				}
				if ( $post_id_language_code === $default_lang ) {
					$is_passed                    = array();
					$final_is_passed_general_rule = array();
					$new_is_passed                = array();
					$final_passed                 = array();
					$cart_based_qty               = 0;
					foreach ( $cart_array as $woo_cart_item_for_qty ) {
						$cart_based_qty += $woo_cart_item_for_qty['quantity'];
					}
					$fee_title           = get_the_title( $fees_id );
					$title               = ! empty( $fee_title ) ? __( $fee_title, 'woocommerce-conditional-product-fees-for-checkout' ) : __( 'Fee', 'woocommerce-conditional-product-fees-for-checkout' );
					$getFeesCostOriginal = get_post_meta( $fees_id, 'fee_settings_product_cost', true );
					$getFeeType          = get_post_meta( $fees_id, 'fee_settings_select_fee_type', true );
					if ( isset( $woocommerce_wpml ) && ! empty( $woocommerce_wpml->multi_currency ) ) {
						if ( isset( $getFeeType ) && ! empty( $getFeeType ) && 'fixed' === $getFeeType ) {
							$getFeesCost = $woocommerce_wpml->multi_currency->prices->convert_price_amount( $getFeesCostOriginal );
						} else {
							$getFeesCost = $getFeesCostOriginal;
						}
					} else {
						$getFeesCost = $getFeesCostOriginal;
					}
					if ( wcpffc_fs()->is__premium_only() ) {
						if ( wcpffc_fs()->can_use_premium_code() ) {
							$getFeesPerQtyFlag        = get_post_meta( $fees_id, 'fee_chk_qty_price', true );
							$getFeesPerQty            = get_post_meta( $fees_id, 'fee_per_qty', true );
							$extraProductCostOriginal = get_post_meta( $fees_id, 'extra_product_cost', true );
							if ( isset( $woocommerce_wpml ) && ! empty( $woocommerce_wpml->multi_currency ) ) {
								$extraProductCost = $woocommerce_wpml->multi_currency->prices->convert_price_amount( $extraProductCostOriginal );
							} else {
								$extraProductCost = $extraProductCostOriginal;
							}
						}
					}
					$getFeetaxable   = get_post_meta( $fees_id, 'fee_settings_select_taxable', true );
					$getFeeStartDate = get_post_meta( $fees_id, 'fee_settings_start_date', true );
					$getFeeEndDate   = get_post_meta( $fees_id, 'fee_settings_end_date', true );
					$getFeeStatus    = get_post_meta( $fees_id, 'fee_settings_status', true );
					if ( isset( $getFeeStatus ) && 'off' === $getFeeStatus ) {
						continue;
					}
					$fees_cost           = $getFeesCost;
					$get_condition_array = get_post_meta( $fees_id, 'product_fees_metabox', true );
					if ( wcpffc_fs()->is__premium_only() ) {
						if ( wcpffc_fs()->can_use_premium_code() ) {
							$cost_rule_match = get_post_meta( $fees_id, 'cost_rule_match', true );
							if ( ! empty( $cost_rule_match ) ) {
								if ( is_serialized( $cost_rule_match ) ) {
									$cost_rule_match = maybe_unserialize( $cost_rule_match );
								} else {
									$cost_rule_match = $cost_rule_match;
								}
								if ( array_key_exists( 'general_rule_match', $cost_rule_match ) ) {
									$general_rule_match = $cost_rule_match['general_rule_match'];
								} else {
									$general_rule_match = 'all';
								}
								if ( array_key_exists( 'cost_on_product_rule_match', $cost_rule_match ) ) {
									$cost_on_product_rule_match = $cost_rule_match['cost_on_product_rule_match'];
								} else {
									$cost_on_product_rule_match = 'any';
								}
								if ( array_key_exists( 'cost_on_product_weight_rule_match', $cost_rule_match ) ) {
									$cost_on_product_weight_rule_match = $cost_rule_match['cost_on_product_weight_rule_match'];
								} else {
									$cost_on_product_weight_rule_match = 'any';
								}
								if ( array_key_exists( 'cost_on_product_subtotal_rule_match', $cost_rule_match ) ) {
									$cost_on_product_subtotal_rule_match = $cost_rule_match['cost_on_product_subtotal_rule_match'];
								} else {
									$cost_on_product_subtotal_rule_match = 'any';
								}
								if ( array_key_exists( 'cost_on_category_rule_match', $cost_rule_match ) ) {
									$cost_on_category_rule_match = $cost_rule_match['cost_on_category_rule_match'];
								} else {
									$cost_on_category_rule_match = 'any';
								}
								if ( array_key_exists( 'cost_on_category_weight_rule_match', $cost_rule_match ) ) {
									$cost_on_category_weight_rule_match = $cost_rule_match['cost_on_category_weight_rule_match'];
								} else {
									$cost_on_category_weight_rule_match = 'any';
								}
								if ( array_key_exists( 'cost_on_category_subtotal_rule_match', $cost_rule_match ) ) {
									$cost_on_category_subtotal_rule_match = $cost_rule_match['cost_on_category_subtotal_rule_match'];
								} else {
									$cost_on_category_subtotal_rule_match = 'any';
								}
								if ( array_key_exists( 'cost_on_total_cart_qty_rule_match', $cost_rule_match ) ) {
									$cost_on_total_cart_qty_rule_match = $cost_rule_match['cost_on_total_cart_qty_rule_match'];
								} else {
									$cost_on_total_cart_qty_rule_match = 'any';
								}
								if ( array_key_exists( 'cost_on_total_cart_weight_rule_match', $cost_rule_match ) ) {
									$cost_on_total_cart_weight_rule_match = $cost_rule_match['cost_on_total_cart_weight_rule_match'];
								} else {
									$cost_on_total_cart_weight_rule_match = 'any';
								}
								if ( array_key_exists( 'cost_on_total_cart_subtotal_rule_match', $cost_rule_match ) ) {
									$cost_on_total_cart_subtotal_rule_match = $cost_rule_match['cost_on_total_cart_subtotal_rule_match'];
								} else {
									$cost_on_total_cart_subtotal_rule_match = 'any';
								}
								if ( array_key_exists( 'cost_on_shipping_class_subtotal_rule_match', $cost_rule_match ) ) {
									$cost_on_shipping_class_subtotal_rule_match = $cost_rule_match['cost_on_shipping_class_subtotal_rule_match'];
								} else {
									$cost_on_shipping_class_subtotal_rule_match = 'any';
								}
							} else {
								$general_rule_match                         = 'all';
								$cost_on_product_rule_match                 = 'any';
								$cost_on_product_weight_rule_match          = 'any';
								$cost_on_product_subtotal_rule_match        = 'any';
								$cost_on_category_rule_match                = 'any';
								$cost_on_category_weight_rule_match         = 'any';
								$cost_on_category_subtotal_rule_match       = 'any';
								$cost_on_total_cart_qty_rule_match          = 'any';
								$cost_on_total_cart_weight_rule_match       = 'any';
								$cost_on_total_cart_subtotal_rule_match     = 'any';
								$cost_on_shipping_class_subtotal_rule_match = 'any';
							}
							$ap_rule_status          = get_post_meta( $fees_id, 'ap_rule_status', true );
							$products_based_qty      = 0;
							$products_based_subtotal = 0;
							//add new condition for apply per quantity only apply if advanced pricing rule disabled
							if ( 'on' === $getFeesPerQtyFlag && 'on' !== $ap_rule_status ) {
								$products_based_rule = $this->wcpfc_pro_fees_per_qty_on_ap_rules_off( $fees_id, $cart_array, $products_based_qty, $products_based_subtotal, $sitepress, $default_lang );
								if ( ! empty( $products_based_rule ) ) {
									if ( array_key_exists( '0', $products_based_rule ) ) {
										$products_based_qty = $products_based_rule[0];
									}
									if ( array_key_exists( '1', $products_based_rule ) ) {
										$products_based_subtotal = $products_based_rule[1];
									}
								}
								if ( isset( $getFeeType ) && ! empty( $getFeeType ) && $getFeeType === 'percentage' ) {
									$getFeesCost = ( $products_based_subtotal * $getFeesCost ) / 100;
								}
								if ( 'qty_cart_based' === $getFeesPerQty ) {
									$fees_cost = $getFeesCost + ( ( $cart_based_qty - 1 ) * $extraProductCost );
								} else if ( 'qty_product_based' === $getFeesPerQty ) {
									$fees_cost = $getFeesCost + ( ( $products_based_qty - 1 ) * $extraProductCost );
								}
								// Per Qty Condition end
							} else {
								if ( isset( $getFeeType ) && ! empty( $getFeeType ) && $getFeeType === 'percentage' ) {
									$fees_cost = ( $cart_sub_total * $getFeesCost ) / 100;
								} else {
									$fees_cost = $getFeesCost;
								}
							}
						}
					} else {
						$general_rule_match = 'all';
						if ( isset( $getFeeType ) && ! empty( $getFeeType ) && $getFeeType === 'percentage' ) {
							$fees_cost = ( $cart_sub_total * $getFeesCost ) / 100;
						} else {
							$fees_cost = $getFeesCost;
						}
					}
					if ( ! empty( $get_condition_array ) ) {
						$country_array    = array();
						$product_array    = array();
						$tag_array        = array();
						$user_array       = array();
						$cart_total_array = array();
						$quantity_array   = array();
						if ( wcpffc_fs()->is__premium_only() ) {
							if ( wcpffc_fs()->can_use_premium_code() ) {
								$state_array           = array();
								$postcode_array        = array();
								$zone_array            = array();
								$variableproduct_array = array();
								$category_array        = array();
								$user_role_array       = array();
								$cart_totalafter_array = array();
								$weight_array          = array();
								$coupon_array          = array();
								$shipping_class_array  = array();
								$payment_gateway       = array();
								$shipping_methods      = array();
							}
						}
						foreach ( $get_condition_array as $key => $value ) {
							if ( array_search( 'country', $value, true ) ) {
								$country_array[ $key ] = $value;
							}
							if ( array_search( 'product', $value, true ) ) {
								$product_array[ $key ] = $value;
							}
							if ( array_search( 'tag', $value, true ) ) {
								$tag_array[ $key ] = $value;
							}
							if ( array_search( 'user', $value, true ) ) {
								$user_array[ $key ] = $value;
							}
							if ( array_search( 'cart_total', $value, true ) ) {
								$cart_total_array[ $key ] = $value;
							}
							if ( array_search( 'quantity', $value, true ) ) {
								$quantity_array[ $key ] = $value;
							}
							if ( wcpffc_fs()->is__premium_only() ) {
								if ( wcpffc_fs()->can_use_premium_code() ) {
									if ( array_search( 'state', $value, true ) ) {
										$state_array[ $key ] = $value;
									}
									if ( array_search( 'postcode', $value, true ) ) {
										$postcode_array[ $key ] = $value;
									}
									if ( array_search( 'zone', $value, true ) ) {
										$zone_array[ $key ] = $value;
									}
									if ( array_search( 'variableproduct', $value, true ) ) {
										$variableproduct_array[ $key ] = $value;
									}
									if ( array_search( 'category', $value, true ) ) {
										$category_array[ $key ] = $value;
									}
									if ( array_search( 'user_role', $value, true ) ) {
										$user_role_array[ $key ] = $value;
									}
									if ( array_search( 'cart_totalafter', $value, true ) ) {
										$cart_totalafter_array[ $key ] = $value;
									}
									if ( array_search( 'weight', $value, true ) ) {
										$weight_array[ $key ] = $value;
									}
									if ( array_search( 'coupon', $value, true ) ) {
										$coupon_array[ $key ] = $value;
									}
									if ( array_search( 'shipping_class', $value, true ) ) {
										$shipping_class_array[ $key ] = $value;
									}
									if ( array_search( 'payment', $value, true ) ) {
										$payment_gateway[ $key ] = $value;
									}
									if ( array_search( 'shipping_method', $value, true ) ) {
										$shipping_methods[ $key ] = $value;
									}
								}
							}
							//Check if is country exist
							if ( is_array( $country_array ) && isset( $country_array ) && ! empty( $country_array ) && ! empty( $cart_array ) ) {
								$country_passed = $this->wcpfc_pro_match_country_rules( $country_array, $general_rule_match );
								if ( 'yes' === $country_passed ) {
									$is_passed['has_fee_based_on_country'] = 'yes';
								} else {
									$is_passed['has_fee_based_on_country'] = 'no';
								}
							}
							//Check if is product exist
							if ( is_array( $product_array ) && isset( $product_array ) && ! empty( $product_array ) && ! empty( $cart_product_ids_array ) ) {
								$product_passed = $this->wcpfc_pro_match_simple_products_rule( $cart_product_ids_array, $product_array, $general_rule_match );
								if ( 'yes' === $product_passed ) {
									$is_passed['has_fee_based_on_product'] = 'yes';
								} else {
									$is_passed['has_fee_based_on_product'] = 'no';
								}
							}
							//Check if is tag exist
							if ( is_array( $tag_array ) && isset( $tag_array ) && ! empty( $tag_array ) && ! empty( $cart_main_product_ids_array ) ) {
								$tag_passed = $this->wcpfc_pro_match_tag_rule( $cart_main_product_ids_array, $tag_array, $general_rule_match );
								if ( 'yes' === $tag_passed ) {
									$is_passed['has_fee_based_on_tag'] = 'yes';
								} else {
									$is_passed['has_fee_based_on_tag'] = 'no';
								}
							}
							//Check if is user exist
							if ( is_array( $user_array ) && isset( $user_array ) && ! empty( $user_array ) && ! empty( $cart_array ) ) {
								$user_passed = $this->wcpfc_pro_match_user_rule( $user_array, $general_rule_match );
								if ( 'yes' === $user_passed ) {
									$is_passed['has_fee_based_on_user'] = 'yes';
								} else {
									$is_passed['has_fee_based_on_user'] = 'no';
								}
							}
							//Check if is Cart Subtotal (Before Discount) exist
							if ( is_array( $cart_total_array ) && isset( $cart_total_array ) && ! empty( $cart_total_array ) && ! empty( $cart_array ) ) {
								$cart_total_before_passed = $this->wcpfc_pro_match_cart_subtotal_before_discount_rule( $wc_curr_version, $cart_total_array, $general_rule_match );
								if ( 'yes' === $cart_total_before_passed ) {
									$is_passed['has_fee_based_on_cart_total_before'] = 'yes';
								} else {
									$is_passed['has_fee_based_on_cart_total_before'] = 'no';
								}
							}
							//Check if is quantity exist
							if ( is_array( $quantity_array ) && isset( $quantity_array ) && ! empty( $quantity_array ) && ! empty( $cart_array ) ) {
								$quantity_passed = $this->wcpfc_pro_match_cart_total_cart_qty_rule( $cart_array, $quantity_array, $general_rule_match );
								if ( 'yes' === $quantity_passed ) {
									$is_passed['has_fee_based_on_quantity'] = 'yes';
								} else {
									$is_passed['has_fee_based_on_quantity'] = 'no';
								}
							}
							if ( wcpffc_fs()->is__premium_only() ) {
								if ( wcpffc_fs()->can_use_premium_code() ) {
									//Check if is state exist
									if ( is_array( $state_array ) && isset( $state_array ) && ! empty( $state_array ) && ! empty( $cart_array ) ) {
										$state_passed = $this->wcpfc_pro_match_state_rules__premium_only( $state_array, $general_rule_match );
										if ( 'yes' === $state_passed ) {
											$is_passed['has_fee_based_on_state'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_state'] = 'no';
										}
									}
									//Check if is postcode exist
									if ( is_array( $postcode_array ) && isset( $postcode_array ) && ! empty( $postcode_array ) && ! empty( $cart_array ) ) {
										$postcode_passed = $this->wcpfc_pro_match_postcode_rules__premium_only( $postcode_array, $general_rule_match );
										if ( 'yes' === $postcode_passed ) {
											$is_passed['has_fee_based_on_postcode'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_postcode'] = 'no';
										}
									}
									//Check if is zone exist
									if ( is_array( $zone_array ) && isset( $zone_array ) && ! empty( $zone_array ) && ! empty( $cart_array ) ) {
										$zone_passed = $this->wcpfc_pro_match_zone_rules__premium_only( $zone_array, $general_rule_match );
										if ( 'yes' === $zone_passed ) {
											$is_passed['has_fee_based_on_zone'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_zone'] = 'no';
										}
									}
									//Check if is variable product exist
									if ( is_array( $variableproduct_array ) && isset( $variableproduct_array ) && ! empty( $variableproduct_array ) && ! empty( $cart_product_ids_array ) ) {
										$variable_prd_passed = $this->wcpfc_pro_match_variable_products_rule__premium_only( $cart_product_ids_array, $variableproduct_array, $general_rule_match );
										if ( 'yes' === $variable_prd_passed ) {
											$is_passed['has_fee_based_on_variable_prd'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_variable_prd'] = 'no';
										}
									}
									//Check if is Category exist
									if ( is_array( $category_array ) && isset( $category_array ) && ! empty( $category_array ) && ! empty( $cart_main_product_ids_array ) ) {
										$category_passed = $this->wcpfc_pro_match_category_rule__premium_only( $cart_main_product_ids_array, $category_array, $general_rule_match );
										if ( 'yes' === $category_passed ) {
											$is_passed['has_fee_based_on_category'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_category'] = 'no';
										}
									}
									//Check if is user role exist
									if ( is_array( $user_role_array ) && isset( $user_role_array ) && ! empty( $user_role_array ) && ! empty( $cart_array ) ) {
										$user_role_passed = $this->wcpfc_pro_match_user_role_rule__premium_only( $user_role_array, $general_rule_match );
										if ( 'yes' === $user_role_passed ) {
											$is_passed['has_fee_based_on_user_role'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_user_role'] = 'no';
										}
									}
									//Check if is coupon exist
									if ( is_array( $coupon_array ) && isset( $coupon_array ) && ! empty( $coupon_array ) && ! empty( $cart_array ) ) {
										$coupon_passed = $this->wcpfc_pro_match_coupon_rule__premium_only( $wc_curr_version, $coupon_array, $general_rule_match );
										if ( 'yes' === $coupon_passed ) {
											$is_passed['has_fee_based_on_coupon'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_coupon'] = 'no';
										}
									}
									//Check if is Cart Subtotal (After Discount) exist
									if ( is_array( $cart_totalafter_array ) && isset( $cart_totalafter_array ) && ! empty( $cart_totalafter_array ) && ! empty( $cart_array ) ) {
										$cart_total_after_passed = $this->wcpfc_pro_match_cart_subtotal_after_discount_rule__premium_only( $wc_curr_version, $cart_totalafter_array, $general_rule_match );
										if ( 'yes' === $cart_total_after_passed ) {
											$is_passed['has_fee_based_on_cart_total_after'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_cart_total_after'] = 'no';
										}
									}
									//Check if is weight exist
									if ( is_array( $weight_array ) && isset( $weight_array ) && ! empty( $weight_array ) && ! empty( $cart_array ) ) {
										$weight_passed = $this->wcpfc_pro_match_cart_total_weight_rule__premium_only( $cart_array, $weight_array, $general_rule_match );
										if ( 'yes' === $weight_passed ) {
											$is_passed['has_fee_based_on_weight'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_weight'] = 'no';
										}
									}
									//Check if is shipping class exist
									if ( is_array( $shipping_class_array ) && isset( $shipping_class_array ) && ! empty( $shipping_class_array ) && ! empty( $cart_product_ids_array ) ) {
										$shipping_class_passed = $this->wcpfc_pro_match_shipping_class_rule__premium_only( $cart_product_ids_array, $shipping_class_array, $general_rule_match );
										if ( 'yes' === $shipping_class_passed ) {
											$is_passed['has_fee_based_on_shipping_class'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_shipping_class'] = 'no';
										}
									}
									//Check if is payment gateway exist
									if ( is_array( $payment_gateway ) && isset( $payment_gateway ) && ! empty( $payment_gateway ) && ! empty( $cart_array ) ) {
										$payment_gateway_passed = $this->wcpfc_pro_match_payment_gateway_rule__premium_only( $payment_gateway, $general_rule_match );
										if ( 'yes' === $payment_gateway_passed ) {
											$is_passed['has_fee_based_on_payment_gateway'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_payment_gateway'] = 'no';
										}
									}
									//Check if is shipping method exist
									if ( is_array( $shipping_methods ) && isset( $shipping_methods ) && ! empty( $shipping_methods ) && ! empty( $cart_array ) ) {
										$shipping_method_passed = $this->wcpfc_pro_match_shipping_method_rule__premium_only( $wc_curr_version, $shipping_methods, $general_rule_match );
										if ( 'yes' === $shipping_method_passed ) {
											$is_passed['has_fee_based_on_shipping_method'] = 'yes';
										} else {
											$is_passed['has_fee_based_on_shipping_method'] = 'no';
										}
									}
								}
							}
						}
						if ( isset( $is_passed ) && ! empty( $is_passed ) && is_array( $is_passed ) ) {
							$fnispassed = array();
							foreach ( $is_passed as $val ) {
								if ( '' !== $val ) {
									$fnispassed[] = $val;
								}
							}
							if ( 'all' === $general_rule_match ) {
								if ( in_array( 'no', $fnispassed, true ) ) {
									$final_is_passed_general_rule['passed'] = 'no';
								} else {
									$final_is_passed_general_rule['passed'] = 'yes';
								}
							} else {
								if ( in_array( 'yes', $fnispassed, true ) ) {
									$final_is_passed_general_rule['passed'] = 'yes';
								} else {
									$final_is_passed_general_rule['passed'] = 'no';
								}
							}
						}
					}
					if ( wcpffc_fs()->is__premium_only() ) {
						if ( wcpffc_fs()->can_use_premium_code() ) {
							/* Start Advance Pricing Rules */
							if ( 'on' === $ap_rule_status ) {
								$cost_on_product_status                         = get_post_meta( $fees_id, 'cost_on_product_status', true );
								$cost_on_category_status                        = get_post_meta( $fees_id, 'cost_on_category_status', true );
								$cost_on_total_cart_qty_status                  = get_post_meta( $fees_id, 'cost_on_total_cart_qty_status', true );
								$cost_on_product_weight_status                  = get_post_meta( $fees_id, 'cost_on_product_weight_status', true );
								$cost_on_category_weight_status                 = get_post_meta( $fees_id, 'cost_on_category_weight_status', true );
								$cost_on_total_cart_weight_status               = get_post_meta( $fees_id, 'cost_on_total_cart_weight_status', true );
								$cost_on_total_cart_subtotal_status             = get_post_meta( $fees_id, 'cost_on_total_cart_subtotal_status', true );
								$cost_on_product_subtotal_status                = get_post_meta( $fees_id, 'cost_on_product_subtotal_status', true );
								$cost_on_category_subtotal_status               = get_post_meta( $fees_id, 'cost_on_category_subtotal_status', true );
								$cost_on_shipping_class_subtotal_status         = get_post_meta( $fees_id, 'cost_on_shipping_class_subtotal_status', true );
								$get_condition_array_ap_product                 = get_post_meta( $fees_id, 'sm_metabox_ap_product', true );
								$get_condition_array_ap_category                = get_post_meta( $fees_id, 'sm_metabox_ap_category', true );
								$get_condition_array_ap_total_cart_qty          = get_post_meta( $fees_id, 'sm_metabox_ap_total_cart_qty', true );
								$get_condition_array_ap_product_weight          = get_post_meta( $fees_id, 'sm_metabox_ap_product_weight', true );
								$get_condition_array_ap_category_weight         = get_post_meta( $fees_id, 'sm_metabox_ap_category_weight', true );
								$get_condition_array_ap_total_cart_weight       = get_post_meta( $fees_id, 'sm_metabox_ap_total_cart_weight', true );
								$get_condition_array_ap_total_cart_subtotal     = get_post_meta( $fees_id, 'sm_metabox_ap_total_cart_subtotal', true );
								$get_condition_array_ap_product_subtotal        = get_post_meta( $fees_id, 'sm_metabox_ap_product_subtotal', true );
								$get_condition_array_ap_category_subtotal       = get_post_meta( $fees_id, 'sm_metabox_ap_category_subtotal', true );
								$get_condition_array_ap_shipping_class_subtotal = get_post_meta( $fees_id, 'sm_metabox_ap_shipping_class_subtotal', true );
								$match_advance_rule                             = array();
								if ( 'on' === $cost_on_product_status ) {
									$match_advance_rule['hfbopq'] = $this->wcpfc_pro_match_product_per_qty__premium_only( $get_condition_array_ap_product, $cart_array, $sitepress, $default_lang, $cost_on_product_rule_match );
								}
								if ( 'on' === $cost_on_product_subtotal_status ) {
									$match_advance_rule['hfbops'] = $this->wcpfc_pro_match_product_subtotal__premium_only( $get_condition_array_ap_product_subtotal, $cart_array, $cost_on_product_subtotal_rule_match, $sitepress, $default_lang );
								}
								if ( 'on' === $cost_on_product_weight_status ) {
									$match_advance_rule['hfbopw'] = $this->wcpfc_pro_match_product_per_weight__premium_only( $get_condition_array_ap_product_weight, $cart_array, $sitepress, $default_lang, $cost_on_product_weight_rule_match );
								}
								if ( 'on' === $cost_on_category_status ) {
									$match_advance_rule['hfbocs'] = $this->wcpfc_pro_match_category_per_qty__premium_only( $get_condition_array_ap_category, $cart_array, $sitepress, $default_lang, $cost_on_category_rule_match );
								}
								if ( 'on' === $cost_on_category_subtotal_status ) {
									$match_advance_rule['hfbocs'] = $this->wcpfc_pro_match_category_subtotal__premium_only( $get_condition_array_ap_category_subtotal, $cart_array, $cost_on_category_subtotal_rule_match, $sitepress, $default_lang );
								}
								if ( 'on' === $cost_on_category_weight_status ) {
									$match_advance_rule['hfbocw'] = $this->wcpfc_pro_match_category_per_weight__premium_only( $get_condition_array_ap_category_weight, $cart_array, $sitepress, $default_lang, $cost_on_category_weight_rule_match );
								}
								if ( 'on' === $cost_on_total_cart_qty_status ) {
									$match_advance_rule['hfbotcq'] = $this->wcpfc_pro_match_total_cart_qty__premium_only( $get_condition_array_ap_total_cart_qty, $cart_array, $cost_on_total_cart_qty_rule_match );
								}
								if ( 'on' === $cost_on_total_cart_weight_status ) {
									$match_advance_rule['hfbotcw'] = $this->wcpfc_pro_match_total_cart_weight__premium_only( $get_condition_array_ap_total_cart_weight, $cart_array, $cost_on_total_cart_weight_rule_match );
								}
								if ( 'on' === $cost_on_total_cart_subtotal_status ) {
									$match_advance_rule['hfbotcs'] = $this->wcpfc_pro_match_total_cart_subtotal__premium_only( $get_condition_array_ap_total_cart_subtotal, $cart_array, $cost_on_total_cart_subtotal_rule_match );
								}
								if ( 'on' === $cost_on_shipping_class_subtotal_status ) {
									$match_advance_rule['hfbscs'] = $this->wcpfc_pro_match_shipping_class_subtotal__premium_only( $get_condition_array_ap_shipping_class_subtotal, $cart_array, $cost_on_shipping_class_subtotal_rule_match, $sitepress, $default_lang );
								}
								$advance_pricing_rule_cost = 0;
								if ( isset( $match_advance_rule ) && ! empty( $match_advance_rule ) && is_array( $match_advance_rule ) ) {
									foreach ( $match_advance_rule as $val ) {
										if ( '' !== $val['flag'] && 'yes' === $val['flag'] ) {
											$advance_pricing_rule_cost += $val['total_amount'];
										}
									}
								}
								$advance_pricing_rule_cost = $this->wcpfc_pro_price_format( $advance_pricing_rule_cost );
								$fees_cost                 += $advance_pricing_rule_cost;
							}
						}
					}
					if ( empty( $final_is_passed_general_rule ) || '' === $final_is_passed_general_rule || null === $final_is_passed_general_rule ) {
						$new_is_passed['passed'] = 'no';
					} else if ( ! empty( $final_is_passed_general_rule ) && in_array( 'no', $final_is_passed_general_rule, true ) ) {
						$new_is_passed['passed'] = 'no';
					} else if ( empty( $final_is_passed_general_rule ) && in_array( '', $final_is_passed_general_rule, true ) ) {
						$new_is_passed['passed'] = 'no';
					} else if ( ! empty( $final_is_passed_general_rule ) && in_array( 'yes', $final_is_passed_general_rule, true ) ) {
						$new_is_passed['passed'] = 'yes';
					}
					if ( in_array( 'no', $new_is_passed, true ) ) {
						$final_passed['passed'] = 'no';
					} else {
						$final_passed['passed'] = 'yes';
					}
					if ( isset( $final_passed ) && ! empty( $final_passed ) && is_array( $final_passed ) ) {
						if ( ! in_array( 'no', $final_passed, true ) ) {
							$texable      = ( isset( $getFeetaxable ) && ! empty( $getFeetaxable ) && 'yes' === $getFeetaxable ) ? true : false;
							$currentDate  = strtotime( date( 'd-m-Y' ) );
							$feeStartDate = isset( $getFeeStartDate ) && '' !== $getFeeStartDate ? strtotime( $getFeeStartDate ) : '';
							$feeEndDate   = isset( $getFeeEndDate ) && '' !== $getFeeEndDate ? strtotime( $getFeeEndDate ) : '';
							$fees_cost    = $this->wcpfc_pro_price_format( $fees_cost );
							if ( ( $currentDate >= $feeStartDate || '' === $feeStartDate ) && ( $currentDate <= $feeEndDate || '' === $feeEndDate ) ) {
								if ( '' !== $fees_cost ) {
									$chk_enable_coupon_fee = get_option( 'chk_enable_coupon_fee' );
									$insert_fee_flat = 1;
									if ( 'on' === $chk_enable_coupon_fee ) {
										if ( $wc_curr_version >= 3.0 ) {
											$cart_coupon = WC()->cart->get_coupons();
										} else {
											$cart_coupon = isset( $woocommerce->cart->coupons ) && ! empty( $woocommerce->cart->coupons ) ? $woocommerce->cart->coupons : array();
										}
										if ( !empty( $cart_coupon ) && is_array( $cart_coupon ) ) {
											foreach ( $cart_coupon as $coupon ) {
												$coupon_type   = $coupon->get_discount_type();
												$coupon_amount = intval($coupon->get_amount());
												if(!('percent' === $coupon_type) || !(100 === $coupon_amount)){
													/** @var add the total fee value $total_fee */
													if ( ( ! empty( $chk_enable_custom_fun ) && 'on' === $chk_enable_custom_fun ) ) {
														$total_fee = $total_fee + $fees_cost;
													} else {
														$package->fees_api()->add_fee(
															array(
																'id'         => $fees_id,
																'name'       => $title,
																'amount'     => $fees_cost,
																'taxable'    => $texable,
																'tax_class'  => '',
																'menu_order' => $fees->menu_order,
															)
														);
													}
												}
											}
										} else {
											/** @var add the total fee value $total_fee */
											if ( ( ! empty( $chk_enable_custom_fun ) && 'on' === $chk_enable_custom_fun ) ) {
												$total_fee = $total_fee + $fees_cost;
											} else {
												$package->fees_api()->add_fee(
													array(
														'id'         => $fees_id,
														'name'       => $title,
														'amount'     => $fees_cost,
														'taxable'    => $texable,
														'tax_class'  => '',
														'menu_order' => $fees->menu_order,
													)
												);
											}
										}
									} else {
										/** @var add the total fee value $total_fee */
										if ( ( ! empty( $chk_enable_custom_fun ) && 'on' === $chk_enable_custom_fun ) ) {
											$total_fee = $total_fee + $fees_cost;
										} else {
											$package->fees_api()->add_fee(
												array(
													'id'         => $fees_id,
													'name'       => $title,
													'amount'     => $fees_cost,
													'taxable'    => $texable,
													'tax_class'  => '',
													'menu_order' => $fees->menu_order,
												)
											);
										}
									}
								}
							}
						}
					}
				}
			}
			/**
			 * Add one time fee with total applied fees count
			 */
			if ( ( ! empty( $chk_enable_custom_fun ) && 'on' === $chk_enable_custom_fun ) ) {
				if ( isset( $total_fee ) && 0 < $total_fee ) {
					$fee_title = apply_filters('wcpfc_all_fee_title','Fees');
					$package->fees_api()->add_fee(
						array(
							'id'         => 'total_fee',
							'name'       => __( $fee_title, 'woocommerce-conditional-product-fees-for-checkout' ),
							'amount'     => $total_fee,
							'taxable'    => false,
							'tax_class'  => '',
							'menu_order' => $fees->menu_order,
						)
					);
				}
			}
		}
	}

	function wcpfc_pro_get_woo_version_number() {
		// If get_plugins() isn't available, require it
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		// Create the plugins folder and file variables
		$plugin_folder = get_plugins( '/' . 'woocommerce' );
		$plugin_file   = 'woocommerce.php';
		// If the plugin version number is set, return it
		if ( isset( $plugin_folder[ $plugin_file ]['Version'] ) ) {
			return $plugin_folder[ $plugin_file ]['Version'];
		} else {
			return null;
		}
	}

	/**
	 * Get product id and variation id from cart
	 *
	 * @return array $cart_array
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_cart() {
		$cart_array = WC()->cart->get_cart();

		return $cart_array;
	}

	/**
	 * Get product id and variation id from cart
	 *
	 * @param string $sitepress
	 * @param string $default_lang
	 *
	 * @return array $cart_main_product_ids_array
	 * @uses  wcpfc_pro_get_cart();
	 *
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_main_prd_id( $sitepress, $default_lang ) {
		$cart_array                  = $this->wcpfc_pro_get_cart();
		$cart_main_product_ids_array = array();
		foreach ( $cart_array as $woo_cart_item ) {
			if ( ! empty( $sitepress ) ) {
				$cart_main_product_ids_array[] = apply_filters( 'wpml_object_id', $woo_cart_item['product_id'], 'product', true, $default_lang );
			} else {
				$cart_main_product_ids_array[] = $woo_cart_item['product_id'];
			}
		}

		return $cart_main_product_ids_array;
	}

	/**
	 * Get product id and variation id from cart
	 *
	 * @param string $sitepress
	 * @param string $default_lang
	 *
	 * @return array $cart_product_ids_array
	 * @uses  wcpfc_pro_get_cart();
	 *
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_prd_var_id( $sitepress, $default_lang ) {
		$cart_array             = $this->wcpfc_pro_get_cart();
		$cart_product_ids_array = array();
		foreach ( $cart_array as $woo_cart_item ) {
			$_product = wc_get_product( $woo_cart_item['product_id'] );
			if ( wcpffc_fs()->is__premium_only() ) {
				if ( wcpffc_fs()->can_use_premium_code() ) {
					if ( $_product->is_type( 'variable' ) ) {
						if ( ! empty( $sitepress ) ) {
							$cart_product_ids_array[] = apply_filters( 'wpml_object_id', $woo_cart_item['variation_id'], 'product', true, $default_lang );
						} else {
							$cart_product_ids_array[] = $woo_cart_item['variation_id'];
						}
					}
					if ( $_product->is_type( 'simple' ) ) {
						if ( ! empty( $sitepress ) ) {
							$cart_product_ids_array[] = apply_filters( 'wpml_object_id', $woo_cart_item['product_id'], 'product', true, $default_lang );
						} else {
							$cart_product_ids_array[] = $woo_cart_item['product_id'];
						}
					}
				} else {
					if ( ! empty( $sitepress ) ) {
						$cart_product_ids_array[] = apply_filters( 'wpml_object_id', $woo_cart_item['product_id'], 'product', true, $default_lang );
					} else {
						$cart_product_ids_array[] = $woo_cart_item['product_id'];
					}
				}
			} else {
				if ( ! empty( $sitepress ) ) {
					$cart_product_ids_array[] = apply_filters( 'wpml_object_id', $woo_cart_item['product_id'], 'product', true, $default_lang );
				} else {
					$cart_product_ids_array[] = $woo_cart_item['product_id'];
				}
			}
		}

		return $cart_product_ids_array;
	}

	/**
	 * Count qty for product based and cart based when apply per qty option is on. This rule will apply when advance pricing rule will disable
	 *
	 * @param int    $fees_id
	 * @param array  $cart_array
	 * @param int    $products_based_qty
	 * @param float  $products_based_subtotal
	 * @param string $sitepress
	 * @param string $default_lang
	 *
	 * @return array $products_based_qty, $products_based_subtotal
	 * @since 1.3.3
	 *
	 * @uses  get_post_meta()
	 * @uses  get_post()
	 * @uses  get_terms()
	 *
	 */
	public function wcpfc_pro_fees_per_qty_on_ap_rules_off( $fees_id, $cart_array, $products_based_qty, $products_based_subtotal, $sitepress, $default_lang ) {
		$productFeesArray = get_post_meta( $fees_id, 'product_fees_metabox', true );
		$all_rule_check   = array();
		if ( ! empty( $productFeesArray ) ) {
			foreach ( $productFeesArray as $condition ) {
				if ( array_search( 'product', $condition, true ) ) {
					$site_product_id           = '';
					$cart_final_products_array = array();
					// Product Condition Start
					if ( 'is_equal_to' === $condition['product_fees_conditions_is'] ) {
						if ( ! empty( $condition['product_fees_conditions_values'] ) ) {
							foreach ( $condition['product_fees_conditions_values'] as $product_id ) {
								settype( $product_id, 'integer' );
								foreach ( $cart_array as $value ) {
									if ( ! empty( $sitepress ) ) {
										$site_product_id = apply_filters( 'wpml_object_id', $value['product_id'], 'product', true, $default_lang );
									} else {
										$site_product_id = $value['product_id'];
									}
									if ( $product_id === $site_product_id ) {
										$cart_final_products_array[ $value['product_id'] ] = $value;
									}
								}
							}
						}
					} elseif ( 'not_in' === $condition['product_fees_conditions_is'] ) {
						if ( ! empty( $condition['product_fees_conditions_values'] ) ) {
							foreach ( $condition['product_fees_conditions_values'] as $product_id ) {
								foreach ( $cart_array as $value ) {
									if ( ! empty( $value['variation_id'] ) || 0 !== $value['variation_id'] ) {
										$product_id_lan = $value['variation_id'];
									} else {
										$product_id_lan = $value['product_id'];
									}
									$_product = wc_get_product( $product_id_lan );
									if ( ! ( $_product->is_virtual( 'yes' ) ) ) {
										if ( ! empty( $sitepress ) ) {
											$site_product_id = apply_filters( 'wpml_object_id', $product_id_lan, 'product', true, $default_lang );
										} else {
											$site_product_id = $product_id_lan;
										}
										if ( $product_id !== $site_product_id ) {
											$cart_final_products_array[ $product_id_lan ] = $value;
										}
									}
								}
							}
						}
					}
					if ( ! empty( $cart_final_products_array ) ) {
						foreach ( $cart_final_products_array as $prd_id => $cart_item ) {
							$line_item_subtotal                    = (float) $cart_item['line_subtotal'] + (float) $cart_item['line_subtotal_tax'];
							$all_rule_check[ $prd_id ]['qty']      = $cart_item['quantity'];
							$all_rule_check[ $prd_id ]['subtotal'] = $line_item_subtotal;
						}
					}
					// Product Condition End
				}
				if ( array_search( 'variableproduct', $condition, true ) ) {
					$site_product_id               = '';
					$cart_final_var_products_array = array();
					// Variable Product Condition Start
					if ( 'is_equal_to' === $condition['product_fees_conditions_is'] ) {
						if ( ! empty( $condition['product_fees_conditions_values'] ) ) {
							foreach ( $condition['product_fees_conditions_values'] as $product_id ) {
								settype( $product_id, 'integer' );
								foreach ( $cart_array as $value ) {
									if ( ! empty( $sitepress ) ) {
										$site_product_id = apply_filters( 'wpml_object_id', $value['variation_id'], 'product', true, $default_lang );
									} else {
										$site_product_id = $value['variation_id'];
									}
									if ( $product_id === $site_product_id ) {
										$cart_final_var_products_array[ $value['product_id'] ] = $value;
									}
								}
							}
						}
					} elseif ( 'not_in' === $condition['product_fees_conditions_is'] ) {
						if ( ! empty( $condition['product_fees_conditions_values'] ) ) {
							foreach ( $condition['product_fees_conditions_values'] as $product_id ) {
								settype( $product_id, 'integer' );
								foreach ( $cart_array as $value ) {
									if ( ! empty( $value['variation_id'] ) || 0 !== $value['variation_id'] ) {
										$product_id_lan = $value['variation_id'];
									} else {
										$product_id_lan = $value['product_id'];
									}
									$_product = wc_get_product( $product_id_lan );
									if ( ! ( $_product->is_virtual( 'yes' ) ) ) {
										if ( ! empty( $sitepress ) ) {
											$site_product_id = apply_filters( 'wpml_object_id', $product_id_lan, 'product', true, $default_lang );
										} else {
											$site_product_id = $product_id_lan;
										}
										if ( $product_id !== $site_product_id ) {
											$cart_final_var_products_array[ $product_id_lan ] = $value;
										}
									}
								}
							}
						}
					}
					if ( ! empty( $cart_final_var_products_array ) ) {
						foreach ( $cart_final_var_products_array as $prd_id => $cart_item ) {
							$line_item_subtotal                    = (float) $cart_item['line_subtotal'] + (float) $cart_item['line_subtotal_tax'];
							$all_rule_check[ $prd_id ]['qty']      = $cart_item['quantity'];
							$all_rule_check[ $prd_id ]['subtotal'] = $line_item_subtotal;
						}
					}
					// Variable Product Condition End
				}
				// Category Condition Start
				if ( array_search( 'category', $condition, true ) ) {
					$final_cart_products_cats_ids  = array();
					$cart_final_cat_products_array = array();
					$all_cats                      = get_terms(
						array(
							'taxonomy' => 'product_cat',
							'fields'   => 'ids',
						)
					);
					if ( 'is_equal_to' === $condition['product_fees_conditions_is'] ) {
						if ( ! empty( $condition['product_fees_conditions_values'] ) ) {
							foreach ( $condition['product_fees_conditions_values'] as $category_id ) {
								settype( $category_id, 'integer' );
								$final_cart_products_cats_ids[] = $category_id;
							}
						}
					} elseif ( 'not_in' === $condition['product_fees_conditions_is'] ) {
						if ( ! empty( $condition['product_fees_conditions_values'] ) ) {
							$final_cart_products_cats_ids = array_diff( $all_cats, $condition['product_fees_conditions_values'] );
						}
					}
					$terms            = array();
					$cart_value_array = array();
					foreach ( $cart_array as $value ) {
						$line_item_subtotal = (float) $value['line_subtotal'] + (float) $value['line_subtotal_tax'];
						$cart_value_array[] = $value;
						$term_ids           = wp_get_post_terms( $value['product_id'], 'product_cat', array( 'fields' => 'ids' ) );
						foreach ( $term_ids as $term_id ) {
							$terms[ $value['product_id'] ][ $term_id ] = $value['quantity'] . "||" . $line_item_subtotal;
						}
					}
					foreach ( $terms as $cart_product_key => $main_term_data ) {
						foreach ( $main_term_data as $cart_term_id => $term_data ) {
							$term_data_explode  = explode( "||", $term_data );
							$cart_term_qty      = json_decode( $term_data_explode[0] );
							$cart_term_subtotal = json_decode( $term_data_explode[1] );
							if ( in_array( $cart_term_id, $final_cart_products_cats_ids, true ) ) {
								$cart_final_cat_products_array[ $cart_product_key ][ $cart_term_id ] = $cart_term_qty . "||" . $cart_term_subtotal;
							}
						}
					}
					if ( ! empty( $cart_final_cat_products_array ) ) {
						foreach ( $cart_final_cat_products_array as $prd_id => $main_cart_item ) {
							foreach ( $main_cart_item as $term_id => $cart_item ) {
								$cart_item_explode                     = explode( "||", $cart_item );
								$all_rule_check[ $prd_id ]['qty']      = $cart_item_explode[0];
								$all_rule_check[ $prd_id ]['subtotal'] = $cart_item_explode[1];
							}
						}
					}
				}
				// Category Condition End
				if ( array_search( 'tag', $condition, true ) ) {
					// Tag Condition Start
					$final_cart_products_tag_ids   = array();
					$cart_final_tag_products_array = array();
					$all_tags                      = get_terms(
						array(
							'taxonomy' => 'product_tag',
							'fields'   => 'ids',
						)
					);
					if ( 'is_equal_to' === $condition['product_fees_conditions_is'] ) {
						if ( ! empty( $condition['product_fees_conditions_values'] ) ) {
							foreach ( $condition['product_fees_conditions_values'] as $tag_id ) {
								$final_cart_products_tag_ids[] = $tag_id;
							}
						}
					} elseif ( 'not_in' === $condition['product_fees_conditions_is'] ) {
						if ( ! empty( $condition['product_fees_conditions_values'] ) ) {
							$final_cart_products_tag_ids = array_diff( $all_tags, $condition['product_fees_conditions_values'] );
						}
					}
					$final_cart_products_tag_ids = array_map( 'intval', $final_cart_products_tag_ids );
					$tags                        = array();
					$cart_value_array            = array();
					foreach ( $cart_array as $value ) {
						$line_item_subtotal = (float) $value['line_subtotal'] + (float) $value['line_subtotal_tax'];
						$cart_value_array[] = $value;
						$tag_ids            = wp_get_post_terms( $value['product_id'], 'product_tag', array( 'fields' => 'ids' ) );
						foreach ( $tag_ids as $tag_id ) {
							$tags[ $value['product_id'] ][ $tag_id ] = $value['quantity'] . "||" . $line_item_subtotal;
						}
					}
					foreach ( $tags as $cart_product_key => $main_tag_data ) {
						foreach ( $main_tag_data as $cart_tag_id => $tag_data ) {
							$tag_data_explode  = explode( "||", $tag_data );
							$cart_tag_qty      = json_decode( $tag_data_explode[0] );
							$cart_tag_subtotal = json_decode( $tag_data_explode[1] );
							if ( ! empty( $final_cart_products_tag_ids ) ) {
								if ( in_array( $cart_tag_id, $final_cart_products_tag_ids, true ) ) {
									$cart_final_tag_products_array[ $cart_product_key ][ $cart_tag_id ] = $cart_tag_qty . "||" . $cart_tag_subtotal;
								}
							}
						}
					}
					if ( ! empty( $cart_final_tag_products_array ) ) {
						foreach ( $cart_final_tag_products_array as $prd_id => $main_cart_item ) {
							foreach ( $main_cart_item as $term_id => $cart_item ) {
								$cart_item_explode                     = explode( "||", $cart_item );
								$all_rule_check[ $prd_id ]['qty']      = $cart_item_explode[0];
								$all_rule_check[ $prd_id ]['subtotal'] = $cart_item_explode[1];
							}
						}
					}
				}
			}
		}
		if ( ! empty( $all_rule_check ) ) {
			foreach ( $all_rule_check as $cart_item ) {
				$products_based_qty      += $cart_item['qty'];
				$products_based_subtotal += $cart_item['subtotal'];
			}
		}
		if ( 0 === $products_based_qty ) {
			$products_based_qty = 1;
		}

		return array( $products_based_qty, $products_based_subtotal );
	}

	/**
	 * Match country rules
	 *
	 * @param array  $country_array
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 *
	 * @since    1.3.3
	 *
	 * @uses     WC_Customer::get_shipping_country()
	 *
	 */
	public function wcpfc_pro_match_country_rules( $country_array, $general_rule_match ) {
		$selected_country = WC()->customer->get_shipping_country();
		$is_passed        = array();
		foreach ( $country_array as $key => $country ) {
			if ( 'is_equal_to' === $country['product_fees_conditions_is'] ) {
				if ( ! empty( $country['product_fees_conditions_values'] ) ) {
					if ( in_array( $selected_country, $country['product_fees_conditions_values'], true ) ) {
						$is_passed[ $key ]['has_fee_based_on_country'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_country'] = 'no';
					}
				}
				if ( empty( $country['product_fees_conditions_values'] ) ) {
					$is_passed[ $key ]['has_fee_based_on_country'] = 'yes';
				}
			}
			if ( 'not_in' === $country['product_fees_conditions_is'] ) {
				if ( ! empty( $country['product_fees_conditions_values'] ) ) {
					if ( in_array( $selected_country, $country['product_fees_conditions_values'], true ) || in_array( 'all', $country['product_fees_conditions_values'], true ) ) {
						$is_passed[ $key ]['has_fee_based_on_country'] = 'no';
					} else {
						$is_passed[ $key ]['has_fee_based_on_country'] = 'yes';
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_country', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Find unique id based on given array
	 *
	 * @param array  $is_passed
	 * @param string $has_fee_based
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 * @since    3.6
	 *
	 */
	public function wcpfc_pro_check_all_passed_general_rule( $is_passed, $has_fee_based, $general_rule_match ) {
		$main_is_passed = 'no';
		$flag           = array();
		if ( ! empty( $is_passed ) ) {
			foreach ( $is_passed as $key => $is_passed_value ) {
				if ( 'yes' === $is_passed_value[ $has_fee_based ] ) {
					$flag[ $key ] = true;
				} else {
					$flag[ $key ] = false;
				}
			}
			if ( 'any' === $general_rule_match ) {
				if ( in_array( true, $flag, true ) ) {
					$main_is_passed = 'yes';
				} else {
					$main_is_passed = 'no';
				}
			} else {
				if ( in_array( false, $flag, true ) ) {
					$main_is_passed = 'no';
				} else {
					$main_is_passed = 'yes';
				}
			}
		}

		return $main_is_passed;
	}

	/**
	 * Match simple products rules
	 *
	 * @param array  $cart_product_ids_array
	 * @param array  $product_array
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 * @uses     wcpfc_pro_fee_array_column_public()
	 *
	 * @since    1.3.3
	 *
	 */
	public function wcpfc_pro_match_simple_products_rule( $cart_product_ids_array, $product_array, $general_rule_match ) {
		$is_passed = array();
		foreach ( $product_array as $key => $product ) {
			if ( 'is_equal_to' === $product['product_fees_conditions_is'] ) {
				if ( ! empty( $product['product_fees_conditions_values'] ) ) {
					foreach ( $product['product_fees_conditions_values'] as $product_id ) {
						settype( $product_id, 'integer' );
						if ( in_array( $product_id, $cart_product_ids_array, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_product'] = 'yes';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_product'] = 'no';
						}
					}
				}
			}
			if ( 'not_in' === $product['product_fees_conditions_is'] ) {
				if ( ! empty( $product['product_fees_conditions_values'] ) ) {
					foreach ( $product['product_fees_conditions_values'] as $product_id ) {
						settype( $product_id, 'integer' );
						if ( in_array( $product_id, $cart_product_ids_array, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_product'] = 'no';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_product'] = 'yes';
						}
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_product', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match tag rules
	 *
	 * @param array  $cart_product_ids_array
	 * @param array  $tag_array
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 *
	 * @uses     wcpfc_pro_fee_array_column_public()
	 * @uses     wp_get_post_terms()
	 * @uses     wcpfc_pro_array_flatten()
	 *
	 * @since    1.3.3
	 *
	 */
	public function wcpfc_pro_match_tag_rule( $cart_product_ids_array, $tag_array, $general_rule_match ) {
		$tagid     = array();
		$is_passed = array();
		foreach ( $cart_product_ids_array as $product ) {
			$cart_product_tag = wp_get_post_terms( $product, 'product_tag', array( 'fields' => 'ids' ) );
			if ( isset( $cart_product_tag ) && ! empty( $cart_product_tag ) && is_array( $cart_product_tag ) ) {
				$tagid[] = $cart_product_tag;
			}
		}
		$get_tag_all = array_unique( $this->wcpfc_pro_array_flatten( $tagid ) );
		foreach ( $tag_array as $key => $tag ) {
			if ( 'is_equal_to' === $tag['product_fees_conditions_is'] ) {
				if ( ! empty( $tag['product_fees_conditions_values'] ) ) {
					foreach ( $tag['product_fees_conditions_values'] as $tag_id ) {
						settype( $tag_id, 'integer' );
						if ( in_array( $tag_id, $get_tag_all, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_tag'] = 'yes';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_tag'] = 'no';
						}
					}
				}
			}
			if ( 'not_in' === $tag['product_fees_conditions_is'] ) {
				if ( ! empty( $tag['product_fees_conditions_values'] ) ) {
					foreach ( $tag['product_fees_conditions_values'] as $tag_id ) {
						settype( $tag_id, 'integer' );
						if ( in_array( $tag_id, $get_tag_all, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_tag'] = 'no';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_tag'] = 'yes';
						}
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_tag', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Find unique id based on given array
	 *
	 * @param array $array
	 *
	 * @return array $result if $array is empty it will return false otherwise return array as $result
	 * @since    1.0.0
	 *
	 */
	public function wcpfc_pro_array_flatten( $array ) {
		if ( ! is_array( $array ) ) {
			return false;
		}
		$result = array();
		foreach ( $array as $key => $value ) {
			if ( is_array( $value ) ) {
				$result = array_merge( $result, $this->wcpfc_pro_array_flatten( $value ) );
			} else {
				$result[ $key ] = $value;
			}
		}

		return $result;
	}

	/**
	 * Match user rules
	 *
	 * @param array  $user_array
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 *
	 * @uses     get_current_user_id()
	 *
	 * @since    1.3.3
	 *
	 * @uses     is_user_logged_in()
	 */
	public function wcpfc_pro_match_user_rule( $user_array, $general_rule_match ) {
		if ( ! is_user_logged_in() ) {
			return false;
		}
		$current_user_id = get_current_user_id();
		$is_passed       = array();
		foreach ( $user_array as $key => $user ) {
			$user['product_fees_conditions_values'] = array_map( 'intval', $user['product_fees_conditions_values'] );
			if ( 'is_equal_to' === $user['product_fees_conditions_is'] ) {
				if ( in_array( $current_user_id, $user['product_fees_conditions_values'], true ) ) {
					$is_passed[ $key ]['has_fee_based_on_user'] = 'yes';
				} else {
					$is_passed[ $key ]['has_fee_based_on_user'] = 'no';
				}
			}
			if ( 'not_in' === $user['product_fees_conditions_is'] ) {
				if ( in_array( $current_user_id, $user['product_fees_conditions_values'], true ) ) {
					$is_passed[ $key ]['has_fee_based_on_user'] = 'no';
				} else {
					$is_passed[ $key ]['has_fee_based_on_user'] = 'yes';
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_user', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match rule based on cart subtotal before discount
	 *
	 * @param string $wc_curr_version
	 * @param array  $cart_total_array
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 *
	 * @uses     WC_Cart::get_subtotal()
	 *
	 * @since    1.3.3
	 *
	 */
	public function wcpfc_pro_match_cart_subtotal_before_discount_rule( $wc_curr_version, $cart_total_array, $general_rule_match ) {
		global $woocommerce, $woocommerce_wpml;
		if ( $wc_curr_version >= 3.0 ) {
			$total = $this->wcpfc_pro_get_cart_subtotal();
		} else {
			$total = $woocommerce->cart->subtotal;
		}
		if ( isset( $woocommerce_wpml ) && ! empty( $woocommerce_wpml->multi_currency ) ) {
			$new_total = $woocommerce_wpml->multi_currency->prices->unconvert_price_amount( $total );
		} else {
			$new_total = $total;
		}
		$is_passed = array();
		foreach ( $cart_total_array as $key => $cart_total ) {
			settype( $cart_total['product_fees_conditions_values'], 'float' );
			if ( 'is_equal_to' === $cart_total['product_fees_conditions_is'] ) {
				if ( ! empty( $cart_total['product_fees_conditions_values'] ) ) {
					if ( $cart_total['product_fees_conditions_values'] === $new_total ) {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'no';
					}
				}
			}
			if ( 'less_equal_to' === $cart_total['product_fees_conditions_is'] ) {
				if ( ! empty( $cart_total['product_fees_conditions_values'] ) ) {
					if ( $cart_total['product_fees_conditions_values'] >= $new_total ) {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'no';
					}
				}
			}
			if ( 'less_then' === $cart_total['product_fees_conditions_is'] ) {
				if ( ! empty( $cart_total['product_fees_conditions_values'] ) ) {
					if ( $cart_total['product_fees_conditions_values'] > $new_total ) {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'no';
					}
				}
			}
			if ( 'greater_equal_to' === $cart_total['product_fees_conditions_is'] ) {
				if ( ! empty( $cart_total['product_fees_conditions_values'] ) ) {
					if ( $cart_total['product_fees_conditions_values'] <= $new_total ) {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'no';
					}
				}
			}
			if ( 'greater_then' === $cart_total['product_fees_conditions_is'] ) {
				$cart_total['product_fees_conditions_values'];
				if ( ! empty( $cart_total['product_fees_conditions_values'] ) ) {
					if ( $cart_total['product_fees_conditions_values'] < $new_total ) {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'no';
					}
				}
			}
			if ( 'not_in' === $cart_total['product_fees_conditions_is'] ) {
				if ( ! empty( $cart_total['product_fees_conditions_values'] ) ) {
					if ( $new_total === $cart_total['product_fees_conditions_values'] ) {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'no';
					} else {
						$is_passed[ $key ]['has_fee_based_on_cart_total'] = 'yes';
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_cart_total', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * get cart subtotal
	 *
	 * @return float $cart_subtotal
	 * @since  1.5.2
	 *
	 */
	public function wcpfc_pro_get_cart_subtotal() {
		$get_customer            = WC()->cart->get_customer();
		$get_customer_vat_exempt = WC()->customer->get_is_vat_exempt();
		$tax_display_cart        = WC()->cart->tax_display_cart;
		$wc_prices_include_tax   = wc_prices_include_tax();
		$tax_enable              = wc_tax_enabled();
		$cart_subtotal           = 0;
		if ( true === $tax_enable ) {
			if ( true === $wc_prices_include_tax ) {
				if ( 'incl' === $tax_display_cart && ! ( $get_customer && $get_customer_vat_exempt ) ) {
					$cart_subtotal += WC()->cart->get_subtotal() + WC()->cart->get_subtotal_tax();
				} else {
					$cart_subtotal += WC()->cart->get_subtotal();
				}
			} else {
				if ( 'incl' === $tax_display_cart && ! ( $get_customer && $get_customer_vat_exempt ) ) {
					$cart_subtotal += WC()->cart->get_subtotal() + WC()->cart->get_subtotal_tax();
				} else {
					$cart_subtotal += WC()->cart->get_subtotal();
				}
			}
		} else {
			$cart_subtotal += WC()->cart->get_subtotal();
		}

		return $cart_subtotal;
	}

	/**
	 * Match rule based on total cart quantity
	 *
	 * @param array $quantity_array
	 *
	 * @return array $is_passed
	 * @since    1.3.3
	 *
	 * @uses     WC_Cart::get_cart()
	 *
	 */
	public function wcpfc_pro_match_cart_total_cart_qty_rule( $cart_array, $quantity_array, $general_rule_match ) {
		$quantity_total = 0;
		foreach ( $cart_array as $woo_cart_item ) {
			$quantity_total += $woo_cart_item['quantity'];
		}
		$is_passed = array();
		foreach ( $quantity_array as $key => $quantity ) {
			settype( $quantity['product_fees_conditions_values'], 'integer' );
			if ( 'is_equal_to' === $quantity['product_fees_conditions_is'] ) {
				if ( ! empty( $quantity['product_fees_conditions_values'] ) ) {
					if ( $quantity_total === $quantity['product_fees_conditions_values'] ) {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'no';
					}
				}
			}
			if ( 'less_equal_to' === $quantity['product_fees_conditions_is'] ) {
				if ( ! empty( $quantity['product_fees_conditions_values'] ) ) {
					if ( $quantity['product_fees_conditions_values'] >= $quantity_total ) {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'no';
					}
				}
			}
			if ( 'less_then' === $quantity['product_fees_conditions_is'] ) {
				if ( ! empty( $quantity['product_fees_conditions_values'] ) ) {
					if ( $quantity['product_fees_conditions_values'] > $quantity_total ) {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'no';
					}
				}
			}
			if ( 'greater_equal_to' === $quantity['product_fees_conditions_is'] ) {
				if ( ! empty( $quantity['product_fees_conditions_values'] ) ) {
					if ( $quantity['product_fees_conditions_values'] <= $quantity_total ) {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'no';
					}
				}
			}
			if ( 'greater_then' === $quantity['product_fees_conditions_is'] ) {
				if ( ! empty( $quantity['product_fees_conditions_values'] ) ) {
					if ( $quantity['product_fees_conditions_values'] < $quantity_total ) {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'no';
					}
				}
			}
			if ( 'not_in' === $quantity['product_fees_conditions_is'] ) {
				if ( ! empty( $quantity['product_fees_conditions_values'] ) ) {
					if ( $quantity_total === $quantity['product_fees_conditions_values'] ) {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'no';
					} else {
						$is_passed[ $key ]['has_fee_based_on_quantity'] = 'yes';
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_quantity', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match state rules
	 *
	 * @param array  $state_array
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 *
	 * @uses     WC_Customer::get_shipping_state()
	 *
	 * @since    1.3.3
	 *
	 * @uses     WC_Customer::get_shipping_country()
	 */
	public function wcpfc_pro_match_state_rules__premium_only( $state_array, $general_rule_match ) {
		$country        = WC()->customer->get_shipping_country();
		$state          = WC()->customer->get_shipping_state();
		$selected_state = $country . ':' . $state;
		$is_passed      = array();
		foreach ( $state_array as $key => $get_state ) {
			if ( 'is_equal_to' === $get_state['product_fees_conditions_is'] ) {
				if ( ! empty( $get_state['product_fees_conditions_values'] ) ) {
					if ( in_array( $selected_state, $get_state['product_fees_conditions_values'], true ) ) {
						$is_passed[ $key ]['has_fee_based_on_state'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_state'] = 'no';
					}
				}
			}
			if ( 'not_in' === $get_state['product_fees_conditions_is'] ) {
				if ( ! empty( $get_state['product_fees_conditions_values'] ) ) {
					if ( in_array( $selected_state, $get_state['product_fees_conditions_values'], true ) ) {
						$is_passed[ $key ]['has_fee_based_on_state'] = 'no';
					} else {
						$is_passed[ $key ]['has_fee_based_on_state'] = 'yes';
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_state', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match postcode rules
	 *
	 * @param array  $postcode_array
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 *
	 * @since    1.3.3
	 *
	 * @uses     WC_Customer::get_shipping_postcode()
	 *
	 */
	public function wcpfc_pro_match_postcode_rules__premium_only( $postcode_array, $general_rule_match ) {
		$selected_postcode = WC()->customer->get_shipping_postcode();
		$is_passed         = array();
		foreach ( $postcode_array as $key => $postcode ) {
			if ( 'is_equal_to' === $postcode['product_fees_conditions_is'] ) {
				if ( ! empty( $postcode['product_fees_conditions_values'] ) ) {
					$postcodestr        = str_replace( PHP_EOL, "<br/>", $postcode['product_fees_conditions_values'] );
					$postcode_val_array = explode( '<br/>', $postcodestr );
					$selected_postcode  = rtrim( $selected_postcode );
					$postcode_val_array = array_map( 'trim', $postcode_val_array );

					if ( in_array( $selected_postcode, $postcode_val_array, true ) ) {
						$is_passed[ $key ]['has_fee_based_on_postcode'] = 'yes';

					} else {
						$is_passed[ $key ]['has_fee_based_on_postcode'] = 'no';

					}
				}
			}
			if ( 'not_in' === $postcode['product_fees_conditions_is'] ) {
				if ( ! empty( $postcode['product_fees_conditions_values'] ) ) {
					$postcodestr        = str_replace( PHP_EOL, "<br/>", $postcode['product_fees_conditions_values'] );
					$postcode_val_array = explode( '<br/>', $postcodestr );
					$postcode_val_array = array_map( 'trim', $postcode_val_array );
					if ( in_array( trim( $selected_postcode ), $postcode_val_array, true ) ) {
						$is_passed[ $key ]['has_fee_based_on_postcode'] = 'no';
					} else {
						$is_passed[ $key ]['has_fee_based_on_postcode'] = 'yes';
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_postcode', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match zone rules
	 *
	 * @param array  $zone_array
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 *
	 * @since    1.3.3
	 *
	 * @uses     wcpfc_pro_check_zone_available()
	 *
	 */
	public function wcpfc_pro_match_zone_rules__premium_only( $zone_array, $general_rule_match ) {
		$is_passed = array();
		foreach ( $zone_array as $key => $zone ) {
			if ( 'is_equal_to' === $zone['product_fees_conditions_is'] ) {
				if ( ! empty( $zone['product_fees_conditions_values'] ) ) {
					$get_zonelist                           = $this->wcpfc_pro_check_zone_available( $zone['product_fees_conditions_values'] );
					$zone['product_fees_conditions_values'] = array_map( 'intval', $zone['product_fees_conditions_values'] );
					if ( in_array( $get_zonelist, $zone['product_fees_conditions_values'], true ) ) {
						$is_passed[ $key ]['has_fee_based_on_zone'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_zone'] = 'no';
					}
				}
			}
			if ( 'not_in' === $zone['product_fees_conditions_is'] ) {
				if ( ! empty( $zone['product_fees_conditions_values'] ) ) {
					$get_zonelist                           = $this->wcpfc_pro_check_zone_available( $zone['product_fees_conditions_values'] );
					$zone['product_fees_conditions_values'] = array_map( 'intval', $zone['product_fees_conditions_values'] );
					if ( in_array( $get_zonelist, $zone['product_fees_conditions_values'], true ) ) {
						$is_passed[ $key ]['has_fee_based_on_zone'] = 'no';
					} else {
						$is_passed[ $key ]['has_fee_based_on_zone'] = 'yes';
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_zone', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Find a matching zone for a given package.
	 *
	 * @param array $available_zone_id_array
	 *
	 * @return int $return_zone_id
	 * @uses   WC_Customer::get_shipping_state()
	 * @uses   WC_Customer::get_shipping_postcode()
	 * @uses   wc_postcode_location_matcher()
	 *
	 * @since  3.0.0
	 *
	 * @uses   WC_Customer::get_shipping_country()
	 */
	public function wcpfc_pro_check_zone_available( $available_zone_id_array ) {
		$return_zone_id     = '';
		$country            = strtoupper( wc_clean( WC()->customer->get_shipping_country() ) );
		$state              = strtoupper( wc_clean( WC()->customer->get_shipping_state() ) );
		$postcode           = wc_normalize_postcode( wc_clean( WC()->customer->get_shipping_postcode() ) );
		$state_flag         = false;
		$flag               = false;
		$postcode_locations = array();
		$zone_array         = array();
		foreach ( $available_zone_id_array as $zone_id ) {
			$zone_by_id = WC_Shipping_Zones::get_zone_by( 'zone_id', $zone_id );
			$zones      = $zone_by_id->get_zone_locations();
			if ( ! empty( $zones ) ) {
				foreach ( $zones as $zone_location ) {
					if ( 'country' === $zone_location->type || 'state' === $zone_location->type ) {
						$zone_array[ $zone_id ][ $zone_location->type ][] = $zone_location->code;
					}
					$location = new stdClass();
					if ( 'postcode' === $zone_location->type ) {
						$location->zone_id       = $zone_id;
						$location->location_code = $zone_location->code;
						if ( false !== strpos( $location->location_code, '...' ) ) {
							$postcode_locations_ex = explode( '...', $location->location_code );
							$start_index           = $postcode_locations_ex[0];
							$end_index             = $postcode_locations_ex[1];
							if ( $start_index < $end_index ) {
								$total_count = $end_index - $start_index;
								$new_index   = $start_index;
								for ( $i = 0; $i <= $total_count; $i ++ ) {
									$desh_location = new stdClass();
									if ( 0 === $i ) {
										$new_index = $start_index;
									} elseif ( $total_count === $i ) {
										$new_index = $end_index;
									} else {
										$new_index += 1;
									}
									$desh_location->zone_id = $zone_id;
									settype( $new_index, 'string' );
									$desh_location->location_code         = $new_index;
									$postcode_locations[ $zone_id ][ $i ] = $desh_location;
								}
							}
						} else {
							$postcode_locations[ $zone_id ][] = $location;
						}
					}
				}
			}
		}
		if ( ! empty( $zone_array ) ) {
			foreach ( $zone_array as $zone_id => $zone_location_detail ) {
				foreach ( $zone_location_detail as $zone_location_type => $zone_location_code ) {
					if ( 'country' === $zone_location_type ) {
						if ( $postcode_locations ) {
							foreach ( $postcode_locations as $post_zone_id => $postcode_location_detail ) {
								if ( $zone_id === $post_zone_id ) {
									if ( in_array( $country, $zone_location_code, true ) ) {
										$flag = 1;
									}
								} else {
									if ( in_array( $country, $zone_location_code, true ) ) {
										$return_zone_id = $zone_id;
									}
								}
							}
						} else {
							if ( in_array( $country, $zone_location_code, true ) ) {
								$return_zone_id = $zone_id;
							}
						}
					}
					if ( 'state' === $zone_location_type ) {
						$state_array = array();
						foreach ( $zone_location_code as $subzone_location_code ) {
							if ( false !== strpos( $subzone_location_code, ':' ) ) {
								$sub_zone_location_code_explode = explode( ':', $subzone_location_code );
							}
							$state_array[] = $sub_zone_location_code_explode[1];
							if ( ! $postcode_locations ) {
								if ( in_array( $state, $state_array, true ) ) {
									$return_zone_id = $zone_id;
									$state_flag     = true;
								}
							} else {
								if ( in_array( $state, $state_array, true ) ) {
									$flag = 1;
								}
							}
						}
					}
				}
			}
		} else {
			if ( $postcode_locations ) {
				$flag = 1;
			}
		}

		if ( true === $state_flag || 1 === $flag ) {
			if ( $postcode_locations ) {
				foreach ( $postcode_locations as $post_zone_id => $postcode_location_detail ) {
					$matches       = wc_postcode_location_matcher( $postcode, $postcode_location_detail, 'zone_id', 'location_code', $country );
					$matches_count = count( $matches );
					if ( 0 !== $matches_count ) {
						$matches_array_key = array_keys( $matches );
						$return_zone_id    = $matches_array_key[0];
					} else {
						$return_zone_id = '';
					}
				}
			}
		}

		return $return_zone_id;
	}

	/**
	 * Match variable products rules
	 *
	 * @param array $cart_product_ids_array
	 * @param array $variableproduct_array
	 * * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 * @uses     wcpfc_pro_fee_array_column_public()
	 *
	 * @since    1.3.3
	 *
	 */
	public function wcpfc_pro_match_variable_products_rule__premium_only( $cart_product_ids_array, $variableproduct_array, $general_rule_match ) {
		$is_passed      = array();
		$passed_product = array();
		foreach ( $variableproduct_array as $key => $product ) {
			if ( 'is_equal_to' === $product['product_fees_conditions_is'] ) {
				if ( ! empty( $product['product_fees_conditions_values'] ) ) {
					foreach ( $product['product_fees_conditions_values'] as $product_id ) {
						settype( $product_id, 'integer' );
						$passed_product[] = $product_id;
						if ( in_array( $product_id, $cart_product_ids_array, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_product'] = 'yes';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_product'] = 'no';
						}
					}
				}
			}
			if ( 'not_in' === $product['product_fees_conditions_is'] ) {
				if ( ! empty( $product['product_fees_conditions_values'] ) ) {
					foreach ( $product['product_fees_conditions_values'] as $product_id ) {
						settype( $product_id, 'integer' );
						if ( in_array( $product_id, $cart_product_ids_array, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_product'] = 'no';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_product'] = 'yes';
						}
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_product', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match category rules
	 *
	 * @param array  $cart_product_ids_array
	 * @param array  $category_array
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 * @uses     wcpfc_pro_array_flatten()
	 *
	 * @since    1.3.3
	 *
	 * @uses     wcpfc_pro_fee_array_column_public()
	 * @uses     wp_get_post_terms()
	 */
	public function wcpfc_pro_match_category_rule__premium_only( $cart_product_ids_array, $category_array, $general_rule_match ) {
		$is_passed              = array();
		$cart_category_id_array = array();
		foreach ( $cart_product_ids_array as $product ) {
			$cart_product_category = wp_get_post_terms( $product, 'product_cat', array( 'fields' => 'ids' ) );
			if ( isset( $cart_product_category ) && ! empty( $cart_product_category ) && is_array( $cart_product_category ) ) {
				$cart_category_id_array[] = $cart_product_category;
			}
		}
		$get_cat_all = array_unique( $this->wcpfc_pro_array_flatten( $cart_category_id_array ) );
		foreach ( $category_array as $key => $category ) {
			if ( 'is_equal_to' === $category['product_fees_conditions_is'] ) {
				if ( ! empty( $category['product_fees_conditions_values'] ) ) {
					foreach ( $category['product_fees_conditions_values'] as $category_id ) {
						settype( $category_id, 'integer' );
						if ( in_array( $category_id, $get_cat_all, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_category'] = 'yes';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_category'] = 'no';
						}
					}
				}
			}
			if ( 'not_in' === $category['product_fees_conditions_is'] ) {
				if ( ! empty( $category['product_fees_conditions_values'] ) ) {
					foreach ( $category['product_fees_conditions_values'] as $category_id ) {
						settype( $category_id, 'integer' );
						if ( in_array( $category_id, $get_cat_all, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_category'] = 'no';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_category'] = 'yes';
						}
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_category', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match user role rules
	 *
	 * @param array  $user_role_array
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 *
	 * @since    1.3.3
	 *
	 * @uses     is_user_logged_in()
	 *
	 */
	public function wcpfc_pro_match_user_role_rule__premium_only( $user_role_array, $general_rule_match ) {
		/**
		 * check user loggedin or not
		 */
		global $current_user;
		if ( is_user_logged_in() ) {
			$current_user_role = $current_user->roles[0];
		} else {
			$current_user_role = 'guest';
		}
		$is_passed = array();
		foreach ( $user_role_array as $key => $user_role ) {
			if ( 'is_equal_to' === $user_role['product_fees_conditions_is'] ) {
				if ( in_array( $current_user_role, $user_role['product_fees_conditions_values'], true ) ) {
					$is_passed[ $key ]['has_fee_based_on_user_role'] = 'yes';
				} else {
					$is_passed[ $key ]['has_fee_based_on_user_role'] = 'no';
				}
			}
			if ( 'not_in' === $user_role['product_fees_conditions_is'] ) {
				if ( in_array( $current_user_role, $user_role['product_fees_conditions_values'], true ) ) {
					$is_passed[ $key ]['has_fee_based_on_user_role'] = 'no';
				} else {
					$is_passed[ $key ]['has_fee_based_on_user_role'] = 'yes';
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_user_role', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match coupon role rules
	 *
	 * @param string $wc_curr_version
	 * @param array  $coupon_array
	 * @param string $general_rule_match
	 *
	 * @return string $main_is_passed
	 *
	 * @since    1.3.3
	 *
	 * @uses     WC_Cart::get_coupons()
	 * @uses     WC_Coupon::is_valid()
	 *
	 */
	public function wcpfc_pro_match_coupon_rule__premium_only( $wc_curr_version, $coupon_array, $general_rule_match ) {
		global $woocommerce;
		if ( $wc_curr_version >= 3.0 ) {
			$cart_coupon = WC()->cart->get_coupons();
		} else {
			$cart_coupon = isset( $woocommerce->cart->coupons ) && ! empty( $woocommerce->cart->coupons ) ? $woocommerce->cart->coupons : array();
		}
		$couponId  = array();
		$is_passed = array();
		foreach ( $cart_coupon as $cartCoupon ) {
			if ( $cartCoupon->is_valid() && isset( $cartCoupon ) && ! empty( $cartCoupon ) ) {
				if ( $wc_curr_version >= 3.0 ) {
					$couponId[] = $cartCoupon->get_id();
				} else {
					$couponId[] = $cartCoupon->id;
				}
			}
		}
		foreach ( $coupon_array as $key => $coupon ) {
			if ( 'is_equal_to' === $coupon['product_fees_conditions_is'] ) {
				if ( ! empty( $coupon['product_fees_conditions_values'] ) ) {
					foreach ( $coupon['product_fees_conditions_values'] as $coupon_id ) {
						settype( $coupon_id, 'integer' );
						if ( in_array( $coupon_id, $couponId, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_coupon'] = 'yes';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_coupon'] = 'no';
						}
					}
				}
			}
			if ( 'not_in' === $coupon['product_fees_conditions_is'] ) {
				if ( ! empty( $coupon['product_fees_conditions_values'] ) ) {
					foreach ( $coupon['product_fees_conditions_values'] as $coupon_id ) {
						settype( $coupon_id, 'integer' );
						if ( in_array( $coupon_id, $couponId, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_coupon'] = 'no';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_coupon'] = 'yes';
						}
					}
				}
				if ( empty( $cart_coupon ) ) {
					return 'yes';
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_coupon', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match rule based on cart subtotal after discount
	 *
	 * @param string $wc_curr_version
	 * @param array  $cart_totalafter_array
	 *
	 * @return array $is_passed
	 * @uses     WC_Cart::get_total_discount()
	 *
	 * @since    1.3.3
	 *
	 * @uses     wcpfc_pro_remove_currency_symbol()
	 * @uses     WC_Cart::get_subtotal()
	 */
	public function wcpfc_pro_match_cart_subtotal_after_discount_rule__premium_only( $wc_curr_version, $cart_totalafter_array, $general_rule_match ) {
		global $woocommerce, $woocommerce_wpml;
		if ( $wc_curr_version >= 3.0 ) {
			$totalprice = $this->wcpfc_pro_get_cart_subtotal();
		} else {
			$totalprice = $this->wcpfc_pro_remove_currency_symbol( $woocommerce->cart->get_cart_subtotal() );
		}
		if ( $wc_curr_version >= 3.0 ) {
			$totaldisc = $this->wcpfc_pro_remove_currency_symbol( WC()->cart->get_total_discount() );
		} else {
			$totaldisc = $this->wcpfc_pro_remove_currency_symbol( $woocommerce->cart->get_total_discount() );
		}
		$is_passed = array();
		if ( '' !== $totaldisc && 0.0 !== $totaldisc ) {
			$resultprice = $totalprice - $totaldisc;
			if ( isset( $woocommerce_wpml ) && ! empty( $woocommerce_wpml->multi_currency ) ) {
				$new_resultprice = $woocommerce_wpml->multi_currency->prices->unconvert_price_amount( $resultprice );
			} else {
				$new_resultprice = $resultprice;
			}
			foreach ( $cart_totalafter_array as $key => $cart_totalafter ) {
				settype( $cart_totalafter['product_fees_conditions_values'], 'float' );
				if ( 'is_equal_to' === $cart_totalafter['product_fees_conditions_is'] ) {
					if ( ! empty( $cart_totalafter['product_fees_conditions_values'] ) ) {
						if ( $cart_totalafter['product_fees_conditions_values'] === $new_resultprice ) {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'yes';
						} else {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'no';
						}
					}
				}
				if ( 'less_equal_to' === $cart_totalafter['product_fees_conditions_is'] ) {
					if ( ! empty( $cart_totalafter['product_fees_conditions_values'] ) ) {
						if ( $cart_totalafter['product_fees_conditions_values'] >= $new_resultprice ) {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'yes';
						} else {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'no';
						}
					}
				}
				if ( 'less_then' === $cart_totalafter['product_fees_conditions_is'] ) {
					if ( ! empty( $cart_totalafter['product_fees_conditions_values'] ) ) {
						if ( $cart_totalafter['product_fees_conditions_values'] > $new_resultprice ) {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'yes';
						} else {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'no';
						}
					}
				}
				if ( 'greater_equal_to' === $cart_totalafter['product_fees_conditions_is'] ) {
					if ( ! empty( $cart_totalafter['product_fees_conditions_values'] ) ) {
						if ( $cart_totalafter['product_fees_conditions_values'] <= $new_resultprice ) {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'yes';
						} else {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'no';
						}
					}
				}
				if ( 'greater_then' === $cart_totalafter['product_fees_conditions_is'] ) {
					if ( ! empty( $cart_totalafter['product_fees_conditions_values'] ) ) {
						if ( $cart_totalafter['product_fees_conditions_values'] < $new_resultprice ) {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'yes';
						} else {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'no';
						}
					}
				}
				if ( 'not_in' === $cart_totalafter['product_fees_conditions_is'] ) {
					if ( ! empty( $cart_totalafter['product_fees_conditions_values'] ) ) {
						if ( $new_resultprice === $cart_totalafter['product_fees_conditions_values'] ) {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'no';
						} else {
							$is_passed[ $key ]['has_fee_based_on_cart_totalafter'] = 'yes';
						}
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_cart_totalafter', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Remove WooCommerce currency symbol
	 *
	 * @param float $price
	 *
	 * @return float $new_price2
	 * @since  1.0.0
	 *
	 * @uses   get_woocommerce_currency_symbol()
	 *
	 */
	public function wcpfc_pro_remove_currency_symbol( $price ) {
		$wc_currency_symbol = get_woocommerce_currency_symbol();
		$new_price          = str_replace( $wc_currency_symbol, '', $price );
		$new_price2         = (double) preg_replace( '/[^.\d]/', '', $new_price );

		return $new_price2;
	}

	/**
	 * Match rule based on total cart weight
	 *
	 * @param array $weight_array
	 *
	 * @return array $is_passed
	 * @since    1.3.3
	 *
	 * @uses     WC_Cart::get_cart()
	 *
	 */
	public function wcpfc_pro_match_cart_total_weight_rule__premium_only( $cart_array, $weight_array, $general_rule_match ) {
		$weight_total = 0;
		foreach ( $cart_array as $woo_cart_item ) {
			if ( ! empty( $woo_cart_item['variation_id'] ) || 0 !== $woo_cart_item['variation_id'] ) {
				$product_id_lan = $woo_cart_item['variation_id'];
			} else {
				$product_id_lan = $woo_cart_item['product_id'];
			}
			$_product     = wc_get_product( $product_id_lan );
			$weight_total += intval( $woo_cart_item['quantity'] ) * floatval( $_product->get_weight() );
		}
		$is_passed = array();
		foreach ( $weight_array as $key => $weight ) {
			settype( $weight_total, 'float' );
			settype( $weight['product_fees_conditions_values'], 'float' );
			if ( 'is_equal_to' === $weight['product_fees_conditions_is'] ) {
				if ( ! empty( $weight['product_fees_conditions_values'] ) ) {
					if ( $weight_total === $weight['product_fees_conditions_values'] ) {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'no';
					}
				}
			}
			if ( 'less_equal_to' === $weight['product_fees_conditions_is'] ) {
				if ( ! empty( $weight['product_fees_conditions_values'] ) ) {
					if ( $weight['product_fees_conditions_values'] >= $weight_total ) {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'no';
					}
				}
			}
			if ( 'less_then' === $weight['product_fees_conditions_is'] ) {
				if ( ! empty( $weight['product_fees_conditions_values'] ) ) {
					if ( $weight['product_fees_conditions_values'] > $weight_total ) {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'no';
					}
				}
			}
			if ( 'greater_equal_to' === $weight['product_fees_conditions_is'] ) {
				if ( ! empty( $weight['product_fees_conditions_values'] ) ) {
					if ( $weight['product_fees_conditions_values'] <= $weight_total ) {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'no';
					}
				}
			}
			if ( 'greater_then' === $weight['product_fees_conditions_is'] ) {
				if ( ! empty( $weight['product_fees_conditions_values'] ) ) {
					if ( $weight_total > $weight['product_fees_conditions_values'] ) {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'no';
					}
				}
			}
			if ( 'not_in' === $weight['product_fees_conditions_is'] ) {
				if ( ! empty( $weight['product_fees_conditions_values'] ) ) {
					if ( $weight_total === $weight['product_fees_conditions_values'] ) {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'no';
					} else {
						$is_passed[ $key ]['has_fee_based_on_weight'] = 'yes';
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_weight', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match rule based on shipping class
	 *
	 * @param array $cart_array
	 * @param array $shipping_class_array
	 *
	 * @return array $is_passed
	 * @since    1.3.3
	 *
	 * @uses     get_the_terms()
	 * @uses     wcpfc_pro_array_flatten()
	 *
	 */
	public function wcpfc_pro_match_shipping_class_rule__premium_only( $cart_product_ids_array, $shipping_class_array, $general_rule_match ) {
		$shippingclass = array();
		foreach ( $cart_product_ids_array as $product ) {
			$get_shipping_class = wp_get_post_terms( $product, 'product_shipping_class', array( 'fields' => 'ids' ) );
			if ( isset( $get_shipping_class ) && ! empty( $get_shipping_class ) && is_array( $get_shipping_class ) ) {
				$shippingclass[] = $get_shipping_class;
			}
		}
		$get_shipping_class_all = array_unique( $this->wcpfc_pro_array_flatten( $shippingclass ) );
		$is_passed              = array();
		foreach ( $shipping_class_array as $key => $shipping_class ) {
			if ( 'is_equal_to' === $shipping_class['product_fees_conditions_is'] ) {
				if ( ! empty( $shipping_class['product_fees_conditions_values'] ) ) {
					foreach ( $shipping_class['product_fees_conditions_values'] as $shipping_class_slug ) {
						$shipping_class_id = $shipping_class_slug;
						settype( $shipping_class_id, 'integer' );
						if ( in_array( $shipping_class_id, $get_shipping_class_all, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_shipping_class'] = 'yes';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_shipping_class'] = 'no';
						}
					}
				}
			}
			if ( 'not_in' === $shipping_class['product_fees_conditions_is'] ) {
				if ( ! empty( $shipping_class['product_fees_conditions_values'] ) ) {
					foreach ( $shipping_class['product_fees_conditions_values'] as $shipping_class_slug ) {
						$shipping_class_id = $shipping_class_slug;
						settype( $shipping_class_id, 'integer' );
						if ( in_array( $shipping_class_id, $get_shipping_class_all, true ) ) {
							$is_passed[ $key ]['has_fee_based_on_shipping_class'] = 'no';
							break;
						} else {
							$is_passed[ $key ]['has_fee_based_on_shipping_class'] = 'yes';
						}
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_shipping_class', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match rule based on payment gateway
	 *
	 * @param int   $wc_curr_version
	 * @param array $payment_gateway
	 *
	 * @return array $is_passed
	 * @since    1.3.3
	 *
	 */
	public function wcpfc_pro_match_payment_gateway_rule__premium_only( $payment_methods_array, $general_rule_match ) {
		$is_passed             = array();
		$chosen_payment_method = WC()->session->get( 'chosen_payment_method' );
		if ( ! empty( $payment_methods_array ) ) {
			foreach ( $payment_methods_array as $key => $payment ) {
				if ( $payment['product_fees_conditions_is'] === 'is_equal_to' ) {
					if ( in_array( $chosen_payment_method, $payment['product_fees_conditions_values'], true ) ) {
						$is_passed[ $key ]['has_fee_based_on_payment'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_payment'] = 'no';
					}
				}
				if ( $payment['product_fees_conditions_is'] === 'not_in' ) {
					if ( in_array( $chosen_payment_method, $payment['product_fees_conditions_values'], true ) ) {
						$is_passed[ $key ]['has_fee_based_on_payment'] = 'no';
					} else {
						$is_passed[ $key ]['has_fee_based_on_payment'] = 'yes';
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_payment', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match rule based on shipping method
	 *
	 * @param int   $wc_curr_version
	 * @param array $shipping_methods
	 *
	 * @return array $is_passed
	 * @since    1.3.3
	 *
	 */
	public function wcpfc_pro_match_shipping_method_rule__premium_only( $wc_curr_version, $shipping_methods, $general_rule_match ) {
		global $woocommerce;
		$is_passed = array();
		if ( $wc_curr_version >= 3.0 ) {
			$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );
		} else {
			$chosen_shipping_methods = $woocommerce->session->chosen_shipping_methods;
		}
		if ( ! empty( $chosen_shipping_methods ) ) {
			$chosen_shipping_methods_explode = explode( ':', $chosen_shipping_methods[0] );
			foreach ( $shipping_methods as $key => $method ) {
				if ( 'is_equal_to' === $method['product_fees_conditions_is'] ) {
					if ( in_array( $chosen_shipping_methods_explode[0], $method['product_fees_conditions_values'], true ) ) {
						$is_passed[ $key ]['has_fee_based_on_shipping_method'] = 'yes';
					} else {
						$is_passed[ $key ]['has_fee_based_on_shipping_method'] = 'no';
					}
				}
				if ( 'not_in' === $method['product_fees_conditions_is'] ) {
					if ( in_array( $chosen_shipping_methods_explode[0], $method['product_fees_conditions_values'], true ) ) {
						$is_passed[ $key ]['has_fee_based_on_shipping_method'] = 'no';
					} else {
						$is_passed[ $key ]['has_fee_based_on_shipping_method'] = 'yes';
					}
				}
			}
		}
		$main_is_passed = $this->wcpfc_pro_check_all_passed_general_rule( $is_passed, 'has_fee_based_on_shipping_method', $general_rule_match );

		return $main_is_passed;
	}

	/**
	 * Match product per qty rules
	 *
	 * @param array  $get_condition_array_ap_product
	 * @param array  $cart_products_array
	 * @param string $default_lang
	 *
	 * @return array $is_passed_advance_rule
	 * @since    1.3.3
	 *
	 * @uses     wcpfc_count_qty_for_product()
	 *
	 */
	public function wcpfc_pro_match_product_per_qty__premium_only( $get_condition_array_ap_product, $woo_cart_array, $sitepress, $default_lang, $cost_on_product_rule_match ) {
		if ( ! empty( $woo_cart_array ) ) {
			$is_passed_from_here_prd = array();
			if ( ! empty( $get_condition_array_ap_product ) || '' !== $get_condition_array_ap_product ) {
				foreach ( $get_condition_array_ap_product as $key => $get_condition ) {
					if ( ! empty( $get_condition['ap_fees_products'] ) || '' !== $get_condition['ap_fees_products'] ) {
						$total_qws                 = $this->wcpfc_get_count_qty__premium_only(
							$get_condition['ap_fees_products'], $woo_cart_array, $sitepress, $default_lang, 'product', 'qty'
						);
						$get_min_max               = $this->wcpfc_check_min_max_qws__premium_only(
							$get_condition['ap_fees_ap_prd_min_qty'], $get_condition['ap_fees_ap_prd_max_qty'], $get_condition['ap_fees_ap_price_product'], 'qty'
						);
						$is_passed_from_here_prd[] = $this->wcpfc_check_passed_rule__premium_only(
							$key, $get_min_max['min'], $get_min_max['max'], 'has_fee_based_on_cost_per_prd_qty', 'has_fee_based_on_cost_per_prd_price', $get_condition['ap_fees_ap_price_product'], $total_qws, 'qty'
						);
					}
				}
			}
			$main_is_passed = $this->wcpfc_pro_check_all_passed_advance_rule__premium_only(
				$is_passed_from_here_prd, 'has_fee_based_on_cost_per_prd_qty', 'has_fee_based_on_cost_per_prd_price', $cost_on_product_rule_match
			);

			return $main_is_passed;
		}
	}

	/**
	 * Count qty for Product, Category and Total Cart
	 *
	 * @param array  $ap_selected_id
	 * @param array  $woo_cart_array
	 * @param string $sitepress
	 * @param string $default_lang
	 * @param string $type
	 * @param string $qws
	 *
	 * @return int $total
	 *
	 * @since 3.6
	 *
	 * @uses  wc_get_product()
	 * @uses  WC_Product::is_type()
	 * @uses  wp_get_post_terms()
	 * @uses  wcpfc_get_prd_category_from_cart__premium_only()
	 *
	 */
	public function wcpfc_get_count_qty__premium_only( $ap_selected_id, $woo_cart_array, $sitepress, $default_lang, $type, $qws ) {
		$total_qws = 0;
		if ( 'shipping_class' !== $type ) {
			$ap_selected_id = array_map( 'intval', $ap_selected_id );
		}
		foreach ( $woo_cart_array as $woo_cart_item ) {
			$main_product_id_lan = $woo_cart_item['product_id'];
			if ( ! empty( $woo_cart_item['variation_id'] ) || 0 !== $woo_cart_item['variation_id'] ) {
				$product_id_lan = $woo_cart_item['variation_id'];
			} else {
				$product_id_lan = $woo_cart_item['product_id'];
			}
			$_product = wc_get_product( $product_id_lan );
			if ( ! empty( $sitepress ) ) {
				$product_id_lan = intval( apply_filters( 'wpml_object_id', $product_id_lan, 'product', true, $default_lang ) );
			} else {
				$product_id_lan = intval( $product_id_lan );
			}
			if ( 'product' === $type ) {
				if ( in_array( $product_id_lan, $ap_selected_id, true ) ) {
					if ( 'qty' === $qws ) {
						$total_qws += intval( $woo_cart_item['quantity'] );
					}
					if ( 'weight' === $qws ) {
						$total_qws += intval( $woo_cart_item['quantity'] ) * floatval( $_product->get_weight() );
					}
					if ( 'subtotal' === $qws ) {
						if ( ! empty( $woo_cart_item['line_tax'] ) ) {
							$woo_cart_item['line_tax'] = $woo_cart_item['line_tax'];
						}
						$total_qws += $this->wcpfc_pro_get_specific_subtotal__premium_only( $woo_cart_item['line_subtotal'], $woo_cart_item['line_tax'] );
					}
				}
			}
			if ( 'category' === $type ) {
				$cat_id_list        = wp_get_post_terms( $main_product_id_lan, 'product_cat', array( 'fields' => 'ids' ) );
				$cat_id_list_origin = $this->wcpfc_get_prd_category_from_cart__premium_only( $cat_id_list, $sitepress, $default_lang );
				if ( ! empty( $cat_id_list_origin ) && is_array( $cat_id_list_origin ) ) {
					foreach ( $ap_selected_id as $ap_fees_categories_key_val ) {
						if ( in_array( $ap_fees_categories_key_val, $cat_id_list_origin, true ) ) {
							if ( 'qty' === $qws ) {
								$total_qws += intval( $woo_cart_item['quantity'] );
							}
							if ( 'weight' === $qws ) {
								$total_qws += intval( $woo_cart_item['quantity'] ) * floatval( $_product->get_weight() );
							}
							if ( 'subtotal' === $qws ) {
								if ( ! empty( $woo_cart_item['line_tax'] ) ) {
									$woo_cart_item['line_tax'] = $woo_cart_item['line_tax'];
								}
								$total_qws += $this->wcpfc_pro_get_specific_subtotal__premium_only( $woo_cart_item['line_subtotal'], $woo_cart_item['line_tax'] );
							}
							break;
						}
					}
				}
			}
			if ( 'shipping_class' === $type ) {
				$prd_shipping_class = $_product->get_shipping_class();
				if ( in_array( $prd_shipping_class, $ap_selected_id, true ) ) {
					if ( 'qty' === $qws ) {
						$total_qws += intval( $woo_cart_item['quantity'] );
					}
					if ( 'weight' === $qws ) {
						$total_qws += intval( $woo_cart_item['quantity'] ) * floatval( $_product->get_weight() );
					}
					if ( 'subtotal' === $qws ) {
						if ( ! empty( $woo_cart_item['line_tax'] ) ) {
							$woo_cart_item['line_tax'] = $woo_cart_item['line_tax'];
						}
						$total_qws += $this->wcpfc_pro_get_specific_subtotal__premium_only( $woo_cart_item['line_subtotal'], $woo_cart_item['line_tax'] );
					}
				}
			}
		}

		return $total_qws;
	}

	/**
	 * Get specific subtotal for product and category
	 *
	 * @return float $subtotal
	 *
	 * @since    3.6
	 */
	public function wcpfc_pro_get_specific_subtotal__premium_only( $line_total, $line_tax ) {
		$get_customer            = WC()->cart->get_customer();
		$get_customer_vat_exempt = WC()->customer->get_is_vat_exempt();
		$tax_display_cart        = WC()->cart->tax_display_cart;
		$wc_prices_include_tax   = wc_prices_include_tax();
		$tax_enable              = wc_tax_enabled();
		$cart_subtotal           = 0;
		if ( true === $tax_enable ) {
			if ( true === $wc_prices_include_tax ) {
				if ( 'incl' === $tax_display_cart && ! ( $get_customer && $get_customer_vat_exempt ) ) {
					$cart_subtotal += $line_total + $line_tax;
				} else {
					$cart_subtotal += $line_total;
				}
			} else {
				if ( 'incl' === $tax_display_cart && ! ( $get_customer && $get_customer_vat_exempt ) ) {
					$cart_subtotal += $line_total + $line_tax;
				} else {
					$cart_subtotal += $line_total;
				}
			}
		} else {
			$cart_subtotal += $line_total;
		}

		return $cart_subtotal;
	}

	/**
	 * Get Product category from cart
	 *
	 * @param array  $cat_id_list
	 * @param string $sitepress
	 * @param string $default_lang
	 *
	 * @return array $cat_id_list_origin
	 *
	 * @since 3.6
	 *
	 */
	public function wcpfc_get_prd_category_from_cart__premium_only( $cat_id_list, $sitepress, $default_lang ) {
		$cat_id_list_origin = array();
		if ( isset( $cat_id_list ) && ! empty( $cat_id_list ) ) {
			foreach ( $cat_id_list as $cat_id ) {
				if ( ! empty( $sitepress ) ) {
					$cat_id_list_origin[] = (int) apply_filters( 'wpml_object_id', $cat_id, 'product_cat', true, $default_lang );
				} else {
					$cat_id_list_origin[] = (int) $cat_id;
				}
			}
		}

		return $cat_id_list_origin;
	}

	/**
	 * Check Min and max qty, weight and subtotal
	 *
	 * @param int|float $min
	 * @param int|float $max
	 * @param float     $price
	 * @param string    $qws
	 *
	 * @return array
	 *
	 * @since 3.4
	 *
	 */
	public function wcpfc_check_min_max_qws__premium_only( $min, $max, $price, $qws ) {
		$min_val = $min;
		if ( '' === $max || '0' === $max ) {
			$max_val = 2000000000;
		} else {
			$max_val = $max;
		}
		$price_val = $price;
		if ( 'qty' === $qws ) {
			settype( $min_val, 'integer' );
			settype( $max_val, 'integer' );
		} else {
			settype( $min_val, 'float' );
			settype( $max_val, 'float' );
		}

		return array(
			'min'   => $min_val,
			'max'   => $max_val,
			'price' => $price_val,
		);
	}

	/**
	 * Cgeck rule passed or not
	 *
	 * @param string    $key
	 * @param string    $min
	 * @param string    $max
	 * @param string    $hbc
	 * @param string    $hbp
	 * @param float     $price
	 * @param int|float $total_qws
	 * @param string    $qws
	 *
	 * @return array
	 * @since    3.6
	 *
	 */
	public function wcpfc_check_passed_rule__premium_only( $key, $min, $max, $hbc, $hbp, $price, $total_qws, $qws ) {
		$is_passed_from_here_prd = array();
		if ( ( $min <= $total_qws ) && ( $total_qws <= $max ) ) {
			$is_passed_from_here_prd[ $hbc ][ $key ] = 'yes';
			$is_passed_from_here_prd[ $hbp ][ $key ] = $price;
		} else {
			$is_passed_from_here_prd[ $hbc ][ $key ] = 'no';
			$is_passed_from_here_prd[ $hbp ][ $key ] = $price;
		}

		return $is_passed_from_here_prd;
	}

	/*
     * Get WooCommerce version number
     *
     * @since 1.0.0
     *
     * @return string if file is not exists then it will return null
     */

	/**
	 * Find unique id based on given array
	 *
	 * @param array  $is_passed
	 * @param string $has_fee_checked
	 * @param string $has_fee_based
	 * @param string $advance_inside_rule_match
	 *
	 * @return array
	 * @since    3.6
	 *
	 */
	public function wcpfc_pro_check_all_passed_advance_rule__premium_only( $is_passed, $has_fee_checked, $has_fee_based, $advance_inside_rule_match ) {
		$get_cart_total = WC()->cart->get_cart_contents_total();
		$main_is_passed = 'no';
		$flag           = array();
		$sum_ammount    = 0;
		if ( ! empty( $is_passed ) ) {
			foreach ( $is_passed as $main_is_passed ) {
				foreach ( $main_is_passed[ $has_fee_checked ] as $key => $is_passed_value ) {
					if ( 'yes' === $is_passed_value ) {
						foreach ( $main_is_passed[ $has_fee_based ] as $hfb_key => $hfb_is_passed_value ) {
							if ( $hfb_key === $key ) {
								$final_price = $this->wcpfc_check_percantage_price__premium_only( $hfb_is_passed_value, $get_cart_total );
								$sum_ammount += $final_price;
							}
						}
						$flag[ $key ] = true;
					} else {
						$flag[ $key ] = false;
					}
				}
			}
			if ( 'any' === $advance_inside_rule_match ) {
				if ( in_array( true, $flag, true ) ) {
					$main_is_passed = 'yes';
				} else {
					$main_is_passed = 'no';
				}
			} else {
				if ( in_array( false, $flag, true ) ) {
					$main_is_passed = 'no';
				} else {
					$main_is_passed = 'yes';
				}
			}
		}

		return array(
			'flag'         => $main_is_passed,
			'total_amount' => $sum_ammount,
		);
	}

	/**
	 * Add shipping rate
	 *
	 * @param int|float $min
	 * @param int|float $max
	 * @param float     $price
	 * @param int|float $count_total
	 * @param float     $get_cart_total
	 * @param float     $shipping_rate_cost
	 *
	 * @return float $shipping_rate_cost
	 *
	 * @since 3.4
	 *
	 */
	public function wcpfc_check_percantage_price__premium_only( $price, $get_cart_total ) {
		if ( ! empty( $price ) ) {
			$is_percent = substr( $price, - 1 );
			if ( '%' === $is_percent ) {
				$percent = substr( $price, 0, - 1 );
				$percent = number_format( $percent, 2, '.', '' );
				if ( ! empty( $percent ) ) {
					$percent_total = ( $percent / 100 ) * $get_cart_total;
					$price         = $percent_total;
				}
			} else {
				$price = $this->wcpfc_pro_price_format( $price );
			}
		}

		return $price;
	}

	/**
	 * Price format
	 *
	 * @param string $price
	 *
	 * @return string $price
	 * @since  1.3.3
	 *
	 */
	public function wcpfc_pro_price_format( $price ) {
		$price = floatval( $price );

		return $price;
	}

	/**
	 * Cost for Product subtotal in advance pricing rules
	 *
	 * @param array  $get_condition_array_ap_product_subtotal
	 * @param array  $woo_cart_array
	 * @param string $sitepress
	 * @param string $default_lang
	 * @param string $cost_on_product_subtotal_rule_match
	 *
	 * @return array $main_is_passed
	 * @since 3.6
	 *
	 * @uses  WC_Cart::get_cart_contents_total()
	 * @uses  wp_get_post_terms()
	 * @uses  wc_get_product()
	 *
	 */
	public function wcpfc_pro_match_product_subtotal__premium_only( $get_condition_array_ap_product_subtotal, $woo_cart_array, $cost_on_product_subtotal_rule_match, $sitepress, $default_lang ) {
		if ( ! empty( $woo_cart_array ) ) {
			$is_passed_from_here_ps = array();
			if ( ! empty( $get_condition_array_ap_product_subtotal ) || '' !== $get_condition_array_ap_product_subtotal ) {
				foreach ( $get_condition_array_ap_product_subtotal as $key => $get_condition ) {
					$total_qws                = $this->wcpfc_get_count_qty__premium_only(
						$get_condition['ap_fees_product_subtotal'], $woo_cart_array, $sitepress, $default_lang, 'product', 'subtotal'
					);
					$get_min_max              = $this->wcpfc_check_min_max_qws__premium_only(
						$get_condition['ap_fees_ap_product_subtotal_min_subtotal'], $get_condition['ap_fees_ap_product_subtotal_max_subtotal'], $get_condition['ap_fees_ap_price_product_subtotal'], 'subtotal'
					);
					$is_passed_from_here_ps[] = $this->wcpfc_check_passed_rule__premium_only(
						$key, $get_min_max['min'], $get_min_max['max'], 'has_fee_based_on_ps', 'has_fee_based_on_ps_price', $get_condition['ap_fees_ap_price_product_subtotal'], $total_qws, 'subtotal'
					);
				}
			}
			$main_is_passed = $this->wcpfc_pro_check_all_passed_advance_rule__premium_only(
				$is_passed_from_here_ps, 'has_fee_based_on_ps', 'has_fee_based_on_ps_price', $cost_on_product_subtotal_rule_match
			);

			return $main_is_passed;
		}
	}

	/**
	 * Match product per weight rules
	 *
	 * @param array  $get_condition_array_ap_product_weight
	 * @param array  $cart_products_array
	 * @param string $default_lang
	 *
	 * @return array $is_passed_advance_rule
	 * @since    1.3.3
	 *
	 * @uses     wcpfc_pro_count_weight_for_product__premium_only()
	 *
	 */
	public function wcpfc_pro_match_product_per_weight__premium_only( $get_condition_array_ap_product_weight, $woo_cart_array, $sitepress, $default_lang, $cost_on_product_weight_rule_match ) {
		if ( ! empty( $woo_cart_array ) ) {
			$is_passed_from_here_prd = array();
			if ( ! empty( $get_condition_array_ap_product_weight ) || '' !== $get_condition_array_ap_product_weight ) {
				foreach ( $get_condition_array_ap_product_weight as $key => $get_condition ) {
					if ( ! empty( $get_condition['ap_fees_product_weight'] ) || '' !== $get_condition['ap_fees_product_weight'] ) {
						$total_qws                 = $this->wcpfc_get_count_qty__premium_only(
							$get_condition['ap_fees_product_weight'], $woo_cart_array, $sitepress, $default_lang, 'product', 'weight'
						);
						$get_min_max               = $this->wcpfc_check_min_max_qws__premium_only(
							$get_condition['ap_fees_ap_product_weight_min_qty'], $get_condition['ap_fees_ap_product_weight_max_qty'], $get_condition['ap_fees_ap_price_product_weight'], 'weight'
						);
						$is_passed_from_here_prd[] = $this->wcpfc_check_passed_rule__premium_only(
							$key, $get_min_max['min'], $get_min_max['max'], 'has_fee_based_on_cost_ppw', 'has_fee_based_on_cost_ppw_price', $get_condition['ap_fees_ap_price_product_weight'], $total_qws, 'weight'
						);
					}
				}
			}
			$main_is_passed = $this->wcpfc_pro_check_all_passed_advance_rule__premium_only(
				$is_passed_from_here_prd, 'has_fee_based_on_cost_ppw', 'has_fee_based_on_cost_ppw_price', $cost_on_product_weight_rule_match
			);

			return $main_is_passed;
		}
	}

	/**
	 * Match category per qty rules
	 *
	 * @param array  $get_condition_array_ap_category
	 * @param array  $cart_products_array
	 * @param string $default_lang
	 *
	 * @return array $is_passed_advance_rule
	 * @uses     wcpfc_pro_count_qty_for_category__premium_only()
	 *
	 * @since    1.3.3
	 *
	 * @uses     WC_Cart::get_cart()
	 * @uses     wp_get_post_terms()
	 * @uses     wcpfc_pro_array_flatten()
	 */
	public function wcpfc_pro_match_category_per_qty__premium_only( $get_condition_array_ap_category, $woo_cart_array, $sitepress, $default_lang, $cost_on_category_rule_match ) {
		if ( ! empty( $woo_cart_array ) ) {
			$is_passed_from_here_cat = array();
			if ( ! empty( $get_condition_array_ap_category ) || '' !== $get_condition_array_ap_category ) {
				foreach ( $get_condition_array_ap_category as $key => $get_condition ) {
					if ( ! empty( $get_condition['ap_fees_categories'] ) || '' !== $get_condition['ap_fees_categories'] ) {
						$total_qws                 = $this->wcpfc_get_count_qty__premium_only(
							$get_condition['ap_fees_categories'], $woo_cart_array, $sitepress, $default_lang, 'category', 'qty'
						);
						$get_min_max               = $this->wcpfc_check_min_max_qws__premium_only(
							$get_condition['ap_fees_ap_cat_min_qty'], $get_condition['ap_fees_ap_cat_max_qty'], $get_condition['ap_fees_ap_price_category'], 'qty'
						);
						$is_passed_from_here_cat[] = $this->wcpfc_check_passed_rule__premium_only(
							$key, $get_min_max['min'], $get_min_max['max'], 'has_fee_based_on_per_category', 'has_fee_based_on_cost_per_cat_price', $get_condition['ap_fees_ap_price_category'], $total_qws, 'qty'
						);
					}
				}
			}
			$main_is_passed = $this->wcpfc_pro_check_all_passed_advance_rule__premium_only(
				$is_passed_from_here_cat, 'has_fee_based_on_per_category', 'has_fee_based_on_cost_per_cat_price', $cost_on_category_rule_match
			);

			return $main_is_passed;
		}
	}

	/**
	 * Cost for Category subtotal in advance pricing rules
	 *
	 * @param array  $get_condition_array_ap_category_subtotal
	 * @param array  $woo_cart_array
	 * @param string $sitepress
	 * @param string $default_lang
	 * @param string $cost_on_category_subtotal_rule_match
	 *
	 * @return array $main_is_passed
	 * @since 3.6
	 *
	 * @uses  WC_Cart::get_cart_contents_total()
	 * @uses  wp_get_post_terms()
	 * @uses  wc_get_product()
	 *
	 */
	public function wcpfc_pro_match_category_subtotal__premium_only( $get_condition_array_ap_category_subtotal, $woo_cart_array, $cost_on_category_subtotal_rule_match, $sitepress, $default_lang ) {
		if ( ! empty( $woo_cart_array ) ) {
			$is_passed_from_here_cs = array();
			if ( ! empty( $get_condition_array_ap_category_subtotal ) || '' !== $get_condition_array_ap_category_subtotal ) {
				foreach ( $get_condition_array_ap_category_subtotal as $key => $get_condition ) {
					$total_qws                = $this->wcpfc_get_count_qty__premium_only(
						$get_condition['ap_fees_category_subtotal'], $woo_cart_array, $sitepress, $default_lang, 'category', 'subtotal'
					);
					$get_min_max              = $this->wcpfc_check_min_max_qws__premium_only(
						$get_condition['ap_fees_ap_category_subtotal_min_subtotal'], $get_condition['ap_fees_ap_category_subtotal_max_subtotal'], $get_condition['ap_fees_ap_price_category_subtotal'], 'subtotal'
					);
					$is_passed_from_here_cs[] = $this->wcpfc_check_passed_rule__premium_only(
						$key, $get_min_max['min'], $get_min_max['max'], 'has_fee_based_on_cs', 'has_fee_based_on_cs_price', $get_condition['ap_fees_ap_price_category_subtotal'], $total_qws, 'subtotal'
					);
				}
			}
			$main_is_passed = $this->wcpfc_pro_check_all_passed_advance_rule__premium_only(
				$is_passed_from_here_cs, 'has_fee_based_on_cs', 'has_fee_based_on_cs_price', $cost_on_category_subtotal_rule_match
			);

			return $main_is_passed;
		}
	}

	/**
	 * Match category per weight rules
	 *
	 * @param array  $get_condition_array_ap_category_weight
	 * @param array  $cart_products_array
	 * @param string $default_lang
	 *
	 * @return array $is_passed_advance_rule
	 * @uses     wcpfc_pro_count_weight_for_category__premium_only()
	 *
	 * @since    1.3.3
	 *
	 * @uses     WC_Cart::get_cart()
	 * @uses     wp_get_post_terms()
	 * @uses     wcpfc_pro_array_flatten()
	 */
	public function wcpfc_pro_match_category_per_weight__premium_only( $get_condition_array_ap_category_weight, $woo_cart_array, $sitepress, $default_lang, $cost_on_category_weight_rule_match ) {
		if ( ! empty( $woo_cart_array ) ) {
			$is_passed_from_here_cat = array();
			if ( ! empty( $get_condition_array_ap_category_weight ) || '' !== $get_condition_array_ap_category_weight ) {
				foreach ( $get_condition_array_ap_category_weight as $key => $get_condition ) {
					if ( ! empty( $get_condition['ap_fees_categories_weight'] ) || '' !== $get_condition['ap_fees_categories_weight'] ) {
						$total_qws                 = $this->wcpfc_get_count_qty__premium_only(
							$get_condition['ap_fees_categories_weight'], $woo_cart_array, $sitepress, $default_lang, 'category', 'weight'
						);
						$get_min_max               = $this->wcpfc_check_min_max_qws__premium_only(
							$get_condition['ap_fees_ap_category_weight_min_qty'], $get_condition['ap_fees_ap_category_weight_max_qty'], $get_condition['ap_fees_ap_price_category_weight'], 'weight'
						);
						$is_passed_from_here_cat[] = $this->wcpfc_check_passed_rule__premium_only(
							$key, $get_min_max['min'], $get_min_max['max'], 'has_fee_based_on_per_cw', 'has_fee_based_on_cost_per_cw', $get_condition['ap_fees_ap_price_category_weight'], $total_qws, 'weight'
						);
					}
				}
			}
			$main_is_passed = $this->wcpfc_pro_check_all_passed_advance_rule__premium_only(
				$is_passed_from_here_cat, 'has_fee_based_on_per_cw', 'has_fee_based_on_cost_per_cw', $cost_on_category_weight_rule_match
			);

			return $main_is_passed;
		}
	}

	/**
	 * Match total cart per qty rules
	 *
	 * @param array $get_condition_array_ap_total_cart_qty
	 * @param array $cart_products_array
	 *
	 * @return array $is_passed_advance_rule
	 * @uses     wcpfc_pro_count_qty_all_cart_product__premium_only()
	 *
	 * @since    1.3.3
	 *
	 */
	public function wcpfc_pro_match_total_cart_qty__premium_only( $get_condition_array_ap_total_cart_qty, $woo_cart_array, $cost_on_total_cart_qty_rule_match ) {
		if ( ! empty( $woo_cart_array ) ) {
			$is_passed_from_here_tcq = array();
			if ( ! empty( $get_condition_array_ap_total_cart_qty ) || '' !== $get_condition_array_ap_total_cart_qty ) {
				foreach ( $get_condition_array_ap_total_cart_qty as $key => $get_condition ) {
					$total_qws = 0;
					foreach ( $woo_cart_array as $woo_cart_item ) {
						$total_qws += $woo_cart_item['quantity'];
					}
					$get_min_max               = $this->wcpfc_check_min_max_qws__premium_only(
						$get_condition['ap_fees_ap_total_cart_qty_min_qty'], $get_condition['ap_fees_ap_total_cart_qty_max_qty'], $get_condition['ap_fees_ap_price_total_cart_qty'], 'qty'
					);
					$is_passed_from_here_tcq[] = $this->wcpfc_check_passed_rule__premium_only(
						$key, $get_min_max['min'], $get_min_max['max'], 'has_fee_based_on_tcq', 'has_fee_based_on_tcq_price', $get_condition['ap_fees_ap_price_total_cart_qty'], $total_qws, 'qty'
					);
				}
			}
			$main_is_passed = $this->wcpfc_pro_check_all_passed_advance_rule__premium_only(
				$is_passed_from_here_tcq, 'has_fee_based_on_tcq', 'has_fee_based_on_tcq_price', $cost_on_total_cart_qty_rule_match
			);

			return $main_is_passed;
		}
	}

	/**
	 * Match total cart weight rules
	 *
	 * @param array $get_condition_array_ap_total_cart_weight
	 * @param array $cart_products_array
	 *
	 * @return array $is_passed_advance_rule
	 * @uses     wcpfc_pro_count_weight_all_cart_product__premium_only()
	 *
	 * @since    1.3.3
	 *
	 */
	public function wcpfc_pro_match_total_cart_weight__premium_only( $get_condition_array_ap_total_cart_weight, $woo_cart_array, $cost_on_total_cart_weight_rule_match ) {
		if ( ! empty( $woo_cart_array ) ) {
			$is_passed_from_here_tcw = array();
			if ( ! empty( $get_condition_array_ap_total_cart_weight ) || '' !== $get_condition_array_ap_total_cart_weight ) {
				foreach ( $get_condition_array_ap_total_cart_weight as $key => $get_condition ) {
					$total_qws = 0;
					foreach ( $woo_cart_array as $woo_cart_item ) {
						if ( ! empty( $woo_cart_item['variation_id'] ) || 0 !== $woo_cart_item['variation_id'] ) {
							$product_id_lan = $woo_cart_item['variation_id'];
						} else {
							$product_id_lan = $woo_cart_item['product_id'];
						}
						$_product = wc_get_product( $product_id_lan );
						if ( ! ( $_product->is_virtual( 'yes' ) ) ) {
							$total_qws += intval( $woo_cart_item['quantity'] ) * floatval( $_product->get_weight() );
						}
					}
					$get_min_max               = $this->wcpfc_check_min_max_qws__premium_only(
						$get_condition['ap_fees_ap_total_cart_weight_min_weight'], $get_condition['ap_fees_ap_total_cart_weight_max_weight'], $get_condition['ap_fees_ap_price_total_cart_weight'], 'weight'
					);
					$is_passed_from_here_tcw[] = $this->wcpfc_check_passed_rule__premium_only(
						$key, $get_min_max['min'], $get_min_max['max'], 'has_fee_based_on_tcw', 'has_fee_based_on_tcw_price', $get_condition['ap_fees_ap_price_total_cart_weight'], $total_qws, 'weight'
					);
				}
			}
			$main_is_passed = $this->wcpfc_pro_check_all_passed_advance_rule__premium_only(
				$is_passed_from_here_tcw, 'has_fee_based_on_tcw', 'has_fee_based_on_tcw_price', $cost_on_total_cart_weight_rule_match
			);

			return $main_is_passed;
		}
	}

	/**
	 * Cost for total cart subtotal in advance pricing rules
	 *
	 * @param array  $get_condition_array_ap_total_cart_subtotal
	 * @param array  $woo_cart_array
	 * @param string $cost_on_total_cart_subtotal_rule_match
	 *
	 * @return array $main_is_passed
	 * @since 3.4
	 *
	 * @uses  WC_Cart::get_cart_contents_total()
	 * @uses  wp_get_post_terms()
	 * @uses  wc_get_product()
	 *
	 */
	public function wcpfc_pro_match_total_cart_subtotal__premium_only( $get_condition_array_ap_total_cart_subtotal, $woo_cart_array, $cost_on_total_cart_subtotal_rule_match ) {
		if ( ! empty( $woo_cart_array ) ) {
			$is_passed_from_here_tcw = array();
			if ( ! empty( $get_condition_array_ap_total_cart_subtotal ) || '' !== $get_condition_array_ap_total_cart_subtotal ) {
				foreach ( $get_condition_array_ap_total_cart_subtotal as $key => $get_condition ) {
					$total_qws                 = $this->wcpfc_pro_get_cart_subtotal();
					$get_min_max               = $this->wcpfc_check_min_max_qws__premium_only(
						$get_condition['ap_fees_ap_total_cart_subtotal_min_subtotal'], $get_condition['ap_fees_ap_total_cart_subtotal_max_subtotal'], $get_condition['ap_fees_ap_price_total_cart_subtotal'], 'weight'
					);
					$is_passed_from_here_tcw[] = $this->wcpfc_check_passed_rule__premium_only(
						$key, $get_min_max['min'], $get_min_max['max'], 'has_fee_based_on_tcs', 'has_fee_based_on_tcs_price', $get_condition['ap_fees_ap_price_total_cart_subtotal'], $total_qws, 'weight'
					);
				}
			}
			$main_is_passed = $this->wcpfc_pro_check_all_passed_advance_rule__premium_only(
				$is_passed_from_here_tcw, 'has_fee_based_on_tcs', 'has_fee_based_on_tcs_price', $cost_on_total_cart_subtotal_rule_match
			);

			return $main_is_passed;
		}
	}

	/**
	 * Cost for Category subtotal in advance pricing rules
	 *
	 * @param array  $get_condition_array_ap_shipping_class_subtotal
	 * @param array  $woo_cart_array
	 * @param string $cost_on_shipping_class_subtotal_rule_match
	 *
	 * @return array $main_is_passed
	 * @since 3.6
	 *
	 * @uses  WC_Cart::get_cart_contents_total()
	 * @uses  wp_get_post_terms()
	 * @uses  wc_get_product()
	 *
	 */
	public function wcpfc_pro_match_shipping_class_subtotal__premium_only( $get_condition_array_ap_shipping_class_subtotal, $woo_cart_array, $cost_on_shipping_class_subtotal_rule_match, $sitepress, $default_lang ) {
		if ( ! empty( $woo_cart_array ) ) {
			$is_passed_from_here_scs = array();
			if ( ! empty( $get_condition_array_ap_shipping_class_subtotal ) || '' !== $get_condition_array_ap_shipping_class_subtotal ) {
				foreach ( $get_condition_array_ap_shipping_class_subtotal as $key => $get_condition ) {
					$total_qws                 = $this->wcpfc_get_count_qty__premium_only(
						$get_condition['ap_fees_shipping_class_subtotals'], $woo_cart_array, $sitepress, $default_lang, 'shipping_class', 'subtotal'
					);
					$get_min_max               = $this->wcpfc_check_min_max_qws__premium_only(
						$get_condition['ap_fees_ap_shipping_class_subtotal_min_subtotal'], $get_condition['ap_fees_ap_shipping_class_subtotal_max_subtotal'], $get_condition['ap_fees_ap_price_shipping_class_subtotal'], 'subtotal'
					);
					$is_passed_from_here_scs[] = $this->wcpfc_check_passed_rule__premium_only(
						$key, $get_min_max['min'], $get_min_max['max'], 'has_fee_based_on_scs', 'has_fee_based_on_scs_price', $get_condition['ap_fees_ap_price_shipping_class_subtotal'], $total_qws, 'subtotal'
					);
				}
			}
			$main_is_passed = $this->wcpfc_pro_check_all_passed_advance_rule__premium_only(
				$is_passed_from_here_scs, 'has_fee_based_on_scs', 'has_fee_based_on_scs_price', $cost_on_shipping_class_subtotal_rule_match
			);

			return $main_is_passed;
		}
	}

	/**
	 * Display array column
	 *
	 * @param array $input
	 * @param int   $columnKey
	 * @param int   $indexKey
	 *
	 * @return array $array It will return array if any error generate then it will return false
	 * @since  1.0.0
	 *
	 * @uses   trigger_error()
	 *
	 */
	public function wcpfc_pro_fee_array_column_public( array $input, $columnKey, $indexKey = null ) {
		$array = array();
		foreach ( $input as $value ) {
			if ( ! isset( $value[ $columnKey ] ) ) {
				return false;
			}
			if ( is_null( $indexKey ) ) {
				$array[] = $value[ $columnKey ];
			} else {
				if ( ! isset( $value[ $indexKey ] ) ) {
					return false;
				}
				if ( ! is_scalar( $value[ $indexKey ] ) ) {
					return false;
				}
				$array[ $value[ $indexKey ] ] = $value[ $columnKey ];
			}
		}

		return $array;
	}

	/**
	 * Get applied fees on frontside
	 *
	 * @return array|object $fees
	 * @since  1.3.3
	 *
	 */
	public function wcpfc_pro_get_applied_fees() {
		$fees = WC()->cart->get_fees();
		uasort( $fees, array( $this, 'wcpfc_pro_sorting_fees' ) );

		return $fees;
	}

	/**
	 * Sorting fees on front side
	 *
	 * @param object $a
	 * @param object $b
	 *
	 * @return int
	 * @since  1.3.3
	 *
	 */
	public function wcpfc_pro_sorting_fees( $a, $b ) {
		return ( $a->menu_order < $b->menu_order ) ? - 1 : 1;
	}

	/**
	 * Get variation name from cart
	 *
	 * @param string $sitepress
	 * @param string $default_lang
	 *
	 * @return array $cart_product_ids_array
	 * @uses  wcpfc_pro_get_cart();
	 *
	 * @since 1.0.0
	 *
	 */
	public function wcpfc_pro_get_var_name__premium_only( $sitepress, $default_lang ) {
		$cart_array             = $this->wcpfc_pro_get_cart();
		$cart_product_ids_array = array();
		foreach ( $cart_array as $woo_cart_item ) {
			$_product = wc_get_product( $woo_cart_item['product_id'] );
			if ( $_product->is_type( 'variable' ) ) {
				if ( ! empty( $sitepress ) ) {
					$cart_product_ids_array[] = apply_filters( 'wpml_object_id', $woo_cart_item['variation_id'], 'product', true, $default_lang );
				} else {
					$cart_product_ids_array[] = $woo_cart_item['variation_id'];
				}
			}
		}
		$variation_cart_product = array();
		foreach ( $cart_product_ids_array as $variation_id ) {
			$variation                = new WC_Product_Variation( $variation_id );
			$variation_cart_product[] = $variation->get_variation_attributes();
		}
		$variation_cart_products_array = array();
		if ( isset( $variation_cart_product ) && ! empty( $variation_cart_product ) ) {
			foreach ( $variation_cart_product as $cart_product_id ) {
				if ( isset( $cart_product_id ) && ! empty( $cart_product_id ) ) {
					foreach ( $cart_product_id as $v ) {
						$variation_cart_products_array[] = $v;
					}
				}
			}
		}

		return $variation_cart_products_array;
	}
	 /**
      * BN code added
      *
      * @param $paypal_args
      *
      * @return mixed
    */
    function paypal_bn_code_filter_conditional_fee( $paypal_args )
    {
        $paypal_args['bn'] = 'Multidots_SP';
        return $paypal_args;
    }
}
