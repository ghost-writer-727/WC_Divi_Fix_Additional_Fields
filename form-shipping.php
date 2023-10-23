<?php
/**
 * Checkout shipping information form, with 2 added filters
 * so that we can control when shipping & additional fields
 * are shown.
 */

defined( 'ABSPATH' ) || exit;

/**** ADDED FILTER TO HIDE SHIPPING ****/
if( ! apply_filters('wc_divi_hide_shipping_fields', false) ){
?>
<div class="woocommerce-shipping-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<h3 id="ship-to-different-address">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
			</label>
		</h3>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
				$fields = $checkout->get_checkout_fields( 'shipping' );

				foreach ( $fields as $key => $field ) {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>
</div>
<?php 
/**** END ADDED FILTER ****/
}

/**** ADDED FILTER TO HIDE ADDITIONAL ****/
if( ! apply_filters('wc_divi_hide_additional_fields', false) ){
?>
<div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php 
			$datepicker_ids = [];
			foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
				<?php 
					// Store any datepicker fields so we can initialize them later in custom script
					if( $field['type'] == 'date' && $field['enabled'] == 1){
						$datepicker_ids[] = $key;
					}
					
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>

<script>
	jQuery(document).ready(function($){
		<?php foreach( $datepicker_ids as $id ){ ?>
			$('#<?php echo $id; ?>').on('change', function(){
				// Create a hidden text input with the same name as the datepicker field
				// Add the hidden field to the form named "checkout"
				$('<input type="hidden" name="<?php echo $id; ?>" value="' + $(this).val() + '">').prependTo('form[name=checkout]');
			});
		<?php } ?>
	});
</script>
<?php 
/**** END ADDED FILTER ****/
}
