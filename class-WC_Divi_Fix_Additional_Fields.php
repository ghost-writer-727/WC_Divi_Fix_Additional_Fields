<?php
if( !class_exists('WC_Divi_Fix_Additional_Fields')):
class WC_Divi_Fix_Additional_Fields{
	/*
	 * Divi merely hides additional fields when building the checkout form under Shipping Address details.
	 * Therefore, when you add the Additional Fields modules, there are DOM ID conflicts because of all the duplicate fields.
	 * This can cause big headaches with the datepicker fields as well as other javascript and jQuery conflicts.
	 * 
	 * I have added a form-shipping.php template which is used to render only the shipping fields or
	 * only the additional fields, depending on the current divi module being rendered.
	 * 
	 * If the shipping nor additional fields modules are defined, then it should show all fields by default. IE. When using the default WooCommerce checkout form.
	 */

	private $current_module;

	public function __construct(){		
		add_filter( 'wc_get_template', [$this,'replace_shipping_form'], PHP_INT_MAX, 2 );
		add_filter('et_pb_module_shortcode_attributes', [$this, 'get_current_module'], 10, 3);
		add_filter('wc_divi_hide_shipping_fields', [$this, 'hide_shipping_fields']);
		add_filter('wc_divi_hide_additional_fields', [$this, 'hide_additional_fields']);
		
	}

	public function replace_shipping_form($template, $template_name){
		if( $template_name == 'checkout/form-shipping.php' ){
			$template = __DIR__ . '/form-shipping.php';
		}
		return $template;
	}

	public function get_current_module($props, $attrs, $slug){
		$this->current_module = $slug;
		return $props;
	}

	public function hide_shipping_fields(){
		if ($this->editing_divi_template() || $this->editing_visual_builder()) {
			return false;
		}
		return $this->current_module == 'et_pb_wc_checkout_additional_info';
	}
	
	public function hide_additional_fields(){
		if ($this->editing_divi_template() || $this->editing_visual_builder() ) {
			return false;
		}
		return $this->current_module == 'et_pb_wc_checkout_shipping';
	}

	public function editing_divi_template() {
    	return is_admin() && isset($_GET['page']) && $_GET['page'] === 'et_theme_builder';
	}

	public function editing_visual_builder(){
		return is_admin() && isset($_GET['et_fb']) && $_GET['et_fb'] == 1;
	}
	
}
new WC_Divi_Fix_Additional_Fields();
endif;