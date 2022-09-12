<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once( plugin_dir_path( __FILE__ ) . 'header/plugin-header.php' );
$wcpfc_admin_object = new Woocommerce_Conditional_Product_Fees_For_Checkout_Pro_Admin( '', '' );
$wcpfc_object       = new Woocommerce_Conditional_Product_Fees_For_Checkout_Pro( '', '' );
if ( isset( $_POST['submitFee'], $_POST['wcpfc_pro_fees_conditions_save'] ) && wp_verify_nonce( sanitize_text_field( $_POST['wcpfc_pro_fees_conditions_save'] ), 'wcpfc_pro_fees_conditions_save_action' ) && ! empty( $_POST['submitFee'] ) ) {
	$post_data = $_POST;
	$wcpfc_admin_object->wcpfc_pro_fees_conditions_save( $post_data );
}
if ( isset( $_REQUEST['action'], $_REQUEST['id'] ) && 'edit' === $_REQUEST['action'] ) {
	$get_wpnonce         = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );
	$get_retrieved_nonce = isset( $get_wpnonce ) ? sanitize_text_field( wp_unslash( $get_wpnonce ) ) : '';
	if ( ! wp_verify_nonce( $get_retrieved_nonce, 'wcpfcnonce' ) ) {
		die( 'Failed security check' );
	}
	$request_post_id    = sanitize_text_field( $_REQUEST['id'] );
	$btnValue           = __( 'Update', 'woocommerce-conditional-product-fees-for-checkout' );
	$fee_title          = __( get_the_title( $request_post_id ), 'woocommerce-conditional-product-fees-for-checkout' );
	$getFeesCost        = __( get_post_meta( $request_post_id, 'fee_settings_product_cost', true ), 'woocommerce-conditional-product-fees-for-checkout' );
	$getFeesType        = __( get_post_meta( $request_post_id, 'fee_settings_select_fee_type', true ), 'woocommerce-conditional-product-fees-for-checkout' );
	$wcpfc_tooltip_desc = __( get_post_meta( $request_post_id, 'fee_settings_tooltip_desc', true ), 'woocommerce-conditional-product-fees-for-checkout' );
	$getFeesStartDate   = get_post_meta( $request_post_id, 'fee_settings_start_date', true );
	$getFeesEndDate     = get_post_meta( $request_post_id, 'fee_settings_end_date', true );
	$getFeesTaxable     = __( get_post_meta( $request_post_id, 'fee_settings_select_taxable', true ), 'woocommerce-conditional-product-fees-for-checkout' );
	$getFeesStatus      = get_post_status( $request_post_id );
	$productFeesArray   = get_post_meta( $request_post_id, 'product_fees_metabox', true );
	if ( is_serialized( $productFeesArray ) ) {
		$productFeesArray = maybe_unserialize( $productFeesArray );
	} else {
		$productFeesArray = $productFeesArray;
	}
	if ( wcpffc_fs()->is__premium_only() ) {
		if ( wcpffc_fs()->can_use_premium_code() ) {
			$getFeesPerQtyFlag                      = get_post_meta( $request_post_id, 'fee_chk_qty_price', true );
			$getFeesPerQty                          = get_post_meta( $request_post_id, 'fee_per_qty', true );
			$extraProductCost                       = get_post_meta( $request_post_id, 'extra_product_cost', true );
			$ap_rule_status                         = get_post_meta( $request_post_id, 'ap_rule_status', true );
			$cost_on_product_status                 = get_post_meta( $request_post_id, 'cost_on_product_status', true );
			$cost_on_product_weight_status          = get_post_meta( $request_post_id, 'cost_on_product_weight_status', true );
			$cost_on_product_subtotal_status        = get_post_meta( $request_post_id, 'cost_on_product_subtotal_status', true );
			$cost_on_category_status                = get_post_meta( $request_post_id, 'cost_on_category_status', true );
			$cost_on_category_weight_status         = get_post_meta( $request_post_id, 'cost_on_category_weight_status', true );
			$cost_on_category_subtotal_status       = get_post_meta( $request_post_id, 'cost_on_category_subtotal_status', true );
			$cost_on_total_cart_qty_status          = get_post_meta( $request_post_id, 'cost_on_total_cart_qty_status', true );
			$cost_on_total_cart_weight_status       = get_post_meta( $request_post_id, 'cost_on_total_cart_weight_status', true );
			$cost_on_total_cart_subtotal_status     = get_post_meta( $request_post_id, 'cost_on_total_cart_subtotal_status', true );
			$cost_on_shipping_class_subtotal_status = get_post_meta( $request_post_id, 'cost_on_shipping_class_subtotal_status', true );
			$sm_metabox_ap_product                  = get_post_meta( $request_post_id, 'sm_metabox_ap_product', true );
			if ( is_serialized( $sm_metabox_ap_product ) ) {
				$sm_metabox_ap_product = maybe_unserialize( $sm_metabox_ap_product );
			} else {
				$sm_metabox_ap_product = $sm_metabox_ap_product;
			}
			$sm_metabox_ap_product_subtotal = get_post_meta( $request_post_id, 'sm_metabox_ap_product_subtotal', true );
			if ( is_serialized( $sm_metabox_ap_product_subtotal ) ) {
				$sm_metabox_ap_product_subtotal = maybe_unserialize( $sm_metabox_ap_product_subtotal );
			} else {
				$sm_metabox_ap_product_subtotal = $sm_metabox_ap_product_subtotal;
			}
			$sm_metabox_ap_product_weight = get_post_meta( $request_post_id, 'sm_metabox_ap_product_weight', true );
			if ( is_serialized( $sm_metabox_ap_product_weight ) ) {
				$sm_metabox_ap_product_weight = maybe_unserialize( $sm_metabox_ap_product_weight );
			} else {
				$sm_metabox_ap_product_weight = $sm_metabox_ap_product_weight;
			}
			$sm_metabox_ap_category = get_post_meta( $request_post_id, 'sm_metabox_ap_category', true );
			if ( is_serialized( $sm_metabox_ap_category ) ) {
				$sm_metabox_ap_category = maybe_unserialize( $sm_metabox_ap_category );
			} else {
				$sm_metabox_ap_category = $sm_metabox_ap_category;
			}
			$sm_metabox_ap_category_subtotal = get_post_meta( $request_post_id, 'sm_metabox_ap_category_subtotal', true );
			if ( is_serialized( $sm_metabox_ap_category_subtotal ) ) {
				$sm_metabox_ap_category_subtotal = maybe_unserialize( $sm_metabox_ap_category_subtotal );
			} else {
				$sm_metabox_ap_category_subtotal = $sm_metabox_ap_category_subtotal;
			}
			$sm_metabox_ap_category_weight = get_post_meta( $request_post_id, 'sm_metabox_ap_category_weight', true );
			if ( is_serialized( $sm_metabox_ap_category_weight ) ) {
				$sm_metabox_ap_category_weight = maybe_unserialize( $sm_metabox_ap_category_weight );
			} else {
				$sm_metabox_ap_category_weight = $sm_metabox_ap_category_weight;
			}
			$sm_metabox_ap_total_cart_qty = get_post_meta( $request_post_id, 'sm_metabox_ap_total_cart_qty', true );
			if ( is_serialized( $sm_metabox_ap_total_cart_qty ) ) {
				$sm_metabox_ap_total_cart_qty = maybe_unserialize( $sm_metabox_ap_total_cart_qty );
			} else {
				$sm_metabox_ap_total_cart_qty = $sm_metabox_ap_total_cart_qty;
			}
			$sm_metabox_ap_total_cart_weight = get_post_meta( $request_post_id, 'sm_metabox_ap_total_cart_weight', true );
			if ( is_serialized( $sm_metabox_ap_total_cart_weight ) ) {
				$sm_metabox_ap_total_cart_weight = maybe_unserialize( $sm_metabox_ap_total_cart_weight );
			} else {
				$sm_metabox_ap_total_cart_weight = $sm_metabox_ap_total_cart_weight;
			}
			$sm_metabox_ap_total_cart_subtotal = get_post_meta( $request_post_id, 'sm_metabox_ap_total_cart_subtotal', true );
			if ( is_serialized( $sm_metabox_ap_total_cart_subtotal ) ) {
				$sm_metabox_ap_total_cart_subtotal = maybe_unserialize( $sm_metabox_ap_total_cart_subtotal );
			} else {
				$sm_metabox_ap_total_cart_subtotal = $sm_metabox_ap_total_cart_subtotal;
			}
			$sm_metabox_ap_shipping_class_subtotal = get_post_meta( $request_post_id, 'sm_metabox_ap_shipping_class_subtotal', true );
			if ( is_serialized( $sm_metabox_ap_shipping_class_subtotal ) ) {
				$sm_metabox_ap_shipping_class_subtotal = maybe_unserialize( $sm_metabox_ap_shipping_class_subtotal );
			} else {
				$sm_metabox_ap_shipping_class_subtotal = $sm_metabox_ap_shipping_class_subtotal;
			}
			$cost_rule_match = get_post_meta( $request_post_id, 'cost_rule_match', true );
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
				if ( array_key_exists( 'advance_rule_match', $cost_rule_match ) ) {
					$advance_rule_match = $cost_rule_match['advance_rule_match'];
				} else {
					$advance_rule_match = 'any';
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
				$advance_rule_match                         = 'any';
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
		}
	}
} else {
	$request_post_id    = '';
	$btnValue           = __( 'Save', 'woocommerce-conditional-product-fees-for-checkout' );
	$fee_title          = '';
	$getFeesCost        = '';
	$getFeesType        = '';
	$wcpfc_tooltip_desc = '';
	$getFeesStartDate   = '';
	$getFeesEndDate     = '';
	$getFeesTaxable     = '';
	$getFeesStatus      = '';
	$productFeesArray   = array();
	$getFeesOptional    = '';
	$byDefaultChecked   = '';
	if ( wcpffc_fs()->is__premium_only() ) {
		if ( wcpffc_fs()->can_use_premium_code() ) {
			$getFeesPerQtyFlag                          = '';
			$getFeesPerQty                              = '';
			$extraProductCost                           = '';
			$ap_rule_status                             = '';
			$cost_on_product_status                     = '';
			$cost_on_category_status                    = '';
			$cost_on_total_cart_qty_status              = '';
			$cost_on_product_weight_status              = '';
			$cost_on_category_weight_status             = '';
			$cost_on_total_cart_weight_status           = '';
			$cost_on_total_cart_subtotal_status         = '';
			$cost_on_shipping_class_subtotal_status     = '';
			$sm_metabox_ap_product                      = array();
			$sm_metabox_ap_category                     = array();
			$sm_metabox_ap_total_cart_qty               = array();
			$sm_metabox_ap_product_weight               = array();
			$sm_metabox_ap_category_weight              = array();
			$sm_metabox_ap_total_cart_weight            = array();
			$sm_metabox_ap_total_cart_subtotal          = array();
			$sm_metabox_ap_shipping_class_subtotal      = array();
			$general_rule_match                         = 'all';
			$advance_rule_match                         = 'any';
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
	}
}
$sm_status = ( ( ! empty( $getFeesStatus ) && 'publish' === $getFeesStatus ) || empty( $getFeesStatus ) ) ? 'checked' : '';
if ( wcpffc_fs()->is__premium_only() ) {
	if ( wcpffc_fs()->can_use_premium_code() ) {
		$ap_rule_status                         = ( ! empty( $ap_rule_status ) && 'on' === $ap_rule_status && "" !== $ap_rule_status ) ? 'checked' : '';
		$cost_on_product_status                 = ( ! empty( $cost_on_product_status ) && 'on' === $cost_on_product_status && "" !== $cost_on_product_status ) ? 'checked' : '';
		$cost_on_product_weight_status          = ( ! empty( $cost_on_product_weight_status ) && 'on' === $cost_on_product_weight_status && "" !== $cost_on_product_weight_status ) ? 'checked' : '';
		$cost_on_product_subtotal_status        = ( ! empty( $cost_on_product_subtotal_status ) && 'on' === $cost_on_product_subtotal_status && "" !== $cost_on_product_subtotal_status ) ? 'checked' : '';
		$cost_on_category_status                = ( ! empty( $cost_on_category_status ) && 'on' === $cost_on_category_status && "" !== $cost_on_category_status ) ? 'checked' : '';
		$cost_on_category_weight_status         = ( ! empty( $cost_on_category_weight_status ) && 'on' === $cost_on_category_weight_status && "" !== $cost_on_category_weight_status ) ? 'checked' : '';
		$cost_on_category_subtotal_status       = ( ! empty( $cost_on_category_subtotal_status ) && 'on' === $cost_on_category_subtotal_status && "" !== $cost_on_category_subtotal_status ) ? 'checked' : '';
		$cost_on_total_cart_qty_status          = ( ! empty( $cost_on_total_cart_qty_status ) && 'on' === $cost_on_total_cart_qty_status && "" !== $cost_on_total_cart_qty_status ) ? 'checked' : '';
		$cost_on_total_cart_weight_status       = ( ! empty( $cost_on_total_cart_weight_status ) && 'on' === $cost_on_total_cart_weight_status && "" !== $cost_on_total_cart_weight_status ) ? 'checked' : '';
		$cost_on_total_cart_subtotal_status     = ( ! empty( $cost_on_total_cart_subtotal_status ) && 'on' === $cost_on_total_cart_subtotal_status && "" !== $cost_on_total_cart_subtotal_status ) ? 'checked' : '';
		$cost_on_shipping_class_subtotal_status = ( ! empty( $cost_on_shipping_class_subtotal_status ) && 'on' === $cost_on_shipping_class_subtotal_status && "" !== $cost_on_shipping_class_subtotal_status ) ? 'checked' : '';
	}
}
?>
<div class="text-condtion-is" style="display:none;">
	<select class="text-condition">
		<option
			value="is_equal_to"><?php esc_html_e( 'Equal to ( = )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
		<option
			value="less_equal_to"><?php esc_html_e( 'Less or Equal to ( <= )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
		<option
			value="less_then"><?php esc_html_e( 'Less than ( < )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
		<option
			value="greater_equal_to"><?php esc_html_e( 'Greater or Equal to ( >= )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
		<option
			value="greater_then"><?php esc_html_e( 'Greater than ( > )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
		<option
			value="not_in"><?php esc_html_e( 'Not Equal to ( != )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
	</select>
	<select class="select-condition">
		<option
			value="is_equal_to"><?php esc_html_e( 'Equal to ( = )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
		<option
			value="not_in"><?php esc_html_e( 'Not Equal to ( != )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
	</select>
</div>

<div class="wcpfc-section-left">
	<div class="wcpfc-main-table res-cl">
		<?php wp_nonce_field( 'wcpfc_pro_product_fees_conditions_values_ajax_action', 'wcpfc_pro_product_fees_conditions_values_ajax' ); ?>
		<h2><?php esc_html_e( 'Fee Configuration', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
		<form method="POST" name="feefrm" action="">
			<?php wp_nonce_field( 'wcpfc_pro_fees_conditions_save_action', 'wcpfc_pro_fees_conditions_save' ); ?>
			<input type="hidden" name="post_type" value="wc_conditional_fee">
			<input type="hidden" name="fee_post_id" value="<?php echo esc_attr( $request_post_id ) ?>">
			<table class="form-table table-outer product-fee-table">
				<tbody>
				<tr valign="top">
					<th class="titledesc" scope="row"><label
							for="onoffswitch"><?php esc_html_e( 'Status', 'woocommerce-conditional-product-fees-for-checkout' ); ?></label>
					</th>
					<td class="forminp">
						<label class="switch">
							<input type="checkbox" name="fee_settings_status"
							       value="on" <?php echo esc_attr( $sm_status ); ?>>
							<div class="slider round"></div>
						</label>
						<span class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
						<p class="description"
						   style="display:none;"><?php esc_html_e( 'Enable or Disable', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
					</td>
				</tr>

				<tr valign="top">
					<th class="titledesc" scope="row"><label
							for="fee_settings_product_fee_title"><?php esc_html_e( 'Product Fee Title', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
							<span class="required-star">*</span></label></th>
					<td class="forminp">
						<input type="text" name="fee_settings_product_fee_title" class="text-class"
						       id="fee_settings_product_fee_title"
						       value="<?php echo isset( $fee_title ) ? esc_attr( $fee_title ) : ''; ?>" required="1"
						       placeholder="<?php esc_html_e( 'Enter product fees title', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
						<span class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
						<p class="description"
						   style="display:none;"><?php esc_html_e( 'This product fees title is visible to the customer at the time of checkout.', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
					</td>

				</tr>
				<tr valign="top">
					<th class="titledesc" scope="row">
						<label
							for="fee_settings_select_fee_type"><?php esc_html_e( 'Select Fee Type', 'woocommerce-conditional-product-fees-for-checkout' ); ?></label>
					</th>
					<td class="forminp">
						<select name="fee_settings_select_fee_type" id="fee_settings_select_fee_type" class="">
							<option
								value="fixed" <?php echo isset( $getFeesType ) && 'fixed' === $getFeesType ? 'selected="selected"' : '' ?>><?php esc_html_e( 'Fixed', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
							<option
								value="percentage" <?php echo isset( $getFeesType ) && 'percentage' === $getFeesType ? 'selected="selected"' : '' ?>><?php esc_html_e( 'Percentage', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
						</select>
						<span class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
						<p class="description"
						   style="display:none;"><?php esc_html_e( 'you can charges extra fees on fixed price or percentage.', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="row"><label
							for="fee_settings_product_cost"><?php esc_html_e( 'Fees', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
							<span class="required-star">*</span></label></th>
					<td class="forminp">
						<div class="product_cost_left_div">
							<input type="text" name="fee_settings_product_cost" required="1" class="text-class"
							       id="fee_settings_product_cost"
							       value="<?php echo isset( $getFeesCost ) ? esc_attr( $getFeesCost ) : ''; ?>"
							       placeholder="<?php echo esc_attr( get_woocommerce_currency_symbol() ); ?>">
							<span class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
							<p class="description" style="display:none;">
								<?php
								esc_html_e( 'If you select fixed fees type then : you have to add fixed cost/fees (Eg. 10, 20) ).' );
								echo "<br/>";
								esc_html_e( 'If you select percentage wise fees type then : you have to add percentage (Eg. 10, 15.20)', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
							</p>
						</div>
						<?php
						if ( wcpffc_fs()->is__premium_only() ) {
							if ( wcpffc_fs()->can_use_premium_code() ) {
								?>
								<div class="product_cost_right_div">

									<div class="applyperqty-boxone">
										<label
											for="fee_chk_qty_price"><?php esc_html_e( 'Apply Per Additional Quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?></label>
										<input type="checkbox" name="fee_chk_qty_price" id="fee_chk_qty_price"
										       class="chk_qty_price_class"
										       value="on" <?php checked( $getFeesPerQtyFlag, 'on' ); ?>>
										<span
											class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
										<p class="description"
										   style="display:none;"><?php esc_html_e( 'This will apply fees as per quantity of products.', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
									</div>

									<div class="applyperqty-boxtwo">
										<label
											for="apply_per_qty_type"><?php esc_html_e( 'Calculate Quantity Based On', 'woocommerce-conditional-product-fees-for-checkout' ); ?></label>
										<select name="fee_per_qty" id="price_cartqty_based" class="chk_qty_price_class"
										        id="apply_per_qty_type">
											<option
												value="qty_cart_based" <?php selected( $getFeesPerQty, 'qty_cart_based' ); ?>><?php esc_html_e( 'Cart Based', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											<option
												value="qty_product_based" <?php selected( $getFeesPerQty, 'qty_product_based' ); ?>><?php esc_html_e( 'Product Based', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
										</select>
										<span
											class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
										<p class="description"
										   style="display:none;"><?php esc_html_e( 'If you want to apply the fee for each quantity - where quantity should calculated based on product/category/tag conditions, then select the "Product Based" option.', 'woocommerce-conditional-product-fees-for-checkout' ) ?>
											<br><?php esc_html_e( 'If you want to apply the fee for each quantity in the customer\'s cart, then select the "Cart Based" option.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
										</p>
									</div>

									<div class="applyperqty-boxthree">
										<label
											for="extra_product_cost"><?php esc_html_e( 'Fee per Additional Quantity&nbsp;(' . esc_html( get_woocommerce_currency_symbol() ) . ') ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
											<span class="required-star">*</span></label>
										<input type="text" name="extra_product_cost" class="text-class"
										       id="extra_product_cost" required
										       value="<?php echo isset( $extraProductCost ) ? esc_attr( $extraProductCost ) : ''; ?>"
										       placeholder="<?php echo esc_attr( get_woocommerce_currency_symbol() ); ?>">
										<span
											class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
										<p class="description" style="display:none;">
											<?php
											echo esc_html( 'You can add fee here to be charged for each additional quantity. E.g. if user has added 3 quantities and you have set fee=$10 and fee per additional quantity=$5, then total extra fee=$10+$5+$5=$20.' ) . '<br>'
											     . esc_html( 'The quantity will be calculated based on the option chosen in the "Calculate Quantity Based On" above dropdown. That means, if you have chosen "Product Based" option - quantities will be calculated based on the products which are meeting the conditions set for this fee, and if they are more than 1, fee will be calculated considering only its additional quantities. e.g. 5 items in cart, and 3 are meeting the condition set, then additional fee of $5 will be charged on 2 quantities only, and not on 4 quantities.', 'woocommerce-conditional-product-fees-for-checkout' );
											?>
										</p>
									</div>

								</div>
								<?php
							}
						}
						?>
					</td>
				</tr>
				<?php
				if ( wcpffc_fs()->is__premium_only() ) {
					if ( wcpffc_fs()->can_use_premium_code() ) {
						?>
						<tr valign="top">
							<th class="titledesc" scope="row">
								<label
									for="wcpfc_tooltip_desc"><?php esc_html_e( 'Tooltip Description', 'woocommerce-conditional-product-fees-for-checkout' ); ?></label>
							</th>
							<td class="forminp">
                            <textarea name="wcpfc_tooltip_desc" rows="3" cols="70" id="wcpfc_tooltip_desc"
                                      placeholder="<?php esc_html_e( 'Enter tooltip short description', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"><?php echo esc_textarea( $wcpfc_tooltip_desc ); ?></textarea>
							</td>
						</tr>
						<?php
					}
				}
				?>
				<tr valign="top">
					<th class="titledesc" scope="row"><label
							for="fee_settings_start_date"><?php esc_html_e( 'Start Date', 'woocommerce-conditional-product-fees-for-checkout' ); ?></label>
					</th>
					<td class="forminp">
						<input type="text" name="fee_settings_start_date" class="text-class"
						       id="fee_settings_start_date"
						       value="<?php echo isset( $getFeesStartDate ) ? esc_attr( $getFeesStartDate ) : ''; ?>"
						       placeholder="<?php esc_attr_e( 'Select start date', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
						<span class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
						<p class="description"
						   style="display:none;"><?php esc_html_e( 'Select Start date on which you want to enable the method', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="row"><label
							for="fee_settings_end_date"><?php esc_html_e( 'End Date', 'woocommerce-conditional-product-fees-for-checkout' ); ?></label>
					</th>
					<td class="forminp">
						<input type="text" name="fee_settings_end_date" class="text-class" id="fee_settings_end_date"
						       value="<?php echo isset( $getFeesEndDate ) ? esc_attr( $getFeesEndDate ) : ''; ?>"
						       placeholder="<?php esc_html_e( 'Select end date', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
						<span class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
						<p class="description"
						   style="display:none;"><?php esc_html_e( 'Select End date on which you want to disable the method', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="row">
						<label
							for="fee_settings_select_taxable"><?php esc_html_e( 'Is Amount Taxable ?', 'woocommerce-conditional-product-fees-for-checkout' ); ?></label>
					</th>
					<td class="forminp">
						<select name="fee_settings_select_taxable" id="fee_settings_select_taxable" class="">
							<option
								value="no" <?php echo isset( $getFeesTaxable ) && 'no' === $getFeesTaxable ? 'selected="selected"' : '' ?>><?php esc_html_e( 'No', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
							<option
								value="yes" <?php echo isset( $getFeesTaxable ) && 'yes' === $getFeesTaxable ? 'selected="selected"' : '' ?>><?php esc_html_e( 'Yes', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
						</select>

					</td>
				</tr>
				</tbody>
			</table>
			<div class="sub-title">
				<h2><?php esc_html_e( 'Conditional Fee Rule', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
				<div class="tap">
					<a id="fee-add-field" class="button button-primary button-large" href="javascript:;">
						<?php esc_html_e( '+ Add Row', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
					</a>
					<?php
					if ( wcpffc_fs()->is__premium_only() ) {
						if ( wcpffc_fs()->can_use_premium_code() ) {
							?>
							<div class="wocfc_match_type">
								<p class="switch_in_pricing_rules_description_left">
									<?php esc_html_e( 'below', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
								</p>
								<select name="cost_rule_match[general_rule_match]" id="general_rule_match"
								        class="arcmt_select">
									<option
										value="any" <?php selected( $general_rule_match, 'any' ) ?>><?php esc_html_e( 'Any One', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
									<option
										value="all" <?php selected( $general_rule_match, 'all' ) ?>><?php esc_html_e( 'All', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
								</select>
								<p class="switch_in_pricing_rules_description">
									<?php esc_html_e( 'rule match', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
								</p>
							</div>
							<?php
						}
					}
					?>
				</div>
			</div>
			<div class="tap">
				<table id="tbl-product-fee" class="tbl_product_fee table-outer tap-cas form-table product-fee-table">
					<tbody>
					<?php
					if ( isset( $productFeesArray ) && ! empty( $productFeesArray ) ) {
						$i = 2;
						foreach ( $productFeesArray as $key => $productfees ) {
							$fees_conditions = isset( $productfees['product_fees_conditions_condition'] ) ? $productfees['product_fees_conditions_condition'] : '';
							$condition_is    = isset( $productfees['product_fees_conditions_is'] ) ? $productfees['product_fees_conditions_is'] : '';
							$condtion_value  = isset( $productfees['product_fees_conditions_values'] ) ? $productfees['product_fees_conditions_values'] : array();
							?>
							<tr id="row_<?php echo esc_attr( $i ); ?>" valign="top">
								<th class="titledesc th_product_fees_conditions_condition" scope="row">
									<select rel-id="<?php echo esc_attr( $i ); ?>"
									        id="product_fees_conditions_condition_<?php echo esc_attr( $i ); ?>"
									        name="fees[product_fees_conditions_condition][]"
									        id="product_fees_conditions_condition"
									        class="product_fees_conditions_condition">
										<optgroup
											label="<?php esc_html_e( 'Location Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
											<option
												value="country" <?php echo ( 'country' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Country', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											<?php
											if ( wcpffc_fs()->is__premium_only() ) {
												if ( wcpffc_fs()->can_use_premium_code() ) {
													?>
													<option
														value="state" <?php echo ( 'state' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'State', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
													<option
														value="postcode" <?php echo ( 'postcode' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Postcode', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
													<option
														value="zone" <?php echo ( 'zone' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Zone', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
													<?php
												}
											}
											?>
										</optgroup>
										<optgroup
											label="<?php esc_html_e( 'Product Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
											<option
												value="product" <?php echo ( 'product' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Cart contains product', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											<?php
											if ( wcpffc_fs()->is__premium_only() ) {
												if ( wcpffc_fs()->can_use_premium_code() ) {
													?>
													<option
														value="variableproduct" <?php echo ( 'variableproduct' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Cart contains variable product', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
													<option
														value="category" <?php echo ( 'category' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Cart contains category\'s product', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
													<?php
												}
											}
											?>
											<option
												value="tag" <?php echo ( 'tag' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Cart contains tag\'s product', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
										</optgroup>
										<optgroup
											label="<?php esc_html_e( 'User Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
											<option
												value="user" <?php echo ( 'user' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'User', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											<?php
											if ( wcpffc_fs()->is__premium_only() ) {
												if ( wcpffc_fs()->can_use_premium_code() ) {
													?>
													<option
														value="user_role" <?php echo ( 'user_role' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'User Role', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
													<?php
												}
											}
											?>
										</optgroup>
										<optgroup
											label="<?php esc_html_e( 'Cart Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
											<?php
											$currency_symbol = get_woocommerce_currency_symbol();
											$currency_symbol = ! empty( $currency_symbol ) ? '(' . $currency_symbol . ')' : '';
											if ( wcpffc_fs()->is__premium_only() ) {
												if ( wcpffc_fs()->can_use_premium_code() ) {
													$weight_unit = get_option( 'woocommerce_weight_unit' );
													$weight_unit = ! empty( $weight_unit ) ? '(' . $weight_unit . ')' : '';
												}
											}
											?>
											<option
												value="cart_total" <?php echo ( 'cart_total' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Cart Subtotal (Before Discount) ', 'woocommerce-conditional-product-fees-for-checkout' ); ?><?php echo esc_html( $currency_symbol ); ?></option>
											<?php
											if ( wcpffc_fs()->is__premium_only() ) {
												if ( wcpffc_fs()->can_use_premium_code() ) {
													?>
													<option
														value="cart_totalafter" <?php echo ( 'cart_totalafter' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Cart Subtotal (After Discount) ', 'woocommerce-conditional-product-fees-for-checkout' ); ?><?php echo esc_html( $currency_symbol ); ?></option>
													<?php
												}
											}
											?>
											<option
												value="quantity" <?php echo ( 'quantity' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											<?php
											if ( wcpffc_fs()->is__premium_only() ) {
												if ( wcpffc_fs()->can_use_premium_code() ) {
													?>
													<option
														value="weight" <?php echo ( 'weight' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Weight ', 'woocommerce-conditional-product-fees-for-checkout' ); ?><?php echo esc_html( $weight_unit ); ?></option>
													<option
														value="coupon" <?php echo ( 'coupon' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Coupon', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
													<option
														value="shipping_class" <?php echo ( 'shipping_class' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Shipping Class', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
													<?php
												}
											}
											?>
										</optgroup>
										<?php
										if ( wcpffc_fs()->is__premium_only() ) {
											if ( wcpffc_fs()->can_use_premium_code() ) {
												?>
												<optgroup
													label="<?php esc_html_e( 'Payment Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
													<option
														value="payment" <?php echo ( 'payment' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Payment Gateway', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
												</optgroup>
												<optgroup
													label="<?php esc_html_e( 'Shipping Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
													<option
														value="shipping_method" <?php echo ( 'shipping_method' === $fees_conditions ) ? 'selected' : '' ?>><?php esc_html_e( 'Shipping Method', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
												</optgroup>
												<?php
											}
										}
										?>
									</select>
								</th>
								<td class="select_condition_for_in_notin">
									<?php if ( 'cart_total' === $fees_conditions || 'cart_totalafter' === $fees_conditions || 'quantity' === $fees_conditions || 'weight' === $fees_conditions ) { ?>
										<select name="fees[product_fees_conditions_is][]"
										        class="product_fees_conditions_is_<?php echo esc_attr( $i ); ?>">
											<option
												value="is_equal_to" <?php echo ( 'is_equal_to' === $condition_is ) ? 'selected' : '' ?>><?php esc_html_e( 'Equal to ( = )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											<option
												value="less_equal_to" <?php echo ( 'less_equal_to' === $condition_is ) ? 'selected' : '' ?>><?php esc_html_e( 'Less or Equal to ( <= )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											<option
												value="less_then" <?php echo ( 'less_then' === $condition_is ) ? 'selected' : '' ?>><?php esc_html_e( 'Less than ( < )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											<option
												value="greater_equal_to" <?php echo ( 'greater_equal_to' === $condition_is ) ? 'selected' : '' ?>><?php esc_html_e( 'Greater or Equal to ( >= )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											<option
												value="greater_then" <?php echo ( 'greater_then' === $condition_is ) ? 'selected' : '' ?>><?php esc_html_e( 'Greater than ( > )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											<option
												value="not_in" <?php echo ( 'not_in' === $condition_is ) ? 'selected' : '' ?>><?php esc_html_e( 'Not Equal to ( != )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
										</select>
									<?php } else { ?>
										<select name="fees[product_fees_conditions_is][]"
										        class="product_fees_conditions_is_<?php echo esc_attr( $i ); ?>">
											<option
												value="is_equal_to" <?php echo ( 'is_equal_to' === $condition_is ) ? 'selected' : '' ?>><?php esc_html_e( 'Equal to ( = )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											<option
												value="not_in" <?php echo ( 'not_in' === $condition_is ) ? 'selected' : '' ?>><?php esc_html_e( 'Not Equal to ( != )', 'woocommerce-conditional-product-fees-for-checkout' ); ?> </option>
										</select>
									<?php } ?>
								</td>
								<td class="condition-value" id="column_<?php echo esc_attr( $i ); ?>">
									<?php
									$html = '';
									if ( wcpffc_fs()->is__premium_only() ) {
										if ( wcpffc_fs()->can_use_premium_code() ) {
											if ( 'country' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_country_list( $i, $condtion_value );
											} elseif ( 'state' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_states_list__premium_only( $i, $condtion_value );
											} elseif ( 'postcode' === $fees_conditions ) {
												$html .= '<textarea name = "fees[product_fees_conditions_values][value_' . $i . ']">' . $condtion_value . '</textarea>';
											} elseif ( 'zone' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_zones_list__premium_only( $i, $condtion_value );
											} elseif ( 'product' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_product_list( $i, $condtion_value, 'edit' );
												$html .= sprintf( wp_kses( __( '<p><b style="color: red;">Note: </b>Please make sure that when you add rules in
                                                                    Advanced Pricing > Cost per Product Section It contains in above selected product list,
                                                                    otherwise it may be not apply proper shipping charges. For more detail please view
                                                                    our documentation at <a href="%s" target="_blank">Click Here</a>.
                                                                    </p>', 'woocommerce-conditional-product-fees-for-checkout' )
														, array(
															'p' => array(),
															'b' => array( 'style' => array() ),
															'a' => array( 'href' => array(), 'target' => array() ),
														) )
													, esc_url( 'https://www.thedotstore.com/docs/plugin/woocommerce-conditional-product-fees-for-checkout' ) );
											} elseif ( 'variableproduct' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_varible_product_list__premium_only( $i, $condtion_value );
												$html .= sprintf( wp_kses( __( '<p><b style="color: red;">Note: </b>Please make sure that when you add rules in
                                                                    Advanced Pricing > Cost per Category Section It contains in above selected category list,
                                                                    otherwise it may be not apply proper shipping charges. For more detail please view
                                                                    our documentation at <a href="%s" target="_blank">Click Here</a>.
                                                                    </p>', 'woocommerce-conditional-product-fees-for-checkout' )
														, array(
															'p' => array(),
															'b' => array( 'style' => array() ),
															'a' => array( 'href' => array(), 'target' => array() ),
														) )
													, esc_url( 'https://www.thedotstore.com/docs/plugin/woocommerce-conditional-product-fees-for-checkout' ) );
											} elseif ( 'category' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_category_list__premium_only( $i, $condtion_value );
											} elseif ( 'tag' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_tag_list( $i, $condtion_value );
											} elseif ( 'user' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_user_list( $i, $condtion_value );
											} elseif ( 'user_role' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_user_role_list__premium_only( $i, $condtion_value );
											} elseif ( 'cart_total' === $fees_conditions ) {
												$html .= '<input type = "text" name = "fees[product_fees_conditions_values][value_' . $i . ']" id = "product_fees_conditions_values" class = "product_fees_conditions_values price-class" value = "' . $condtion_value . '">';
											} elseif ( 'cart_totalafter' === $fees_conditions ) {
												$html .= '<input type="text" name="fees[product_fees_conditions_values][value_' . $i . ']" id="product_fees_conditions_values" class="product_fees_conditions_values price-class" value="' . $condtion_value . '">';
												$html .= sprintf( wp_kses( __( '<p><b style="color: red;">Note: </b>This rule will apply when you would apply coupun in front side.
                                                            <a href="%s" target="_blank">Click Here</a>.</p>', 'woocommerce-conditional-product-fees-for-checkout' )
														, array(
															'p' => array(),
															'b' => array( 'style' => array() ),
															'a' => array( 'href' => array(), 'target' => array() ),
														) )
													, esc_url( 'https://www.thedotstore.com/docs/plugin/woocommerce-conditional-product-fees-for-checkout' ) );
											} elseif ( 'quantity' === $fees_conditions ) {
												$html .= '<input type = "text" name = "fees[product_fees_conditions_values][value_' . $i . ']" id = "product_fees_conditions_values" class = "product_fees_conditions_values qty-class" value = "' . $condtion_value . '">';
											} elseif ( 'weight' === $fees_conditions ) {
												$html .= '<input type = "text" name = "fees[product_fees_conditions_values][value_' . $i . ']" id = "product_fees_conditions_values" class = "product_fees_conditions_values weight-class" value = "' . $condtion_value . '">';
												$html .= sprintf( wp_kses( __( '<p><b style="color: red;">Note: </b>Please make sure that when you add rules in
                                                                    Advanced Pricing > Cost per weight Section It contains in above entered weight,
                                                                    otherwise it may be not apply proper shipping charges. For more detail please view
                                                                    our documentation at <a href="%s" target="_blank">Click Here</a>.
                                                                    </p>', 'woocommerce-conditional-product-fees-for-checkout' )
														, array(
															'p' => array(),
															'b' => array( 'style' => array() ),
															'a' => array( 'href' => array(), 'target' => array() ),
														) )
													, esc_url( 'https://www.thedotstore.com/docs/plugin/woocommerce-conditional-product-fees-for-checkout' ) );
											} elseif ( 'coupon' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_coupon_list__premium_only( $i, $condtion_value );
											} elseif ( 'shipping_class' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_advance_flat_rate_class__premium_only( $i, $condtion_value );
											} elseif ( 'payment' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_payment_methods__premium_only( $i, $condtion_value );
											} elseif ( 'shipping_method' === $fees_conditions ) {
												$html .= $wcpfc_admin_object->wcpfc_pro_get_active_shipping_methods__premium_only( $i, $condtion_value );
											}
										}
									} else {
										if ( 'country' === $fees_conditions ) {
											$html .= $wcpfc_admin_object->wcpfc_pro_get_country_list( $i, $condtion_value );
										} elseif ( 'product' === $fees_conditions ) {
											$html .= $wcpfc_admin_object->wcpfc_pro_get_product_list( $i, $condtion_value, 'edit' );
										} elseif ( 'tag' === $fees_conditions ) {
											$html .= $wcpfc_admin_object->wcpfc_pro_get_tag_list( $i, $condtion_value );
										} elseif ( 'user' === $fees_conditions ) {
											$html .= $wcpfc_admin_object->wcpfc_pro_get_user_list( $i, $condtion_value );
										} elseif ( 'cart_total' === $fees_conditions ) {
											$html .= '<input type = "text" name = "fees[product_fees_conditions_values][value_' . $i . ']" id = "product_fees_conditions_values" class = "product_fees_conditions_values price-class" value = "' . $condtion_value . '">';
										} elseif ( 'quantity' === $fees_conditions ) {
											$html .= '<input type = "text" name = "fees[product_fees_conditions_values][value_' . $i . ']" id = "product_fees_conditions_values" class = "product_fees_conditions_values qty-class" value = "' . $condtion_value . '">';
										}
									}
									echo wp_kses( $html, Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );
									?>
									<input type="hidden" name="condition_key[<?php echo 'value_' . esc_attr( $i ); ?>]"
									       value="">
								</td>
								<td><a id="fee-delete-field" rel-id="<?php echo esc_attr( $i ); ?>" class="delete-row"
								       href="javascript:;" title="Delete"><i class="fa fa-trash"></i></a></td>
							</tr>
							<?php
							$i ++;
						}
						?>
						<?php
					} else {
						$i = 1;
						?>
						<tr id="row_1" valign="top">
							<th class="titledesc th_product_fees_conditions_condition" scope="row">
								<select rel-id="1" id="product_fees_conditions_condition_1"
								        name="fees[product_fees_conditions_condition][]"
								        id="product_fees_conditions_condition"
								        class="product_fees_conditions_condition">
									<optgroup
										label="<?php esc_html_e( 'Location Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
										<option
											value="country"><?php esc_html_e( 'Country', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
										<?php
										if ( wcpffc_fs()->is__premium_only() ) {
											if ( wcpffc_fs()->can_use_premium_code() ) {
												?>
												<option
													value="state"><?php esc_html_e( 'State', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
												<option
													value="postcode"><?php esc_html_e( 'Postcode', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
												<option
													value="zone"><?php esc_html_e( 'Zone', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
												<?php
											}
										}
										?>
									</optgroup>
									<optgroup
										label="<?php esc_html_e( 'Product Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
										<option
											value="product"><?php esc_html_e( 'Cart contains product', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
										<?php
										if ( wcpffc_fs()->is__premium_only() ) {
											if ( wcpffc_fs()->can_use_premium_code() ) {
												?>
												<option
													value="variableproduct"><?php esc_html_e( 'Cart contains variable product', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
												<option
													value="category"><?php esc_html_e( 'Cart contains category\'s product', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
												<?php
											}
										}
										?>
										<option
											value="tag"><?php esc_html_e( 'Cart contains tag\'s product', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
									</optgroup>
									<optgroup
										label="<?php esc_html_e( 'User Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
										<option
											value="user"><?php esc_html_e( 'User', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
										<?php
										if ( wcpffc_fs()->is__premium_only() ) {
											if ( wcpffc_fs()->can_use_premium_code() ) {
												?>
												<option
													value="user_role"><?php esc_html_e( 'User Role', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
												<?php
											}
										}
										?>
									</optgroup>
									<optgroup
										label="<?php esc_html_e( 'Cart Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
										<?php
										$currency_symbol = get_woocommerce_currency_symbol();
										$currency_symbol = ! empty( $currency_symbol ) ? '(' . $currency_symbol . ')' : '';
										if ( wcpffc_fs()->is__premium_only() ) {
											if ( wcpffc_fs()->can_use_premium_code() ) {
												$weight_unit = get_option( 'woocommerce_weight_unit' );
												$weight_unit = ! empty( $weight_unit ) ? '(' . $weight_unit . ')' : '';
											}
										}
										?>
										<option
											value="cart_total"><?php esc_html_e( 'Cart Subtotal (Before Discount) ', 'woocommerce-conditional-product-fees-for-checkout' ); ?><?php echo esc_html( $currency_symbol ); ?></option>
										<?php
										if ( wcpffc_fs()->is__premium_only() ) {
											if ( wcpffc_fs()->can_use_premium_code() ) {
												?>
												<option
													value="cart_totalafter"><?php esc_html_e( 'Cart Subtotal (After Discount) ', 'woocommerce-conditional-product-fees-for-checkout' ); ?><?php echo esc_html( $currency_symbol ); ?></option>
												<?php
											}
										}
										?>
										<option
											value="quantity"><?php esc_html_e( 'Quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
										<?php
										if ( wcpffc_fs()->is__premium_only() ) {
											if ( wcpffc_fs()->can_use_premium_code() ) {
												?>
												<option
													value="weight"><?php esc_html_e( 'Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?><?php echo esc_html( $weight_unit ); ?></option>
												<option
													value="coupon"><?php esc_html_e( 'Coupon', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
												<option
													value="shipping_class"><?php esc_html_e( 'Shipping Class', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
												<?php
											}
										}
										?>
									</optgroup>
									<?php
									if ( wcpffc_fs()->is__premium_only() ) {
										if ( wcpffc_fs()->can_use_premium_code() ) {
											?>
											<optgroup
												label="<?php esc_html_e( 'Payment Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
												<option
													value="payment"><?php esc_html_e( 'Payment Gateway', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											</optgroup>
											<optgroup
												label="<?php esc_html_e( 'Shipping Specific', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
												<option
													value="shipping_method"><?php esc_html_e( 'Shipping Method', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											</optgroup>
											<?php
										}
									}
									?>
								</select>
							</td>
							<td class="select_condition_for_in_notin">
								<select name="fees[product_fees_conditions_is][]"
								        class="product_fees_conditions_is product_fees_conditions_is_1">
									<option
										value="is_equal_to"><?php esc_html_e( 'Equal to ( = )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
									<option
										value="not_in"><?php esc_html_e( 'Not Equal to ( != )', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
								</select>
							</td>
							<td id="column_1" class="condition-value">
								<?php echo wp_kses( $wcpfc_admin_object->wcpfc_pro_get_country_list( 1 ), Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() ); ?>
								<input type="hidden" name="condition_key[value_1][]" value="">
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<input type="hidden" name="total_row" id="total_row" value="<?php echo esc_attr( $i ); ?>">
			</div>
			
			<?php
			if ( wcpffc_fs()->is__premium_only() ) {
				if ( wcpffc_fs()->can_use_premium_code() ) {
					?>
					<?php // Advanced Pricing Section start  ?>
					<div id="apm_wrap" class="fees-pricing-rules">
						<div class="ap_title">
							<h2><?php esc_html_e( 'Advanced Fees Price Rules', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
							<label class="switch">
								<input type="checkbox" name="ap_rule_status"
								       value="on" <?php echo esc_attr( $ap_rule_status ); ?>>
								<div class="slider round"></div>
							</label>
							<span class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
							<p class="description"
							   style="display:none;padding-left: 15px;"><?php esc_html_e( 'If enabled this Advanced Pricing button only than below all rule\'s will go for apply to shipping method.', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
						</div>

						<div class="fees_pricing_rules">
							<div class="fees_pricing_rules_tab">
								<ul class="tabs">
									<?php
									$tab_array = array(
										'tab-1'  => esc_html__( 'Cost on Product', 'woocommerce-conditional-product-fees-for-checkout' ),
										'tab-2'  => esc_html__( 'Cost on Product Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ),
										'tab-3'  => esc_html__( 'Cost on Product Weight', 'woocommerce-conditional-product-fees-for-checkout' ),
										'tab-4'  => esc_html__( 'Cost on Category', 'woocommerce-conditional-product-fees-for-checkout' ),
										'tab-5'  => esc_html__( 'Cost on Category Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ),
										'tab-6'  => esc_html__( 'Cost on Category Weight', 'woocommerce-conditional-product-fees-for-checkout' ),
										'tab-7'  => esc_html__( 'Cost on Total Cart Qty', 'woocommerce-conditional-product-fees-for-checkout' ),
										'tab-8'  => esc_html__( 'Cost on Total Cart Weight', 'woocommerce-conditional-product-fees-for-checkout' ),
										'tab-9'  => esc_html__( 'Cost on Total Cart Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ),
										'tab-10' => esc_html__( 'Cost on Shipping Class Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ),
									);
									if ( ! empty( $tab_array ) ) {
										foreach ( $tab_array as $data_tab => $tab_title ) {
											if ( 'tab-1' === $data_tab ) {
												$class = ' current';
											} else {
												$class = '';
											}
											?>
											<li class="tab-link<?php echo esc_attr( $class ); ?>"
											    data-tab="<?php echo esc_attr( $data_tab ); ?>">
												<?php esc_html_e( $tab_title ); ?>
											</li>
											<?php
										}
									}
									?>
								</ul>
							</div>
							<div class="fees_pricing_rules_tab_content">
								<?php // Advanced Pricing Product Section start here   ?>
								<div class="ap_product_container advance_pricing_rule_box tab-content current"
								     id="tab-1"
								     data-title="<?php esc_html_e( 'Cost on Product', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
									<div class="tap-class">
										<div class="predefined_elements">
											<div id="all_product_list"></div>
										</div>
										<div class="sub-title">
											<h2><?php esc_html_e( 'Cost on Product', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
											<div class="tap">
												<a id="ap-product-add-field" class="button button-primary button-large"
												   href="javascript:;"><?php esc_html_e( '+ Add Rule', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
												<div class="switch_status_div">
													<label class="switch switch_in_pricing_rules">
														<input type="checkbox" name="cost_on_product_status"
														       value="on" <?php echo esc_attr( $cost_on_product_status ); ?>>
														<div class="slider round"></div>
													</label>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description switch_in_pricing_rules_description"
													   style="display:none;">
														<?php esc_html_e( 'You can turn off this button, if you do not need to apply this fee amount.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p>
												</div>
											</div>
											<div class="wocfc_match_type">
												<p class="switch_in_pricing_rules_description_left">
													<?php esc_html_e( 'below', 'woo-hide-shipping-methods' ); ?>
												</p>
												<select name="cost_rule_match[cost_on_product_rule_match]"
												        id="cost_on_product_rule_match" class="arcmt_select">
													<option
														value="any" <?php selected( $cost_on_product_rule_match, 'any' ) ?>><?php esc_html_e( 'Any One', 'woo-hide-shipping-methods' ); ?></option>
													<option
														value="all" <?php selected( $cost_on_product_rule_match, 'all' ) ?>><?php esc_html_e( 'All', 'woo-hide-shipping-methods' ); ?></option>
												</select>
												<p class="switch_in_pricing_rules_description">
													<?php esc_html_e( 'rule match', 'woo-hide-shipping-methods' ); ?>
												</p>
											</div>
										</div>
										<table id="tbl_ap_product_method"
										       class="tbl_product_fee table-outer tap-cas form-table fees-table">
											<tbody>
											<tr class="heading">
												<th class="titledesc th_product_fees_conditions_condition" scope="row">
													<?php esc_html_e( 'Product', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'Select a product to apply the fee amount to when the min/max quantity match.', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
												</th>
												<th class="titledesc th_product_fees_conditions_condition" scope="row">
													<?php esc_html_e( 'Min Quantity ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a minimum product quantity per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a minimum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_product_fees_conditions_condition" scope="row">
													<?php esc_html_e( 'Max Quantity ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a maximum product quantity per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a maximum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_product_fees_conditions_condition" scope="row"
												    colspan="2"><?php esc_html_e( 'Fee amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'A fixed amount (e.g. 5 / -5), percentage (e.g. 5% / -5%) to add as a fee. Percentage and minus amount will apply based on cart subtotal.', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
												</th>
											</tr>
											<?php
											//check advanced pricing value fill proper or unset if not
											$filled_arr = array();
											if ( ! empty( $sm_metabox_ap_product ) && is_array( $sm_metabox_ap_product ) ):
												foreach ( $sm_metabox_ap_product as $app_arr ) {
													//check that if required field fill or not once save the APR,  if match than fill in array
													if ( ! empty( $app_arr ) || '' !== $app_arr ) {
														if ( ( '' !== $app_arr['ap_fees_products'] && '' !== $app_arr['ap_fees_ap_price_product'] ) && ( '' !== $app_arr['ap_fees_ap_prd_min_qty'] || '' !== $app_arr['ap_fees_ap_prd_max_qty'] ) ) {
															//if condition match than fill in array
															$filled_arr[] = $app_arr;
														}
													}
												}
											endif;
											//check APR exist
											if ( isset( $filled_arr ) && ! empty( $filled_arr ) ) {
												$cnt_product = 2;
												foreach ( $filled_arr as $key => $productfees ) {
													$fees_ap_fees_products    = isset( $productfees['ap_fees_products'] ) ? $productfees['ap_fees_products'] : '';
													$ap_fees_ap_min_qty       = isset( $productfees['ap_fees_ap_prd_min_qty'] ) ? $productfees['ap_fees_ap_prd_min_qty'] : '';
													$ap_fees_ap_max_qty       = isset( $productfees['ap_fees_ap_prd_max_qty'] ) ? $productfees['ap_fees_ap_prd_max_qty'] : '';
													$ap_fees_ap_price_product = isset( $productfees['ap_fees_ap_price_product'] ) ? $productfees['ap_fees_ap_price_product'] : '';
													?>
													<tr id="ap_product_row_<?php echo esc_attr( $cnt_product ); ?>"
													    valign="top" class="ap_product_row_tr">
														<td class="titledesc" scope="row">
															<select rel-id="<?php echo esc_attr( $cnt_product ); ?>"
															        id="ap_product_fees_conditions_condition_<?php echo esc_attr( $cnt_product ); ?>"
															        name="fees[ap_product_fees_conditions_condition][<?php echo esc_attr( $cnt_product ); ?>][]"
															        id="ap_product_fees_conditions_condition"
															        class="wcpfc_select ap_product product_fees_conditions_values multiselect2"
															        multiple="multiple">
																<?php
																echo wp_kses( $wcpfc_admin_object->wcpfc_pro_get_product_options( $cnt_product, $fees_ap_fees_products ), Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );
																?>
															</select>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product ); ?> condition-value">
															<input type="number" name="fees[ap_fees_ap_prd_min_qty][]"
															       class="text-class qty-class"
															       id="ap_fees_ap_prd_min_qty[]"
															       placeholder="<?php esc_html_e( 'Min Quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_min_qty ); ?>"
															       min="1">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product ); ?> condition-value">
															<input type="number" name="fees[ap_fees_ap_prd_max_qty][]"
															       class="text-class qty-class"
															       id="ap_fees_ap_prd_max_qty[]"
															       placeholder="<?php esc_html_e( 'Max Quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_max_qty ); ?>"
															       min="1">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product ); ?> condition-value">
															<input type="text" name="fees[ap_fees_ap_price_product][]"
															       class="text-class number-field"
															       id="ap_fees_ap_price_product[]"
															       placeholder="<?php esc_html_e( 'Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_price_product ); ?>">
															<?php
															$first_char = substr( $ap_fees_ap_price_product, 0, 1 );
															if ( '-' === $first_char ) {
																$html = sprintf(
																	'<p><b style="color: red;">%s</b>%s',
																	esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
																	esc_html__( 'If entered fee amount is less than cart subtotal it will reflect with minus sign (EX: $ -10.00) OR If entered fee amount is more than cart subtotal then the total amount shown as zero (EX: Total: 0): ', 'woocommerce-conditional-product-fees-for-checkout' )
																);
																echo wp_kses_post( $html );
															}
															?>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product ); ?> condition-value">
															<a id="ap_product_delete_field"
															   rel-id="<?php echo esc_attr( $cnt_product ); ?>"
															   title="Delete" class="delete-row" href="javascript:;">
																<i class="fa fa-trash"></i>
															</a>
														</td>
													</tr>
													<?php
													$cnt_product ++;
												}
												?>
												<?php
											} else {
												$cnt_product = 1;
											}
											?>
											</tbody>
										</table>
										<input type="hidden" name="total_row_product" id="total_row_product"
										       value="<?php echo esc_attr( $cnt_product ); ?>">
									</div>
								</div>
								<?php // Advanced Pricing Product Section end here ?>

								<!-- Advanced Pricing Product Subtotal start here -->
								<div class="ap_product_subtotal_container advance_pricing_rule_box tab-content"
								     id="tab-2"
								     data-title="<?php esc_html_e( 'Cost on Product Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
									<div class="tap-class">
										<div class="predefined_elements">
											<div id="all_cart_subtotal">
												<option
													value="product_subtotal"><?php esc_html_e( 'Product Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											</div>
										</div>
										<div class="sub-title">
											<h2><?php esc_html_e( 'Cost on Product Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
											<div class="tap">
												<a id="ap-product-subtotal-add-field"
												   class="button button-primary button-large"
												   href="javascript:;"><?php esc_html_e( '+ Add Rule', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
												<div class="switch_status_div">
													<label class="switch switch_in_pricing_rules">
														<input type="checkbox"
														       name="cost_on_product_subtotal_status"
														       value="on" <?php echo esc_attr( $cost_on_product_subtotal_status ); ?>>
														<div class="slider round"></div>
													</label>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description switch_in_pricing_rules_description"
													   style="display:none;">
														<?php esc_html_e( WCPFC_PRO_PERTICULAR_FEE_AMOUNT_NOTICE, 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p>
												</div>
											</div>
											<div class="wocfc_match_type">
												<p class="switch_in_pricing_rules_description_left">
													<?php esc_html_e( 'below', 'woo-hide-shipping-methods' ); ?>
												</p>
												<select name="cost_rule_match[cost_on_product_subtotal_rule_match]"
												        id="cost_on_product_subtotal_rule_match"
												        class="arcmt_select">
													<option
														value="any" <?php selected( $cost_on_product_subtotal_rule_match, 'any' ) ?>><?php esc_html_e( 'Any One', 'woo-hide-shipping-methods' ); ?></option>
													<option
														value="all" <?php selected( $cost_on_product_subtotal_rule_match, 'all' ) ?>><?php esc_html_e( 'All', 'woo-hide-shipping-methods' ); ?></option>
												</select>
												<p class="switch_in_pricing_rules_description">
													<?php esc_html_e( 'rule match', 'woo-hide-shipping-methods' ); ?>
												</p>
											</div>
										</div>
										<table id="tbl_ap_product_subtotal_method"
										       class="tbl_product_subtotal table-outer tap-cas form-table fees-table">
											<tbody>
											<tr class="heading">
												<th class="titledesc th_product_subtotal_fees_conditions_condition"
												    scope="row"><?php esc_html_e( 'Product Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'Product Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
												</th>
												<th class="titledesc th_product_subtotal_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Min Subtotal ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a minimum total cart subtotal per row before the fee amount is
                                                        applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_product_subtotal_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Max Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a maximum total cart subtotal per row before the fee amount is
                                                        applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty then will set with maximum 999999999999999999999999999', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_product_subtotal_fees_conditions_condition"
												    scope="row"
												    colspan="2"><?php esc_html_e( 'Fee Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php
														esc_html_e( 'A fixed amount (e.g. 5 / -5) percentage (e.g. 5% / -5%) to add as a fee. Percentage and minus amount will apply based on cart subtotal.', 'woocommerce-conditional-product-fees-for-checkout' );
														?>
												</th>
											</tr>
											<?php
											//check advanced pricing value fill proper or unset if not
											$filled_product_subtotal = array();
											//check if category AP rules exist
											if ( ! empty( $sm_metabox_ap_product_subtotal ) && is_array( $sm_metabox_ap_product_subtotal ) ):
												foreach ( $sm_metabox_ap_product_subtotal as $apcat_arr ):
													//check that if required field fill or not once save the APR,  if match than fill in array
													if ( ! empty( $apcat_arr ) || $apcat_arr !== '' ) {
														if (
															( $apcat_arr['ap_fees_product_subtotal'] !== '' && $apcat_arr['ap_fees_ap_price_product_subtotal'] !== '' ) &&
															( $apcat_arr['ap_fees_ap_product_subtotal_min_subtotal'] !== '' || $apcat_arr['ap_fees_ap_product_subtotal_max_subtotal'] !== '' )
														) {
															$filled_product_subtotal[] = $apcat_arr;
														}
													}
												endforeach;
											endif;
											//check APR exist
											if ( isset( $filled_product_subtotal ) && ! empty( $filled_product_subtotal ) ) {
												$cnt_product_subtotal = 2;
												foreach ( $filled_product_subtotal as $key => $productfees ) {
													$fees_ap_fees_product_subtotal            = isset( $productfees['ap_fees_product_subtotal'] ) ? $productfees['ap_fees_product_subtotal'] : '';
													$ap_fees_ap_product_subtotal_min_subtotal = isset( $productfees['ap_fees_ap_product_subtotal_min_subtotal'] ) ? $productfees['ap_fees_ap_product_subtotal_min_subtotal'] : '';
													$ap_fees_ap_product_subtotal_max_subtotal = isset( $productfees['ap_fees_ap_product_subtotal_max_subtotal'] ) ? $productfees['ap_fees_ap_product_subtotal_max_subtotal'] : '';
													$ap_fees_ap_price_product_subtotal        = isset( $productfees['ap_fees_ap_price_product_subtotal'] ) ? $productfees['ap_fees_ap_price_product_subtotal'] : '';
													?>
													<tr id="ap_product_subtotal_row_<?php echo esc_attr( $cnt_product_subtotal ); ?>"
													    valign="top" class="ap_product_subtotal_row_tr">
														<td class="titledesc" scope="row">
															<select
																rel-id="<?php echo esc_attr( $cnt_product_subtotal ); ?>"
																id="ap_product_subtotal_fees_conditions_condition_<?php echo esc_attr( $cnt_product_subtotal ); ?>"
																name="fees[ap_product_subtotal_fees_conditions_condition][<?php echo esc_attr( $cnt_product_subtotal ); ?>][]"
																class="wcpfc_select ap_product product_fees_conditions_values multiselect2"
																multiple="multiple">
																<?php
																echo wp_kses( $wcpfc_admin_object->wcpfc_pro_get_product_options( $cnt_product_subtotal, $fees_ap_fees_product_subtotal ), $wcpfc_object::allowed_html_tags() );
																?>
															</select>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product_subtotal ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_product_subtotal_min_subtotal][]"
															       class="text-class price-class"
															       id="ap_fees_ap_product_subtotal_min_subtotal[]"
															       placeholder="<?php esc_html_e( 'Min Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       step="0.01"
															       value="<?php echo esc_attr( $ap_fees_ap_product_subtotal_min_subtotal ); ?>"
															       min="0.0">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product_subtotal ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_product_subtotal_max_subtotal][]"
															       class="text-class price-class"
															       id="ap_fees_ap_product_subtotal_max_subtotal[]"
															       placeholder="<?php esc_html_e( 'Max Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       step="0.01"
															       value="<?php echo esc_attr( $ap_fees_ap_product_subtotal_max_subtotal ); ?>"
															       min="0.0">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product_subtotal ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_price_product_subtotal][]"
															       class="text-class number-field"
															       id="ap_fees_ap_price_product_subtotal[]"
															       placeholder="<?php esc_html_e( 'Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_price_product_subtotal ); ?>">
															<?php
															//get first character for check is minus sign or not
															$first_char = substr( $ap_fees_ap_price_product_subtotal, 0, 1 );
															if ( '-' === $first_char ) {
																$html = sprintf(
																	'<p><b style="color: red;">%s</b>%s',
																	esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
																	esc_html__( 'If entered fee amount is less than cart subtotal it will reflect with minus sign (EX: $ -10.00) OR If entered fee amount is more than cart subtotal then the total amount shown as zero (EX: Total: 0): ', 'woocommerce-conditional-product-fees-for-checkout' )
																);
																echo wp_kses_post( $html );
															}
															?>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product_subtotal ); ?> condition-value">
															<a id="ap-product-subtotal-delete-field"
															   rel-id="<?php echo esc_attr( $cnt_product_subtotal ); ?>"
															   title="Delete" class="delete-row"
															   href="javascript:;">
																<i class="fa fa-trash"></i>
															</a>
														</td>
													</tr>
													<?php
													$cnt_product_subtotal ++;
												}
												?>
												<?php
											} else {
												$cnt_product_subtotal = 1;
											} ?>
											</tbody>
										</table>
										<input type="hidden" name="total_row_product_subtotal"
										       id="total_row_product_subtotal"
										       value="<?php echo esc_attr( $cnt_product_subtotal ); ?>">
										<!-- Advanced Pricing Category Section end here -->
									</div>
								</div>
								<!-- Advanced Pricing Product Subtotal end here -->
								
								<?php // Advanced Pricing Product Weight start here ?>
								<div class="ap_product_weight_container advance_pricing_rule_box tab-content" id="tab-3"
								     data-title="<?php esc_html_e( 'Cost on Product Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
									<div class="tap-class">
										<div class="predefined_elements">
											<div id="all_product_weight_list"></div>
										</div>
										<div class="sub-title">
											<h2><?php esc_html_e( 'Cost on Product Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
											<div class="tap">
												<a id="ap-product-weight-add-field"
												   class="button button-primary button-large"
												   href="javascript:;"><?php esc_html_e( '+ Add Rule', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
												<div class="switch_status_div">
													<label class="switch switch_in_pricing_rules">
														<input type="checkbox" name="cost_on_product_weight_status"
														       value="on" <?php echo esc_attr( $cost_on_product_weight_status ); ?>>
														<div class="slider round"></div>
													</label>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description switch_in_pricing_rules_description"
													   style="display:none;">
														<?php esc_html_e( 'You can turn off this button, if you do not need to apply this fee amount.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p>
												</div>
											</div>
											<div class="wocfc_match_type">
												<p class="switch_in_pricing_rules_description_left">
													<?php esc_html_e( 'below', 'woo-hide-shipping-methods' ); ?>
												</p>
												<select name="cost_rule_match[cost_on_product_weight_rule_match]"
												        id="cost_on_product_weight_rule_match" class="arcmt_select">
													<option
														value="any" <?php selected( $cost_on_product_weight_rule_match, 'any' ) ?>><?php esc_html_e( 'Any One', 'woo-hide-shipping-methods' ); ?></option>
													<option
														value="all" <?php selected( $cost_on_product_weight_rule_match, 'all' ) ?>><?php esc_html_e( 'All', 'woo-hide-shipping-methods' ); ?></option>
												</select>
												<p class="switch_in_pricing_rules_description">
													<?php esc_html_e( 'rule match', 'woo-hide-shipping-methods' ); ?>
												</p>
											</div>
										</div>
										<table id="tbl_ap_product_weight_method"
										       class="tbl_product_weight_fee table-outer tap-cas form-table fees-table">
											<tbody>
											<tr class="heading">
												<th class="titledesc th_product_weight_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Product', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'Select a product to apply the fee amount to when the min/max weight match.', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
												</th>
												<th class="titledesc th_product_weight_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Min Weight ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a minimum product weight per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a minimum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_product_weight_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Max Weight ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a maximum product weight per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a maximum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_product_weight_fees_conditions_condition"
												    scope="row"
												    colspan="2"><?php esc_html_e( 'Fee Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php
														esc_html_e( 'A fixed amount (e.g. 5 / -5) percentage (e.g. 5% / -5%) to add as a fee. Percentage and minus amount will apply based on cart subtotal.', 'woocommerce-conditional-product-fees-for-checkout' );
														?>
													</p>
												</th>
											</tr>
											<?php
											//check advanced pricing value fill proper or unset if not
											$product_weight_filled_arr = array();
											if ( ! empty( $sm_metabox_ap_product_weight ) && is_array( $sm_metabox_ap_product_weight ) ):
												foreach ( $sm_metabox_ap_product_weight as $app_arr ):
													//check that if required field fill or not once save the APR,  if match than fill in array
													if ( ! empty( $app_arr ) || '' !== $app_arr ) {
														if ( ( '' !== $app_arr['ap_fees_product_weight'] && '' !== $app_arr['ap_fees_ap_price_product_weight'] ) && ( '' !== $app_arr['ap_fees_ap_product_weight_min_qty'] || '' !== $app_arr['ap_fees_ap_product_weight_max_qty'] ) ) {
															//if condition match than fill in array
															$product_weight_filled_arr[] = $app_arr;
														}
													}
												endforeach;
											endif;
											//check APR exist
											if ( isset( $product_weight_filled_arr ) && ! empty( $product_weight_filled_arr ) ) {
												$cnt_product_weight = 2;
												foreach ( $product_weight_filled_arr as $key => $product_weight_fees ) {
													$fees_ap_fees_product_weight     = isset( $product_weight_fees['ap_fees_product_weight'] ) ? $product_weight_fees['ap_fees_product_weight'] : '';
													$ap_fees_product_weight_min_qty  = isset( $product_weight_fees['ap_fees_ap_product_weight_min_qty'] ) ? $product_weight_fees['ap_fees_ap_product_weight_min_qty'] : '';
													$ap_fees_product_weight_max_qty  = isset( $product_weight_fees['ap_fees_ap_product_weight_max_qty'] ) ? $product_weight_fees['ap_fees_ap_product_weight_max_qty'] : '';
													$ap_fees_ap_price_product_weight = isset( $product_weight_fees['ap_fees_ap_price_product_weight'] ) ? $product_weight_fees['ap_fees_ap_price_product_weight'] : '';
													?>
													<tr id="ap_product_weight_row_<?php echo esc_attr( $cnt_product_weight ); ?>"
													    valign="top" class="ap_product_weight_row_tr">
														<td class="titledesc" scope="row">
															<select
																rel-id="<?php echo esc_attr( $cnt_product_weight ); ?>"
																id="ap_product_weight_fees_conditions_condition_<?php echo esc_attr( $cnt_product_weight ); ?>"
																name="fees[ap_product_weight_fees_conditions_condition][<?php echo esc_attr( $cnt_product_weight ); ?>][]"
																id="ap_product_weight_fees_conditions_condition"
																class="wcpfc_select ap_product_weight product_fees_conditions_values multiselect2"
																multiple="multiple">
																<?php
																echo wp_kses( $wcpfc_admin_object->wcpfc_pro_get_product_options( $cnt_product_weight, $fees_ap_fees_product_weight ), Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );
																?>
															</select>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product_weight ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_product_weight_min_weight][]"
															       class="text-class weight-class"
															       id="ap_fees_ap_product_weight_min_weight[]"
															       placeholder="<?php esc_html_e( 'Min Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_product_weight_min_qty ); ?>">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product_weight ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_product_weight_max_weight][]"
															       class="text-class weight-class"
															       id="ap_fees_ap_product_weight_max_weight[]"
															       placeholder="<?php esc_html_e( 'Max Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_product_weight_max_qty ); ?>">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product_weight ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_price_product_weight][]"
															       class="text-class number-field"
															       id="ap_fees_ap_price_product_weight[]"
															       placeholder="<?php esc_html_e( 'Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_price_product_weight ); ?>">
															<?php
															//get first character for check is minus sign or not
															$first_char = substr( $ap_fees_ap_price_product_weight, 0, 1 );
															if ( '-' === $first_char ) {
																$html = sprintf(
																	'<p><b style="color: red;">%s</b>%s',
																	esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
																	esc_html__( 'If entered fee amount is less than cart subtotal it will reflect with minus sign (EX: $ -10.00) OR If entered fee amount is more than cart subtotal then the total amount shown as zero (EX: Total: 0): ', 'woocommerce-conditional-product-fees-for-checkout' )
																);
																echo wp_kses_post( $html );
															}
															?>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_product_weight ); ?> condition-value">
															<a id="ap_product_weight_delete_field"
															   rel-id="<?php echo esc_attr( $cnt_product_weight ); ?>"
															   title="Delete" class="delete-row" href="javascript:;">
																<i class="fa fa-trash"></i>
															</a>
														</td>
													</tr>
													<?php
													$cnt_product_weight ++;
												}
												?>
												<?php
											} else {
												$cnt_product_weight = 1;
											}
											?>
											</tbody>
										</table>
										<input type="hidden" name="total_row_product_weight"
										       id="total_row_product_weight"
										       value="<?php echo esc_attr( $cnt_product_weight ); ?>">
									</div>
								</div>
								<?php // Advanced PricingProduct Weight end here  ?>
								
								<?php // Advanced Pricing Category Section start here ?>
								<div class="ap_category_container advance_pricing_rule_box tab-content" id="tab-4"
								     data-title="<?php esc_html_e( 'Cost on Category', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
									<div class="tap-class">
										<div class="predefined_elements">
											<div id="all_category_list">
												<?php
												echo wp_kses( $wcpfc_admin_object->wcpfc_pro_get_category_options__premium_only( "", $json = true ), Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );
												?>
											</div>
										</div>
										<div class="sub-title">
											<h2><?php esc_html_e( 'Cost on Category', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
											<div class="tap">
												<a id="ap-category-add-field" class="button button-primary button-large"
												   href="javascript:;"><?php esc_html_e( '+ Add Rule', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
												<div class="switch_status_div">
													<label class="switch switch_in_pricing_rules">
														<input type="checkbox" name="cost_on_category_status"
														       value="on" <?php echo esc_attr( $cost_on_category_status ); ?>>
														<div class="slider round"></div>
													</label>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description switch_in_pricing_rules_description"
													   style="display:none;">
														<?php esc_html_e( 'You can turn off this button, if you do not need to apply this fee amount.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p>
												</div>
											</div>
											<div class="wocfc_match_type">
												<p class="switch_in_pricing_rules_description_left">
													<?php esc_html_e( 'below', 'woo-hide-shipping-methods' ); ?>
												</p>
												<select name="cost_rule_match[cost_on_category_rule_match]"
												        id="cost_on_category_rule_match" class="arcmt_select">
													<option
														value="any" <?php selected( $cost_on_category_rule_match, 'any' ) ?>><?php esc_html_e( 'Any One', 'woo-hide-shipping-methods' ); ?></option>
													<option
														value="all" <?php selected( $cost_on_category_rule_match, 'all' ) ?>><?php esc_html_e( 'All', 'woo-hide-shipping-methods' ); ?></option>
												</select>
												<p class="switch_in_pricing_rules_description">
													<?php esc_html_e( 'rule match', 'woo-hide-shipping-methods' ); ?>
												</p>
											</div>
										</div>
										<table id="tbl_ap_category_method"
										       class="tbl_category_fee table-outer tap-cas form-table fees-table">
											<tbody>
											<tr class="heading">
												<th class="titledesc th_category_fees_conditions_condition"
												    scope="row"><?php esc_html_e( 'Category', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'Select a category to apply the fee amount to when the min/max quantity match.', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
												</th>
												<th class="titledesc th_category_fees_conditions_condition" scope="row">
													<?php esc_html_e( 'Min Quantity ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a minimum category quantity per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a minimum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_category_fees_conditions_condition" scope="row">
													<?php esc_html_e( 'Max Quantity ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a maximum category quantity per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a maximum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_category_fees_conditions_condition" scope="row"
												    colspan="2"><?php esc_html_e( 'Fee amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php
														esc_html_e( 'A fixed amount (e.g. 5 / -5) percentage (e.g. 5% / -5%) to add as a fee. Percentage and minus amount will apply based on cart subtotal.', 'woocommerce-conditional-product-fees-for-checkout' );
														?>
													</p>
												</th>
											</tr>
											<?php
											//check advanced pricing value fill proper or unset if not
											$filled_arr = array();
											//check if category AP rules exist
											if ( ! empty( $sm_metabox_ap_category ) && is_array( $sm_metabox_ap_category ) ):
												foreach ( $sm_metabox_ap_category as $apcat_arr ):
													//check that if required field fill or not once save the APR,  if match than fill in array
													if ( ! empty( $apcat_arr ) || '' !== $apcat_arr ) {
														if ( ( '' !== $apcat_arr['ap_fees_categories'] && '' !== $apcat_arr['ap_fees_ap_price_category'] ) &&
														     ( '' !== $apcat_arr['ap_fees_ap_cat_min_qty'] || '' !== $apcat_arr['ap_fees_ap_cat_max_qty'] ) ) {
															//if condition match than fill in array
															$filled_arr[] = $apcat_arr;
														}
													}
												endforeach;
											endif;
											//check APR exist
											if ( isset( $filled_arr ) && ! empty( $filled_arr ) ) {
												$cnt_category = 2;
												foreach ( $filled_arr as $key => $productfees ) {
													$fees_ap_fees_categories   = isset( $productfees['ap_fees_categories'] ) ? $productfees['ap_fees_categories'] : '';
													$ap_fees_ap_cat_min_qty    = isset( $productfees['ap_fees_ap_cat_min_qty'] ) ? $productfees['ap_fees_ap_cat_min_qty'] : '';
													$ap_fees_ap_cat_max_qty    = isset( $productfees['ap_fees_ap_cat_max_qty'] ) ? $productfees['ap_fees_ap_cat_max_qty'] : '';
													$ap_fees_ap_price_category = isset( $productfees['ap_fees_ap_price_category'] ) ? $productfees['ap_fees_ap_price_category'] : '';
													?>
													<tr id="ap_category_row_<?php echo esc_attr( $cnt_category ); ?>"
													    valign="top"
													    class="ap_category_row_tr">
														<td class="titledesc" scope="row">
															<select rel-id="<?php echo esc_attr( $cnt_category ); ?>"
															        id="ap_category_fees_conditions_condition_<?php echo esc_attr( $cnt_category ); ?>"
															        name="fees[ap_category_fees_conditions_condition][<?php echo esc_attr( $cnt_category ); ?>][]"
															        id="ap_category_fees_conditions_condition"
															        class="wcpfc_select ap_category product_fees_conditions_values multiselect2"
															        multiple="multiple">
																<?php
																echo wp_kses( $wcpfc_admin_object->wcpfc_pro_get_category_options__premium_only( $fees_ap_fees_categories, $json = false ), Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );
																?>
															</select>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_cat_min_qty][]"
															       class="text-class qty-class"
															       id="ap_fees_ap_cat_min_qty[]"
															       placeholder="<?php esc_html_e( 'Min Quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_cat_min_qty ); ?>"
															       min="1">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_cat_max_qty][]"
															       class="text-class qty-class"
															       id="ap_fees_ap_cat_max_qty[]"
															       placeholder="<?php esc_html_e( 'Max Quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_cat_max_qty ); ?>"
															       min="1">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_price_category][]"
															       class="text-class number-field"
															       id="ap_fees_ap_price_category[]"
															       placeholder="<?php esc_html_e( 'Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_price_category ); ?>">
															<?php
															//get first character for check is minus sign or not
															$first_char = substr( $ap_fees_ap_price_category, 0, 1 );
															if ( '-' === $first_char ) {
																$html = sprintf(
																	'<p><b style="color: red;">%s</b>%s',
																	esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
																	esc_html__( 'If entered fee amount is less than cart subtotal it will reflect with minus sign (EX: $ -10.00) OR If entered fee amount is more than cart subtotal then the total amount shown as zero (EX: Total: 0): ', 'woocommerce-conditional-product-fees-for-checkout' )
																);
																echo wp_kses_post( $html );
															}
															?>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category ); ?> condition-value">
															<a id="ap_category_delete_field"
															   rel-id="<?php echo esc_attr( $cnt_category ); ?>"
															   title="Delete" class="delete-row" href="javascript:;">
																<i class="fa fa-trash"></i>
															</a>
														</td>
													</tr>
													<?php
													$cnt_category ++;
												}
												?>
												<?php
											} else {
												$cnt_category = 1;
											}
											?>
											</tbody>
										</table>
										<input type="hidden" name="total_row_category" id="total_row_category"
										       value="<?php echo esc_attr( $cnt_category ); ?>">
										<!-- Advanced Pricing Category Section end here -->
									</div>
								</div>
								<?php // Advanced Pricing Category Section end here  ?>

								<!-- Advanced Pricing Category Subtotal start here -->
								<div class="ap_category_subtotal_container advance_pricing_rule_box tab-content"
								     id="tab-5"
								     data-title="<?php esc_html_e( 'Cost on Category Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
									<div class="tap-class">
										<div class="predefined_elements">
											<div id="all_cart_subtotal">
												<option
													value="category_subtotal"><?php esc_html_e( 'Category Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											</div>
										</div>
										<div class="sub-title">
											<h2><?php esc_html_e( 'Cost on Category Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
											<div class="tap">
												<a id="ap-category-subtotal-add-field"
												   class="button button-primary button-large"
												   href="javascript:;"><?php esc_html_e( '+ Add Rule', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
												<div class="switch_status_div">
													<label class="switch switch_in_pricing_rules">
														<input type="checkbox"
														       name="cost_on_category_subtotal_status"
														       value="on" <?php echo esc_attr( $cost_on_category_subtotal_status ); ?>>
														<div class="slider round"></div>
													</label>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description switch_in_pricing_rules_description"
													   style="display:none;">
														<?php esc_html_e( WCPFC_PRO_PERTICULAR_FEE_AMOUNT_NOTICE, 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p>
												</div>
											</div>
											<div class="wocfc_match_type">
												<p class="switch_in_pricing_rules_description_left">
													<?php esc_html_e( 'below', 'woo-hide-shipping-methods' ); ?>
												</p>
												<select name="cost_rule_match[cost_on_category_subtotal_rule_match]"
												        id="cost_on_category_subtotal_rule_match"
												        class="arcmt_select">
													<option
														value="any" <?php selected( $cost_on_category_subtotal_rule_match, 'any' ) ?>><?php esc_html_e( 'Any One', 'woo-hide-shipping-methods' ); ?></option>
													<option
														value="all" <?php selected( $cost_on_category_subtotal_rule_match, 'all' ) ?>><?php esc_html_e( 'All', 'woo-hide-shipping-methods' ); ?></option>
												</select>
												<p class="switch_in_pricing_rules_description">
													<?php esc_html_e( 'rule match', 'woo-hide-shipping-methods' ); ?>
												</p>
											</div>
										</div>
										<table id="tbl_ap_category_subtotal_method"
										       class="tbl_category_subtotal table-outer tap-cas form-table fees-table">
											<tbody>
											<tr class="heading">
												<th class="titledesc th_category_subtotal_fees_conditions_condition"
												    scope="row"><?php esc_html_e( 'Category Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'Category Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
												</th>
												<th class="titledesc th_category_subtotal_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Min Subtotal ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a minimum total cart subtotal per row before the fee amount is
                                                        applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_category_subtotal_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Max Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a maximum total cart subtotal per row before the fee amount is
                                                        applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty then will set with maximum 999999999999999999999999999', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_category_subtotal_fees_conditions_condition"
												    scope="row"
												    colspan="2"><?php esc_html_e( 'Fee Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php
														esc_html_e( 'A fixed amount (e.g. 5 / -5) percentage (e.g. 5% / -5%) to add as a fee. Percentage and minus amount will apply based on cart subtotal.', 'woocommerce-conditional-product-fees-for-checkout' );
														?>
												</th>
											</tr>
											<?php
											//check advanced pricing value fill proper or unset if not
											$filled_category_subtotal = array();
											//check if category AP rules exist
											if ( ! empty( $sm_metabox_ap_category_subtotal ) && is_array( $sm_metabox_ap_category_subtotal ) ):
												foreach ( $sm_metabox_ap_category_subtotal as $apcat_arr ):
													//check that if required field fill or not once save the APR,  if match than fill in array
													if ( ! empty( $apcat_arr ) || $apcat_arr !== '' ) {
														if (
															( $apcat_arr['ap_fees_category_subtotal'] !== '' && $apcat_arr['ap_fees_ap_price_category_subtotal'] !== '' ) &&
															( $apcat_arr['ap_fees_ap_category_subtotal_min_subtotal'] !== '' || $apcat_arr['ap_fees_ap_category_subtotal_max_subtotal'] !== '' )
														) {
															$filled_category_subtotal[] = $apcat_arr;
														}
													}
												endforeach;
											endif;
											//check APR exist
											if ( isset( $filled_category_subtotal ) && ! empty( $filled_category_subtotal ) ) {
												$cnt_category_subtotal = 2;
												foreach ( $filled_category_subtotal as $key => $productfees ) {
													$fees_ap_fees_category_subtotal            = isset( $productfees['ap_fees_category_subtotal'] ) ? $productfees['ap_fees_category_subtotal'] : '';
													$ap_fees_ap_category_subtotal_min_subtotal = isset( $productfees['ap_fees_ap_category_subtotal_min_subtotal'] ) ? $productfees['ap_fees_ap_category_subtotal_min_subtotal'] : '';
													$ap_fees_ap_category_subtotal_max_subtotal = isset( $productfees['ap_fees_ap_category_subtotal_max_subtotal'] ) ? $productfees['ap_fees_ap_category_subtotal_max_subtotal'] : '';
													$ap_fees_ap_price_category_subtotal        = isset( $productfees['ap_fees_ap_price_category_subtotal'] ) ? $productfees['ap_fees_ap_price_category_subtotal'] : '';
													?>
													<tr id="ap_category_subtotal_row_<?php echo esc_attr( $cnt_category_subtotal ); ?>"
													    valign="top" class="ap_category_subtotal_row_tr">
														<td class="titledesc" scope="row">
															<select
																rel-id="<?php echo esc_attr( $cnt_category_subtotal ); ?>"
																id="ap_category_subtotal_fees_conditions_condition_<?php echo esc_attr( $cnt_category_subtotal ); ?>"
																name="fees[ap_category_subtotal_fees_conditions_condition][<?php echo esc_attr( $cnt_category_subtotal ); ?>][]"
																id="ap_category_subtotal_fees_conditions_condition"
																class="wcpfc_select ap_category_subtotal product_fees_conditions_values multiselect2"
																multiple="multiple">
																<?php
																echo wp_kses( $wcpfc_admin_object->wcpfc_pro_get_category_options__premium_only( $fees_ap_fees_category_subtotal, $json = false ), $wcpfc_object::allowed_html_tags() );
																?>
															</select>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category_subtotal ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_category_subtotal_min_subtotal][]"
															       class="text-class price-class"
															       id="ap_fees_ap_category_subtotal_min_subtotal[]"
															       placeholder="<?php esc_html_e( 'Min Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       step="0.01"
															       value="<?php echo esc_attr( $ap_fees_ap_category_subtotal_min_subtotal ); ?>"
															       min="0.0">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category_subtotal ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_category_subtotal_max_subtotal][]"
															       class="text-class price-class"
															       id="ap_fees_ap_category_subtotal_max_subtotal[]"
															       placeholder="<?php esc_html_e( 'Max Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       step="0.01"
															       value="<?php echo esc_attr( $ap_fees_ap_category_subtotal_max_subtotal ); ?>"
															       min="0.0">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category_subtotal ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_price_category_subtotal][]"
															       class="text-class number-field"
															       id="ap_fees_ap_price_category_subtotal[]"
															       placeholder="<?php esc_html_e( 'Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_price_category_subtotal ); ?>">
															<?php
															//get first character for check is minus sign or not
															$first_char = substr( $ap_fees_ap_price_category_subtotal, 0, 1 );
															if ( '-' === $first_char ) {
																$html = sprintf(
																	'<p><b style="color: red;">%s</b>%s',
																	esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
																	esc_html__( 'If entered fee amount is less than cart subtotal it will reflect with minus sign (EX: $ -10.00) OR If entered fee amount is more than cart subtotal then the total amount shown as zero (EX: Total: 0): ', 'woocommerce-conditional-product-fees-for-checkout' )
																);
																echo wp_kses_post( $html );
															}
															?>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category_subtotal ); ?> condition-value">
															<a id="ap-category-subtotal-delete-field"
															   rel-id="<?php echo esc_attr( $cnt_category_subtotal ); ?>"
															   title="Delete" class="delete-row"
															   href="javascript:;">
																<i class="fa fa-trash"></i>
															</a>
														</td>
													</tr>
													<?php
													$cnt_category_subtotal ++;
												}
												?>
												<?php
											} else {
												$cnt_category_subtotal = 1;
											} ?>
											</tbody>
										</table>
										<input type="hidden" name="total_row_category_subtotal"
										       id="total_row_category_subtotal"
										       value="<?php echo esc_attr( $cnt_category_subtotal ); ?>">
										<!-- Advanced Pricing Category Section end here -->

									</div>
								</div>
								<!-- Advanced Pricing Category Subtotal  end here -->
								
								<?php // Advanced Pricing Category Weight start here  ?>
								<div class="ap_category_weight_container advance_pricing_rule_box tab-content"
								     id="tab-6"
								     data-title="<?php esc_html_e( 'Cost on Category Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
									<div class="tap-class">
										<div class="predefined_elements">
											<div id="all_category_weight_list">
												<option
													value=""><?php esc_html_e( 'Select Category', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
												<?php
												echo wp_kses( $wcpfc_admin_object->wcpfc_pro_get_category_options__premium_only( "", $json = true ), Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );
												?>
											</div>
										</div>
										<div class="sub-title">
											<h2><?php esc_html_e( 'Cost on Category Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
											<div class="tap">
												<a id="ap-category-weight-add-field"
												   class="button button-primary button-large"
												   href="javascript:;"><?php esc_html_e( '+ Add Rule', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
												<div class="switch_status_div">
													<label class="switch switch_in_pricing_rules">
														<input type="checkbox" name="cost_on_category_weight_status"
														       value="on" <?php echo esc_attr( $cost_on_category_weight_status ); ?>>
														<div class="slider round"></div>
													</label>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description switch_in_pricing_rules_description"
													   style="display:none;">
														<?php esc_html_e( WCPFC_PRO_PERTICULAR_FEE_AMOUNT_NOTICE, 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p>
												</div>
											</div>
											<div class="wocfc_match_type">
												<p class="switch_in_pricing_rules_description_left">
													<?php esc_html_e( 'below', 'woo-hide-shipping-methods' ); ?>
												</p>
												<select name="cost_rule_match[cost_on_category_weight_rule_match]"
												        id="cost_on_category_weight_rule_match"
												        class="arcmt_select">
													<option
														value="any" <?php selected( $cost_on_category_weight_rule_match, 'any' ) ?>><?php esc_html_e( 'Any One', 'woo-hide-shipping-methods' ); ?></option>
													<option
														value="all" <?php selected( $cost_on_category_weight_rule_match, 'all' ) ?>><?php esc_html_e( 'All', 'woo-hide-shipping-methods' ); ?></option>
												</select>
												<p class="switch_in_pricing_rules_description">
													<?php esc_html_e( 'rule match', 'woo-hide-shipping-methods' ); ?>
												</p>
											</div>
										</div>
										<table id="tbl_ap_category_weight_method"
										       class="tbl_category_weight_fee table-outer tap-cas form-table fees-table">
											<tbody>
											<tr class="heading">
												<th class="titledesc th_category_weight_fees_conditions_condition"
												    scope="row"><?php esc_html_e( 'Category', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'Select a category to apply the fee amount to when the min/max weight match.', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
												</th>
												<th class="titledesc th_category_weight_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Min Weight ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a minimum category weight per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a minimum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_category_weight_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Max Weight ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a maximum category weight per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a maximum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_category_weight_fees_conditions_condition"
												    scope="row"
												    colspan="2"><?php esc_html_e( 'Fee Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php
														esc_html_e( 'A fixed amount (e.g. 5 / -5) percentage (e.g. 5% / -5%) to add as a fee. Percentage and minus amount will apply based on cart subtotal.', 'woocommerce-conditional-product-fees-for-checkout' );
														?>
													</p>
												</th>
											</tr>
											<?php
											//check advanced pricing value fill proper or unset if not
											$filled_arr_cat_weight = array();
											//check if category AP rules exist
											if ( ! empty( $sm_metabox_ap_category_weight ) && is_array( $sm_metabox_ap_category_weight ) ):
												foreach ( $sm_metabox_ap_category_weight as $apcat_arr ):
													//check that if required field fill or not once save the APR,  if match than fill in array
													if ( ! empty( $apcat_arr ) || '' !== $apcat_arr ) {
														if ( ( '' !== $apcat_arr['ap_fees_categories_weight'] && '' !== $apcat_arr['ap_fees_categories_weight'] ) &&
														     ( '' !== $apcat_arr['ap_fees_ap_category_weight_min_qty'] || '' !== $apcat_arr['ap_fees_ap_category_weight_max_qty'] ) ) {
															//if condition match than fill in array
															$filled_arr_cat_weight[] = $apcat_arr;
														}
													}
												endforeach;
											endif;
											//check APR exist
											if ( isset( $filled_arr_cat_weight ) && ! empty( $filled_arr_cat_weight ) ) {
												$cnt_category_weight = 2;
												foreach ( $filled_arr_cat_weight as $key => $productfees ) {
													$fees_ap_fees_categories_weight     = isset( $productfees['ap_fees_categories_weight'] ) ? $productfees['ap_fees_categories_weight'] : '';
													$ap_fees_ap_category_weight_min_qty = isset( $productfees['ap_fees_ap_category_weight_min_qty'] ) ? $productfees['ap_fees_ap_category_weight_min_qty'] : '';
													$ap_fees_ap_category_weight_max_qty = isset( $productfees['ap_fees_ap_category_weight_max_qty'] ) ? $productfees['ap_fees_ap_category_weight_max_qty'] : '';
													$ap_fees_ap_price_category_weight   = isset( $productfees['ap_fees_ap_price_category_weight'] ) ? $productfees['ap_fees_ap_price_category_weight'] : '';
													?>
													<tr id="ap_category_weight_row_<?php echo esc_attr( $cnt_category_weight ); ?>"
													    valign="top" class="ap_category_weight_row_tr">
														<td class="titledesc" scope="row">
															<select
																rel-id="<?php echo esc_attr( $cnt_category_weight ); ?>"
																id="ap_category_weight_fees_conditions_condition_<?php echo esc_attr( $cnt_category_weight ); ?>"
																name="fees[ap_category_weight_fees_conditions_condition][<?php echo esc_attr( $cnt_category_weight ); ?>][]"
																id="ap_category_weight_fees_conditions_condition"
																class="wcpfc_select ap_category_weight product_fees_conditions_values multiselect2"
																multiple="multiple">
																<?php
																echo wp_kses( $wcpfc_admin_object->wcpfc_pro_get_category_options__premium_only( $fees_ap_fees_categories_weight, $json = false ), Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );
																?>
															</select>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category_weight ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_category_weight_min_weight][]"
															       class="text-class weight-class"
															       id="ap_fees_ap_category_weight_min_weight[]"
															       placeholder="<?php esc_html_e( 'Min Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_category_weight_min_qty ); ?>">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category_weight ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_category_weight_max_weight][]"
															       class="text-class weight-class"
															       id="ap_fees_ap_category_weight_max_weight[]"
															       placeholder="<?php esc_html_e( 'Max Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_category_weight_max_qty ); ?>">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category_weight ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_price_category_weight][]"
															       class="text-class number-field"
															       id="ap_fees_ap_price_category_weight[]"
															       placeholder="<?php esc_html_e( 'Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_price_category_weight ); ?>">
															<?php
															//get first character for check is minus sign or not
															$first_char = substr( $ap_fees_ap_price_category_weight, 0, 1 );
															if ( '-' === $first_char ) {
																$html = sprintf(
																	'<p><b style="color: red;">%s</b>%s',
																	esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
																	esc_html__( 'If entered fee amount is less than cart subtotal it will reflect with minus sign (EX: $ -10.00) OR If entered fee amount is more than cart subtotal then the total amount shown as zero (EX: Total: 0): ', 'woocommerce-conditional-product-fees-for-checkout' )
																);
																echo wp_kses_post( $html );
															}
															?>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_category_weight ); ?> condition-value">
															<a id="ap_category_weight_delete_field"
															   rel-id="<?php echo esc_attr( $cnt_category_weight ); ?>"
															   title="Delete" class="delete-row" href="javascript:;">
																<i class="fa fa-trash"></i>
															</a>
														</td>
													</tr>
													<?php
													$cnt_category_weight ++;
												}
												?>
												<?php
											} else {
												$cnt_category_weight = 1;
											}
											?>
											</tbody>
										</table>
										<input type="hidden" name="total_row_category_weight"
										       id="total_row_category_weight"
										       value="<?php echo esc_attr( $cnt_category_weight ); ?>">
										<!-- Advanced Pricing Category Section end here -->
									</div>
								</div>
								<?php // Advanced Pricing Category Weight end here  ?>
								
								<?php // Advanced Pricing Total QTY start here  ?>
								<div class="ap_total_cart_container advance_pricing_rule_box tab-content" id="tab-7"
								     data-title="<?php esc_html_e( 'Cost on Total Cart Qty', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
									<div class="tap-class">
										<div class="predefined_elements">
											<div id="all_cart_qty">
												<option
													value="total_cart_qty"><?php esc_html_e( 'Total Cart Qty', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											</div>
										</div>
										<div class="sub-title">
											<h2><?php esc_html_e( 'Cost on Total Cart Qty', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
											<div class="tap">
												<a id="ap-total-cart-qty-add-field"
												   class="button button-primary button-large"
												   href="javascript:;"><?php esc_html_e( '+ Add Rule', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
												<div class="switch_status_div">
													<label class="switch switch_in_pricing_rules">
														<input type="checkbox" name="cost_on_total_cart_qty_status"
														       value="on" <?php echo esc_attr( $cost_on_total_cart_qty_status ); ?>>
														<div class="slider round"></div>
													</label>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description switch_in_pricing_rules_description"
													   style="display:none;">
														<?php esc_html_e( 'You can turn off this button, if you do not need to apply this fee amount.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p>
												</div>
											</div>
											<div class="wocfc_match_type">
												<p class="switch_in_pricing_rules_description_left">
													<?php esc_html_e( 'below', 'woo-hide-shipping-methods' ); ?>
												</p>
												<select name="cost_rule_match[cost_on_total_cart_qty_rule_match]"
												        id="cost_on_total_cart_qty_rule_match" class="arcmt_select">
													<option
														value="any" <?php selected( $cost_on_total_cart_qty_rule_match, 'any' ) ?>><?php esc_html_e( 'Any One', 'woo-hide-shipping-methods' ); ?></option>
													<option
														value="all" <?php selected( $cost_on_total_cart_qty_rule_match, 'all' ) ?>><?php esc_html_e( 'All', 'woo-hide-shipping-methods' ); ?></option>
												</select>
												<p class="switch_in_pricing_rules_description">
													<?php esc_html_e( 'rule match', 'woo-hide-shipping-methods' ); ?>
												</p>
											</div>
										</div>
										<table id="tbl_ap_total_cart_qty_method"
										       class="tbl_total_cart_qty table-outer tap-cas form-table fees-table">
											<tbody>
											<tr class="heading">
												<th class="titledesc th_total_cart_qty_fees_conditions_condition"
												    scope="row"><?php esc_html_e( 'Total Cart Qty', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'Total Cart Qty', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
												</th>
												<th class="titledesc th_total_cart_qty_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Min Quantity ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a minimum total cart quantity per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a minimum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_total_cart_qty_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Max Quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a maximum total cart quantity per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a maximum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_total_cart_qty_fees_conditions_condition"
												    scope="row"
												    colspan="2"><?php esc_html_e( 'Fee amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php
														esc_html_e( 'A fixed amount (e.g. 5 / -5) percentage (e.g. 5% / -5%) to add as a fee. Percentage and minus amount will apply based on cart subtotal.', 'woocommerce-conditional-product-fees-for-checkout' );
														?>
													</p>
												</th>
											</tr>
											<?php
											//check advanced pricing value fill proper or unset if not
											$filled_total_cart_qty = array();
											//check if category AP rules exist
											if ( ! empty( $sm_metabox_ap_total_cart_qty ) && is_array( $sm_metabox_ap_total_cart_qty ) ):
												foreach ( $sm_metabox_ap_total_cart_qty as $apcat_arr ):
													//check that if required field fill or not once save the APR,  if match than fill in array
													if ( ! empty( $apcat_arr ) || '' !== $apcat_arr ) {
														if ( ( '' !== $apcat_arr['ap_fees_total_cart_qty'] && '' !== $apcat_arr['ap_fees_ap_price_total_cart_qty'] ) &&
														     ( '' !== $apcat_arr['ap_fees_ap_total_cart_qty_min_qty'] || '' !== $apcat_arr['ap_fees_ap_total_cart_qty_max_qty'] ) ) {
															//if condition match than fill in array
															$filled_total_cart_qty[] = $apcat_arr;
														}
													}
												endforeach;
											endif;
											//check APR exist
											if ( isset( $filled_total_cart_qty ) && ! empty( $filled_total_cart_qty ) ) {
												$cnt_total_cart_qty = 2;
												foreach ( $filled_total_cart_qty as $key => $productfees ) {
													$fees_ap_fees_total_cart_qty       = isset( $productfees['ap_fees_total_cart_qty'] ) ? $productfees['ap_fees_total_cart_qty'] : '';
													$ap_fees_ap_total_cart_qty_min_qty = isset( $productfees['ap_fees_ap_total_cart_qty_min_qty'] ) ? $productfees['ap_fees_ap_total_cart_qty_min_qty'] : '';
													$ap_fees_ap_total_cart_qty_max_qty = isset( $productfees['ap_fees_ap_total_cart_qty_max_qty'] ) ? $productfees['ap_fees_ap_total_cart_qty_max_qty'] : '';
													$ap_fees_ap_price_total_cart_qty   = isset( $productfees['ap_fees_ap_price_total_cart_qty'] ) ? $productfees['ap_fees_ap_price_total_cart_qty'] : '';
													?>
													<tr id="ap_total_cart_qty_row_<?php echo esc_attr( $cnt_total_cart_qty ); ?>"
													    valign="top" class="ap_total_cart_qty_row_tr">
														<td class="titledesc" scope="row">
															<label><?php echo esc_html_e( 'Cart Qty', 'woocommerce-conditional-product-fees-for-checkout' ); ?></label>
															<input type="hidden"
															       name="fees[ap_total_cart_qty_fees_conditions_condition][<?php echo esc_attr( $cnt_total_cart_qty ); ?>][]"
															       id="ap_total_cart_qty_fees_conditions_condition_<?php echo esc_attr( $cnt_total_cart_qty ); ?>">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_qty ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_total_cart_qty_min_qty][]"
															       class="text-class qty-class"
															       id="ap_fees_ap_total_cart_qty_min_qty[]"
															       placeholder="<?php esc_html_e( 'Min Quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_total_cart_qty_min_qty ); ?>"
															       min="1">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_qty ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_total_cart_qty_max_qty][]"
															       class="text-class qty-class"
															       id="ap_fees_ap_total_cart_qty_max_qty[]"
															       placeholder="<?php esc_html_e( 'Max Quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_total_cart_qty_max_qty ); ?>"
															       min="1">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_qty ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_price_total_cart_qty][]"
															       class="text-class number-field"
															       id="ap_fees_ap_price_total_cart_qty[]"
															       placeholder="<?php esc_html_e( 'Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_price_total_cart_qty ); ?>">
															<?php
															//get first character for check is minus sign or not
															$first_char = substr( $ap_fees_ap_price_total_cart_qty, 0, 1 );
															if ( '-' === $first_char ) {
																$html = sprintf(
																	'<p><b style="color: red;">%s</b>%s',
																	esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
																	esc_html__( 'If entered fee amount is less than cart subtotal it will reflect with minus sign (EX: $ -10.00) OR If entered fee amount is more than cart subtotal then the total amount shown as zero (EX: Total: 0): ', 'woocommerce-conditional-product-fees-for-checkout' )
																);
																echo wp_kses_post( $html );
															}
															?>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_qty ); ?> condition-value">
															<a id="ap_total_cart_qty_delete-field"
															   rel-id="<?php echo esc_attr( $cnt_total_cart_qty ); ?>"
															   title="Delete" class="delete-row" href="javascript:;">
																<i class="fa fa-trash"></i>
															</a>
														</td>
													</tr>
													<?php
													$cnt_total_cart_qty ++;
												}
												?>
												<?php
											} else {
												$cnt_total_cart_qty = 1;
												?>
											<?php }
											?>
											</tbody>
										</table>
										<input type="hidden" name="total_row_total_cart_qty"
										       id="total_row_total_cart_qty"
										       value="<?php echo esc_attr( $cnt_total_cart_qty ); ?>">
										<!-- Advanced Pricing Category Section end here -->
									</div>
								</div>
								<?php // Advanced Pricing Total QTY end here ?>
								
								<?php // Advanced Pricing Total Cart Weight start here  ?>
								<div class="ap_total_cart_weight_container advance_pricing_rule_box tab-content"
								     id="tab-8"
								     data-title="<?php esc_html_e( 'Cost on Total Cart Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
									<div class="tap-class">
										<div class="predefined_elements">
											<div id="all_cart_weight">
												<option
													value="total_cart_weight"><?php esc_html_e( 'Total Cart Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											</div>
										</div>
										<div class="sub-title">
											<h2><?php esc_html_e( 'Cost on Total Cart Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
											<div class="tap">
												<a id="ap-total-cart-weight-add-field"
												   class="button button-primary button-large"
												   href="javascript:;"><?php esc_html_e( '+ Add Rule', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
												<div class="switch_status_div">
													<label class="switch switch_in_pricing_rules">
														<input type="checkbox" name="cost_on_total_cart_weight_status"
														       value="on" <?php echo esc_attr( $cost_on_total_cart_weight_status ); ?>>
														<div class="slider round"></div>
													</label>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description switch_in_pricing_rules_description"
													   style="display:none;">
														<?php esc_html_e( WCPFC_PRO_PERTICULAR_FEE_AMOUNT_NOTICE, 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p>
												</div>
											</div>
											<div class="wocfc_match_type">
												<p class="switch_in_pricing_rules_description_left">
													<?php esc_html_e( 'below', 'woo-hide-shipping-methods' ); ?>
												</p>
												<select name="cost_rule_match[cost_on_total_cart_weight_rule_match]"
												        id="cost_on_total_cart_weight_rule_match"
												        class="arcmt_select">
													<option
														value="any" <?php selected( $cost_on_total_cart_weight_rule_match, 'any' ) ?>><?php esc_html_e( 'Any One', 'woo-hide-shipping-methods' ); ?></option>
													<option
														value="all" <?php selected( $cost_on_total_cart_weight_rule_match, 'all' ) ?>><?php esc_html_e( 'All', 'woo-hide-shipping-methods' ); ?></option>
												</select>
												<p class="switch_in_pricing_rules_description">
													<?php esc_html_e( 'rule match', 'woo-hide-shipping-methods' ); ?>
												</p>
											</div>
										</div>
										<table id="tbl_ap_total_cart_weight_method"
										       class="tbl_total_cart_weight table-outer tap-cas form-table fees-table">
											<tbody>
											<tr class="heading">
												<th class="titledesc th_total_cart_weight_fees_conditions_condition"
												    scope="row"><?php esc_html_e( 'Total Cart Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'Total Cart Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
												</th>
												<th class="titledesc th_total_cart_weight_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Min Weight ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a minimum total cart weight per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a minimum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_total_cart_weight_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Max Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a maximum total cart weight per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty to not set a maximum.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_total_cart_weight_fees_conditions_condition"
												    scope="row"
												    colspan="2"><?php esc_html_e( 'Fee Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php
														esc_html_e( 'A fixed amount (e.g. 5 / -5) percentage (e.g. 5% / -5%) to add as a fee. Percentage and minus amount will apply based on cart subtotal.', 'woocommerce-conditional-product-fees-for-checkout' );
														?>
													</p>
												</th>
											</tr>
											<?php
											//check advanced pricing value fill proper or unset if not
											$filled_total_cart_weight = array();
											//check if category AP rules exist
											if ( ! empty( $sm_metabox_ap_total_cart_weight ) && is_array( $sm_metabox_ap_total_cart_weight ) ):
												foreach ( $sm_metabox_ap_total_cart_weight as $apcat_arr ):
													//check that if required field fill or not once save the APR,  if match than fill in array
													if ( ! empty( $apcat_arr ) || '' !== $apcat_arr ) {
														if ( ( '' !== $apcat_arr['ap_fees_total_cart_weight'] && '' !== $apcat_arr['ap_fees_ap_price_total_cart_weight'] ) &&
														     ( '' !== $apcat_arr['ap_fees_ap_total_cart_weight_min_weight'] || '' !== $apcat_arr['ap_fees_ap_total_cart_weight_max_weight'] ) ) {
															//if condition match than fill in array
															$filled_total_cart_weight[] = $apcat_arr;
														}
													}
												endforeach;
											endif;
											//check APR exist
											if ( isset( $filled_total_cart_weight ) && ! empty( $filled_total_cart_weight ) ) {
												$cnt_total_cart_weight = 2;
												foreach ( $filled_total_cart_weight as $key => $productfees ) {
													$fees_ap_fees_total_cart_weight          = isset( $productfees['ap_fees_total_cart_weight'] ) ? $productfees['ap_fees_total_cart_weight'] : '';
													$ap_fees_ap_total_cart_weight_min_weight = isset( $productfees['ap_fees_ap_total_cart_weight_min_weight'] ) ? $productfees['ap_fees_ap_total_cart_weight_min_weight'] : '';
													$ap_fees_ap_total_cart_weight_max_weight = isset( $productfees['ap_fees_ap_total_cart_weight_max_weight'] ) ? $productfees['ap_fees_ap_total_cart_weight_max_weight'] : '';
													$ap_fees_ap_price_total_cart_weight      = isset( $productfees['ap_fees_ap_price_total_cart_weight'] ) ? $productfees['ap_fees_ap_price_total_cart_weight'] : '';
													?>
													<tr id="ap_total_cart_weight_row_<?php echo esc_attr( $cnt_total_cart_weight ); ?>"
													    valign="top" class="ap_total_cart_weight_row_tr">
														<td class="titledesc" scope="row">
															<label><?php echo esc_html_e( 'Cart Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?></label>
															<input type="hidden"
															       name="fees[ap_total_cart_weight_fees_conditions_condition][<?php echo esc_attr( $cnt_total_cart_weight ); ?>][]"
															       id="ap_total_cart_weight_fees_conditions_condition_<?php echo esc_attr( $cnt_total_cart_weight ); ?>">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_weight ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_total_cart_weight_min_weight][]"
															       class="text-class weight-class"
															       id="ap_fees_ap_total_cart_weight_min_weight[]"
															       placeholder="<?php esc_html_e( 'Min Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_total_cart_weight_min_weight ); ?>">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_weight ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_total_cart_weight_max_weight][]"
															       class="text-class weight-class"
															       id="ap_fees_ap_total_cart_weight_max_weight[]"
															       placeholder="<?php esc_html_e( 'Max Weight', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_total_cart_weight_max_weight ); ?>">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_weight ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_price_total_cart_weight][]"
															       class="text-class number-field"
															       id="ap_fees_ap_price_total_cart_weight[]"
															       placeholder="<?php esc_html_e( 'Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_price_total_cart_weight ); ?>">
															<?php
															$first_char = substr( $ap_fees_ap_price_total_cart_weight, 0, 1 );
															if ( '-' === $first_char ) {
																$html = sprintf(
																	'<p><b style="color: red;">%s</b>%s',
																	esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
																	esc_html__( 'If entered fee amount is less than cart subtotal it will reflect with minus sign (EX: $ -10.00) OR If entered fee amount is more than cart subtotal then the total amount shown as zero (EX: Total: 0): ', 'woocommerce-conditional-product-fees-for-checkout' )
																);
																echo wp_kses_post( $html );
															}
															?>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_weight ); ?> condition-value">
															<a id="ap_total_cart_weight_delete_field"
															   rel-id="<?php echo esc_attr( $cnt_total_cart_weight ); ?>"
															   title="Delete" class="delete-row" href="javascript:;">
																<i class="fa fa-trash"></i>
															</a>
														</td>
													</tr>
													<?php
													$cnt_total_cart_weight ++;
												}
												?>
												<?php
											} else {
												$cnt_total_cart_weight = 1;
											}
											?>
											</tbody>
										</table>
										<input type="hidden" name="total_row_total_cart_weight"
										       id="total_row_total_cart_weight"
										       value="<?php echo esc_attr( $cnt_total_cart_weight ); ?>">
										<!-- Advanced Pricing Category Section end here -->
									</div>
								</div>
								<?php //Advanced Pricing Total Cart Weight  end here  ?>

								<!-- Advanced Pricing Total Cart Subtotal start here -->
								<div class="ap_total_cart_subtotal_container advance_pricing_rule_box tab-content"
								     id="tab-9"
								     data-title="<?php esc_html_e( 'Cost on Total Cart Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
									<div class="tap-class">
										<div class="predefined_elements">
											<div id="all_cart_subtotal">
												<option
													value="total_cart_subtotal"><?php esc_html_e( 'Total Cart Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?></option>
											</div>
										</div>
										<div class="sub-title">
											<h2><?php esc_html_e( 'Cost on Total Cart Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
											<div class="tap">
												<a id="ap-total-cart-subtotal-add-field"
												   class="button button-primary button-large"
												   href="javascript:;"><?php esc_html_e( '+ Add Rule', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
												<div class="switch_status_div">
													<label class="switch switch_in_pricing_rules">
														<input type="checkbox"
														       name="cost_on_total_cart_subtotal_status"
														       value="on" <?php echo esc_attr( $cost_on_total_cart_subtotal_status ); ?>>
														<div class="slider round"></div>
													</label>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description switch_in_pricing_rules_description"
													   style="display:none;">
														<?php esc_html_e( WCPFC_PRO_PERTICULAR_FEE_AMOUNT_NOTICE, 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p>
												</div>
											</div>
											<div class="wocfc_match_type">
												<p class="switch_in_pricing_rules_description_left">
													<?php esc_html_e( 'below', 'woo-hide-shipping-methods' ); ?>
												</p>
												<select name="cost_rule_match[cost_on_total_cart_subtotal_rule_match]"
												        id="cost_on_total_cart_subtotal_rule_match"
												        class="arcmt_select">
													<option
														value="any" <?php selected( $cost_on_total_cart_subtotal_rule_match, 'any' ) ?>><?php esc_html_e( 'Any One', 'woo-hide-shipping-methods' ); ?></option>
													<option
														value="all" <?php selected( $cost_on_total_cart_subtotal_rule_match, 'all' ) ?>><?php esc_html_e( 'All', 'woo-hide-shipping-methods' ); ?></option>
												</select>
												<p class="switch_in_pricing_rules_description">
													<?php esc_html_e( 'rule match', 'woo-hide-shipping-methods' ); ?>
												</p>
											</div>
										</div>
										<table id="tbl_ap_total_cart_subtotal_method"
										       class="tbl_total_cart_subtotal table-outer tap-cas form-table fees-table">
											<tbody>
											<tr class="heading">
												<th class="titledesc th_total_cart_subtotal_fees_conditions_condition"
												    scope="row"><?php esc_html_e( 'Total Cart Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'Total Cart Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
												</th>
												<th class="titledesc th_total_cart_subtotal_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Min Subtotal ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a minimum total cart subtotal per row before the fee amount is
                                                        applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_total_cart_subtotal_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Max Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a maximum total cart subtotal per row before the fee amount is
                                                        applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty then will set with maximum 999999999999999999999999999', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_total_cart_subtotal_fees_conditions_condition"
												    scope="row"
												    colspan="2"><?php esc_html_e( 'Fee Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php
														esc_html_e( 'A fixed amount (e.g. 5 / -5) percentage (e.g. 5% / -5%) to add as a fee. Percentage and minus amount will apply based on cart subtotal.', 'woocommerce-conditional-product-fees-for-checkout' );
														?>
												</th>
											</tr>
											<?php
											//check advanced pricing value fill proper or unset if not
											$filled_total_cart_subtotal = array();
											//check if category AP rules exist
											if ( ! empty( $sm_metabox_ap_total_cart_subtotal ) && is_array( $sm_metabox_ap_total_cart_subtotal ) ):
												foreach ( $sm_metabox_ap_total_cart_subtotal as $apcat_arr ):
													//check that if required field fill or not once save the APR,  if match than fill in array
													if ( ! empty( $apcat_arr ) || $apcat_arr !== '' ) {
														if (
															( $apcat_arr['ap_fees_total_cart_subtotal'] !== '' && $apcat_arr['ap_fees_ap_price_total_cart_subtotal'] !== '' ) &&
															( $apcat_arr['ap_fees_ap_total_cart_subtotal_min_subtotal'] !== '' || $apcat_arr['ap_fees_ap_total_cart_subtotal_max_subtotal'] !== '' )
														) {
															$filled_total_cart_subtotal[] = $apcat_arr;
														}
													}
												endforeach;
											endif;
											//check APR exist
											if ( isset( $filled_total_cart_subtotal ) && ! empty( $filled_total_cart_subtotal ) ) {
												$cnt_total_cart_subtotal = 2;
												foreach ( $filled_total_cart_subtotal as $key => $productfees ) {
													$fees_ap_fees_total_cart_subtotal            = isset( $productfees['ap_fees_total_cart_subtotal'] ) ? $productfees['ap_fees_total_cart_subtotal'] : '';
													$ap_fees_ap_total_cart_subtotal_min_subtotal = isset( $productfees['ap_fees_ap_total_cart_subtotal_min_subtotal'] ) ? $productfees['ap_fees_ap_total_cart_subtotal_min_subtotal'] : '';
													$ap_fees_ap_total_cart_subtotal_max_subtotal = isset( $productfees['ap_fees_ap_total_cart_subtotal_max_subtotal'] ) ? $productfees['ap_fees_ap_total_cart_subtotal_max_subtotal'] : '';
													$ap_fees_ap_price_total_cart_subtotal        = isset( $productfees['ap_fees_ap_price_total_cart_subtotal'] ) ? $productfees['ap_fees_ap_price_total_cart_subtotal'] : '';
													?>
													<tr id="ap_total_cart_subtotal_row_<?php echo esc_attr( $cnt_total_cart_subtotal ); ?>"
													    valign="top" class="ap_total_cart_subtotal_row_tr">
														<td class="titledesc" scope="row">
															<label><?php echo esc_html_e( 'Cart Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?></label>
															<input type="hidden"
															       name="fees[ap_total_cart_subtotal_fees_conditions_condition][<?php echo esc_attr( $cnt_total_cart_subtotal ); ?>][]"
															       id="ap_total_cart_subtotal_fees_conditions_condition_<?php echo esc_attr( $cnt_total_cart_subtotal ); ?>">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_subtotal ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_total_cart_subtotal_min_subtotal][]"
															       class="text-class price-class"
															       id="ap_fees_ap_total_cart_subtotal_min_subtotal[]"
															       placeholder="<?php esc_html_e( 'Min Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       step="0.01"
															       value="<?php echo esc_attr( $ap_fees_ap_total_cart_subtotal_min_subtotal ); ?>"
															       min="0.0">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_subtotal ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_total_cart_subtotal_max_subtotal][]"
															       class="text-class price-class"
															       id="ap_fees_ap_total_cart_subtotal_max_subtotal[]"
															       placeholder="<?php esc_html_e( 'Max Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       step="0.01"
															       value="<?php echo esc_attr( $ap_fees_ap_total_cart_subtotal_max_subtotal ); ?>"
															       min="0.0">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_subtotal ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_price_total_cart_subtotal][]"
															       class="text-class number-field"
															       id="ap_fees_ap_price_total_cart_subtotal[]"
															       placeholder="<?php esc_html_e( 'Amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_price_total_cart_subtotal ); ?>">
															<?php
															$first_char = substr( $ap_fees_ap_price_total_cart_subtotal, 0, 1 );
															if ( '-' === $first_char ) {
																$html = sprintf(
																	'<p><b style="color: red;">%s</b>%s',
																	esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
																	esc_html__( 'If entered fee amount is less than cart subtotal it will reflect with minus sign (EX: $ -10.00) OR If entered fee amount is more than cart subtotal then the total amount shown as zero (EX: Total: 0): ', 'woocommerce-conditional-product-fees-for-checkout' )
																);
																echo wp_kses_post( $html );
															}
															?>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_total_cart_subtotal ); ?> condition-value">
															<a id="ap-total-cart-subtotal-delete-field"
															   rel-id="<?php echo esc_attr( $cnt_total_cart_subtotal ); ?>"
															   title="Delete" class="delete-row"
															   href="javascript:;">
																<i class="fa fa-trash"></i>
															</a>
														</td>
													</tr>
													<?php
													$cnt_total_cart_subtotal ++;
												}
												?>
												<?php
											} else {
												$cnt_total_cart_subtotal = 1;
											} ?>
											</tbody>
										</table>
										<input type="hidden" name="total_row_total_cart_subtotal"
										       id="total_row_total_cart_subtotal"
										       value="<?php echo esc_attr( $cnt_total_cart_subtotal ); ?>">
										<!-- Advanced Pricing Category Section end here -->

									</div>
								</div>
								<!-- Advanced Pricing Total Cart Subtotal  end here -->
								
								<?php // Advanced Pricing Shipping Class Subtotal Section start here ?>
								<div class="ap_shipping_class_subtotal_container advance_pricing_rule_box tab-content"
								     id="tab-10"
								     data-title="<?php esc_html_e( 'Cost on Shipping Class Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
									<div class="tap-class">
										<div class="predefined_elements">
											<div id="all_shipping_class_list">
												<?php
												echo wp_kses( $wcpfc_admin_object->wcpfc_pro_get_class_options__premium_only( '', $json = true ), Woocommerce_Conditional_Product_Fees_For_Checkout_Pro::allowed_html_tags() );
												?>
											</div>
										</div>
										<div class="sub-title">
											<h2><?php esc_html_e( 'Cost on Shipping Class Subtotal', 'woocommerce-conditional-product-fees-for-checkout' ); ?></h2>
											<div class="tap">
												<a id="ap-shipping-class-subtotal-add-field"
												   class="button button-primary button-large"
												   href="javascript:;"><?php esc_html_e( '+ Add Rule', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
												<div class="switch_status_div">
													<label class="switch switch_in_pricing_rules">
														<input type="checkbox"
														       name="cost_on_shipping_class_subtotal_status"
														       value="on" <?php echo esc_attr( $cost_on_shipping_class_subtotal_status ); ?>>
														<div class="slider round"></div>
													</label>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description switch_in_pricing_rules_description"
													   style="display:none;">
														<?php esc_html_e( WCPFC_PRO_PERTICULAR_FEE_AMOUNT_NOTICE, 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p>
												</div>
											</div>
											<div class="wocfc_match_type">
												<p class="switch_in_pricing_rules_description_left">
													<?php esc_html_e( 'below', 'woo-hide-shipping-methods' ); ?>
												</p>
												<select
													name="cost_rule_match[cost_on_shipping_class_subtotal_rule_match]"
													id="cost_on_shipping_class_subtotal_rule_match"
													class="arcmt_select">
													<option
														value="any" <?php selected( $cost_on_shipping_class_subtotal_rule_match, 'any' ) ?>><?php esc_html_e( 'Any One', 'woo-hide-shipping-methods' ); ?></option>
													<option
														value="all" <?php selected( $cost_on_shipping_class_subtotal_rule_match, 'all' ) ?>><?php esc_html_e( 'All', 'woo-hide-shipping-methods' ); ?></option>
												</select>
												<p class="switch_in_pricing_rules_description">
													<?php esc_html_e( 'rule match', 'woo-hide-shipping-methods' ); ?>
												</p>
											</div>
										</div>
										<table id="tbl_ap_shipping_class_subtotal_method"
										       class="tbl_shipping_class_subtotal_fee table-outer tap-cas form-table fees-table">
											<tbody>
											<tr class="heading">
												<th class="titledesc th_shipping_class_subtotal_fees_conditions_condition"
												    scope="row"><?php esc_html_e( 'Shipping Class', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'Select a category to apply the fee amount to when the min/max quantity match.', 'woocommerce-conditional-product-fees-for-checkout' ); ?></p>
												</th>
												<th class="titledesc th_shipping_class_subtotal_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Min Subtotal ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a minimum category quantity per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_shipping_class_subtotal_fees_conditions_condition"
												    scope="row">
													<?php esc_html_e( 'Max Subtotal ', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php esc_html_e( 'You can set a maximum category quantity per row before the fee amount is applied.', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
														<br/><?php esc_html_e( 'Leave empty then will set with maximum 999999999999999999999999999', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													</p></th>
												<th class="titledesc th_shipping_class_subtotal_fees_conditions_condition"
												    scope="row"
												    colspan="2"><?php esc_html_e( 'Fee amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
													<span
														class="woocommerce_conditional_product_fees_checkout_tab_description"></span>
													<p class="description" style="display:none;">
														<?php
														esc_html_e( 'A fixed amount (e.g. 5 / -5) percentage (e.g. 5% / -5%) to add as a fee. Percentage and minus amount will apply based on cart subtotal.', 'woocommerce-conditional-product-fees-for-checkout' );
														?>
													</p>
												</th>
											</tr>
											<?php
											//check advanced pricing value fill proper or unset if not
											$filled_arr = array();
											//check if category AP rules exist
											if ( ! empty( $sm_metabox_ap_shipping_class_subtotal ) && is_array( $sm_metabox_ap_shipping_class_subtotal ) ):
												foreach ( $sm_metabox_ap_shipping_class_subtotal as $apscs_arr ):
													//check that if required field fill or not once save the APR,  if match than fill in array
													if ( ! empty( $apscs_arr ) || '' !== $apscs_arr ) {
														if ( ( '' !== $apscs_arr['ap_fees_shipping_class_subtotals'] && '' !== $apscs_arr['ap_fees_ap_price_shipping_class_subtotal'] ) &&
														     ( '' !== $apscs_arr['ap_fees_ap_shipping_class_subtotal_min_subtotal'] || '' !== $apscs_arr['ap_fees_ap_shipping_class_subtotal_max_subtotal'] ) ) {
															//if condition match than fill in array
															$filled_arr[] = $apscs_arr;
														}
													}
												endforeach;
											endif;
											//check APR exist
											if ( isset( $filled_arr ) && ! empty( $filled_arr ) ) {
												$cnt_shipping_class_subtotal = 2;
												foreach ( $filled_arr as $key => $productfees ) {
													$fees_ap_fees_shipping_class_subtotals           = isset( $productfees['ap_fees_shipping_class_subtotals'] ) ? $productfees['ap_fees_shipping_class_subtotals'] : '';
													$ap_fees_ap_shipping_class_subtotal_min_subtotal = isset( $productfees['ap_fees_ap_shipping_class_subtotal_min_subtotal'] ) ? $productfees['ap_fees_ap_shipping_class_subtotal_min_subtotal'] : '';
													$ap_fees_ap_shipping_class_subtotal_max_subtotal = isset( $productfees['ap_fees_ap_shipping_class_subtotal_max_subtotal'] ) ? $productfees['ap_fees_ap_shipping_class_subtotal_max_subtotal'] : '';
													$ap_fees_ap_price_shipping_class_subtotal        = isset( $productfees['ap_fees_ap_price_shipping_class_subtotal'] ) ? $productfees['ap_fees_ap_price_shipping_class_subtotal'] : '';
													?>
													<tr id="ap_shipping_class_subtotal_row_<?php echo esc_attr( $cnt_shipping_class_subtotal ); ?>"
													    valign="top"
													    class="ap_shipping_class_subtotal_row_tr">
														<td class="titledesc" scope="row">
															<select
																rel-id="<?php echo esc_attr( $cnt_shipping_class_subtotal ); ?>"
																id="ap_shipping_class_subtotal_fees_conditions_condition_<?php echo esc_attr( $cnt_shipping_class_subtotal ); ?>"
																name="fees[ap_shipping_class_subtotal_fees_conditions_condition][<?php echo esc_attr( $cnt_shipping_class_subtotal ); ?>][]"
																id="ap_shipping_class_subtotal_fees_conditions_condition"
																class="wcpfc_select ap_shipping_class_subtotal product_fees_conditions_values multiselect2"
																multiple="multiple">
																<?php
																echo wp_kses( $wcpfc_admin_object->wcpfc_pro_get_class_options__premium_only( $fees_ap_fees_shipping_class_subtotals, $json = false ), $wcpfc_object::allowed_html_tags() );
																?>
															</select>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_shipping_class_subtotal ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_shipping_class_subtotal_min_subtotal][]"
															       class="text-class qty-class"
															       id="ap_fees_ap_shipping_class_subtotal_min_subtotal[]"
															       placeholder="<?php esc_html_e( 'Min quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_shipping_class_subtotal_min_subtotal ); ?>"
															       min="1">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_shipping_class_subtotal ); ?> condition-value">
															<input type="number"
															       name="fees[ap_fees_ap_shipping_class_subtotal_max_subtotal][]"
															       class="text-class qty-class"
															       id="ap_fees_ap_shipping_class_subtotal_max_subtotal[]"
															       placeholder="<?php esc_html_e( 'Max quantity', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_shipping_class_subtotal_max_subtotal ); ?>"
															       min="1">
														</td>
														<td class="column_<?php echo esc_attr( $cnt_shipping_class_subtotal ); ?> condition-value">
															<input type="text"
															       name="fees[ap_fees_ap_price_shipping_class_subtotal][]"
															       class="text-class number-field"
															       id="ap_fees_ap_price_shipping_class_subtotal[]"
															       placeholder="<?php esc_html_e( 'amount', 'woocommerce-conditional-product-fees-for-checkout' ); ?>"
															       value="<?php echo esc_attr( $ap_fees_ap_price_shipping_class_subtotal ); ?>">
															<?php
															//get first character for check is minus sign or not
															$first_char = substr( $ap_fees_ap_price_shipping_class_subtotal, 0, 1 );
															if ( '-' === $first_char ) {
																$html = sprintf(
																	'<p><b style="color: red;">%s</b>%s',
																	esc_html__( 'Note: ', 'woocommerce-conditional-product-fees-for-checkout' ),
																	esc_html__( 'If entered fee amount is less than cart subtotal it will reflect with minus sign (EX: $ -10.00) OR If entered fee amount is more than cart subtotal then the total amount shown as zero (EX: Total: 0): ', 'woocommerce-conditional-product-fees-for-checkout' )
																);
																echo wp_kses_post( $html );
															}
															?>
														</td>
														<td class="column_<?php echo esc_attr( $cnt_shipping_class_subtotal ); ?> condition-value">
															<a id="ap-shipping-class-subtotal-delete-field"
															   rel-id="<?php echo esc_attr( $cnt_shipping_class_subtotal ); ?>"
															   title="Delete" class="delete-row"
															   href="javascript:;">
																<i class="fa fa-trash"></i>
															</a>
														</td>
													</tr>
													<?php
													$cnt_shipping_class_subtotal ++;
												}
												?>
												<?php
											} else {
												$cnt_shipping_class_subtotal = 1;
											}
											?>
											</tbody>
										</table>
										<input type="hidden" name="total_row_shipping_class_subtotal"
										       id="total_row_shipping_class_subtotal"
										       value="<?php echo esc_attr( $cnt_shipping_class_subtotal ); ?>">
										<!-- Advanced Pricing Category Section end here -->
									</div>
								</div>
								<?php // Advanced Pricing Shipping Class Subtotal Section end here  ?>
							</div>
						</div>
					</div>
					<?php // Advanced Pricing Section end  ?>
					<?php
				}
			}
			?>
			<p class="submit"><input type="submit" name="submitFee" class="button button-primary button-large"
			                         value="<?php echo esc_attr( $btnValue ); ?>"></p>
		</form>
	</div>
</div>

<?php require_once( plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php' ); ?>
