<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$image_url = WCPFC_PRO_PLUGIN_URL . 'admin/images/right_click.png';
?>
<div class="dotstore_plugin_sidebar">
	<?php
	if ( wcpffc_fs()->is__premium_only() ) {
		if ( wcpffc_fs()->can_use_premium_code() ) {
		}
	} else {
		?>
		<div class="dotstore_discount_voucher">
			<span
				class="dotstore_discount_title"><?php esc_html_e( 'Discount Voucher', 'woocommerce-conditional-product-fees-for-checkout' ); ?></span>
			<span
				class="dotstore-upgrade"><?php esc_html_e( 'Upgrade to premium now and get', 'woocommerce-conditional-product-fees-for-checkout' ); ?></span>
			<strong
				class="dotstore-OFF"><?php esc_html_e( '10% OFF', 'woocommerce-conditional-product-fees-for-checkout' ); ?></strong>
			<span
				class="dotstore-with-code"><?php esc_html_e( 'with code', 'woocommerce-conditional-product-fees-for-checkout' ); ?>
			<b><?php esc_html_e( 'DOT10', 'woocommerce-conditional-product-fees-for-checkout' ); ?></b></span>
			<a class="dotstore-upgrade"
			   href="<?php echo esc_url( 'www.thedotstore.com/woocommerce-conditional-product-fees-checkout' ); ?>"
			   target="_blank"><?php esc_html_e( 'Upgrade Now!', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
		</div>
		<?php
	}
	$review_url = '';
	$plugin_at  = '';
	if ( wcpffc_fs()->is__premium_only() ) {
		if ( wcpffc_fs()->can_use_premium_code() ) {
			$review_url = esc_url( 'https://www.thedotstore.com/woocommerce-conditional-product-fees-checkout/#tab-reviews' );
		    $plugin_at  = 'theDotstore';
		}
	} else {
		$review_url = esc_url( 'https://wordpress.org/plugins/woo-conditional-product-fees-for-checkout/#reviews' );
		$plugin_at  = 'WP.org';
	}
	?>
	<div class="dotstore-important-link">
		<div class="image_box">
			<img src="<?php echo esc_url( WCPFC_PRO_PLUGIN_URL . 'admin/images/rate-us.png' ); ?>" alt="">
		</div>
		<div class="content_box">
			<h3>Like This Plugin?</h3>
			<p>Your Review is very important to us as it helps us to grow more.</p>
			<a class="btn_style" href="<?php echo $review_url;?>" target="_blank">Review Us on <?php echo $plugin_at; ?></a>
		</div>
	</div>
	<div class="dotstore-important-link">
		<div class="video-detail important-link">
			<a href="https://www.youtube.com/watch?v=7JJhUsDwJy4" target="_blank">
				<img width="100%"
				     src="<?php echo esc_url( WCPFC_PRO_PLUGIN_URL . 'admin/images/plugin-videodemo.png' ); ?>"
				     alt="<?php esc_html__( 'WooCommerce Conditional Product Fees For Checkout', 'woocommerce-conditional-product-fees-for-checkout' ); ?>">
			</a>
		</div>
	</div>

	<div class="dotstore-important-link">
		<h2><span
				class="dotstore-important-link-title"><?php esc_html_e( 'Important link', 'woocommerce-conditional-product-fees-for-checkout' ); ?></span>
		</h2>
		<div class="video-detail important-link">
			<ul>
				<li>
					<img src="<?php echo esc_url( $image_url ); ?>">
					<a target="_blank"
					   href="<?php echo esc_url( "https://www.thedotstore.com/docs/plugins/woocommerce-conditional-product-fees-checkout" ); ?>"><?php esc_html_e( 'Plugin documentation', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
				</li>
				<li>
					<img src="<?php echo esc_url( $image_url ); ?>">
					<a target="_blank"
					   href="<?php echo esc_url( "https://www.thedotstore.com/support/" ); ?>"><?php esc_html_e( 'Support platform', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
				</li>
				<li>
					<img src="<?php echo esc_url( $image_url ); ?>">
					<a target="_blank"
					   href="<?php echo esc_url( "https://www.thedotstore.com/suggest-a-feature" ); ?>"><?php esc_html_e( 'Suggest A Feature', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
				</li>
				<li>
					<img src="<?php echo esc_url( $image_url ); ?>">
					<a target="_blank"
					   href="<?php echo esc_url( "https://www.thedotstore.com/woocommerce-conditional-product-fees-checkout" ); ?>"><?php esc_html_e( 'Buy Plugin', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
				</li>
			</ul>
		</div>
	</div>

	<!-- html for popular plugin !-->
	<div class="dotstore-important-link">
		<h2><span
				class="dotstore-important-link-title"><?php esc_html_e( 'OUR POPULAR PLUGINS', 'woocommerce-conditional-product-fees-for-checkout' ); ?></span>
		</h2>
		<div class="video-detail important-link">
			<ul>
				<li>
					<img class="sidebar_plugin_icone"
					     src="<?php echo esc_url( WCPFC_PRO_PLUGIN_URL . 'admin/images/advance-flat-rate.png' ); ?>">
					<a target="_blank"
					   href="<?php echo esc_url( "https://www.thedotstore.com/advanced-flat-rate-shipping-method-for-woocommerce" ); ?>"><?php esc_html_e( 'Advanced Flat Rate Shipping Method', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
				</li>
				<li>
					<img class="sidebar_plugin_icone"
					     src="<?php echo esc_url( WCPFC_PRO_PLUGIN_URL . 'admin/images/wc-conditional-product-fees.png' ); ?>">
					<a target="_blank"
					   href="<?php echo esc_url( "https://www.thedotstore.com/woocommerce-conditional-product-fees-checkout" ); ?>"><?php esc_html_e( 'WooCommerce Conditional Product Fees', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
				</li>
				<li>
					<img class="sidebar_plugin_icone"
					     src="<?php echo esc_url( WCPFC_PRO_PLUGIN_URL . 'admin/images/advance-menu-manager.png' ); ?>">
					<a target="_blank"
					   href="<?php echo esc_url( "https://www.thedotstore.com/advance-menu-manager-wordpress" ); ?>"><?php esc_html_e( 'Advance Menu Manager', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
				</li>
				<li>
					<img class="sidebar_plugin_icone"
					     src="<?php echo esc_url( WCPFC_PRO_PLUGIN_URL . 'admin/images/wc-enhanced-ecommerce-analytics-integration.png' ); ?>">
					<a target="_blank"
					   href="<?php echo esc_url( "https://www.thedotstore.com/woocommerce-enhanced-ecommerce-analytics-integration-with-conversion-tracking" ); ?>"><?php esc_html_e( 'Woo Enhanced Ecommerce Analytics Integration', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
				</li>
				<li>
					<img class="sidebar_plugin_icone"
					     src="<?php echo esc_url( WCPFC_PRO_PLUGIN_URL . 'admin/images/advanced-product-size-charts.png' ); ?>">
					<a target="_blank"
					   href="<?php echo esc_url( "https://www.thedotstore.com/woocommerce-advanced-product-size-charts" ); ?>"><?php esc_html_e( 'Advanced Product Size Charts', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
				</li>

				</br>
			</ul>
		</div>
		<div class="view-button">
			<a class="view_button_dotstore" target="_blank"
			   href="<?php echo esc_url( "https://www.thedotstore.com/plugins" ); ?>"><?php esc_html_e( 'VIEW ALL', 'woocommerce-conditional-product-fees-for-checkout' ); ?></a>
		</div>
	</div>
	<!-- html end for popular plugin !-->
</div>
</div>
</body>
</html>