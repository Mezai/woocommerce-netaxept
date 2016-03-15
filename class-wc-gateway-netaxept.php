<?php
/*
 * Plugin Name: Netaxept for WooCommerce
 * Plugin URI: http://www.sitepoint.com/
 * Description: Use Netaxept for collecting credit card payments on WooCommerce.
 * Version: 1.0.0
 * Author: Johan Tedenmark
 * Author URI: http://www.sitepoint.com/
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Proudly built by: Johan Tedenmark // https://github.com/Mezai
 */

add_action('plugins_loaded', 'woocommerce_gateway_netaxept_init', 0);

function woocommerce_gateway_netaxept_init()
{
    if (!class_exists('WC_Payment_Gateway')) {
        return;
    }



    class WC_Gateway_Netaxept extends WC_Payment_Gateway
    {
        public function __construct()
        {
            $this->id = "netaxept";
            $this->has_fields = false;
            $this->method_title = __("Netaxept", "netaxept");
            $this->order_button_text = __("Proceed to Netaxept", "netaxept");
            $this->method_description = __("Netaxept payment gateway extension", "netaxept");
            $this->icon = null;
            $this->init_form_fields();
            $this->init_settings();
        }

        public function init_form_fields()
        {
            $this->form_fields = array(
              'enabled' => array(
                'title' => __('Enable / Disable', 'netaxept'),
                'label' => __('Enable this payment gateway', 'netaxept'),
                'type' => 'checkbox',
                'default' => 'no'
              ),
              'title' => array(
                'title' => __('Title', 'netaxept'),
                'type' => 'text',
                'desc_tip' => __('Payment title the customer will see during checkout process.', 'netaxept'),
                'default' => __('Pay with Netaxept', 'netaxept')
              ),
              'description' => array(
                'title' => __('Description', 'netaxept'),
                'type' => 'textarea',
                'desc_tip' => __('Payment description the customer will see during the checkout process.', 'netaxept'),
                'css' => 'max-width:350px;'
              ),
              'merchant_id' => array(
                'title' => __('Merchant Id', 'netaxept'),
                'type' => 'text',
                'desc_tip' => __('Merchant Id', 'netaxept'),
              ),
              'service_token' => array(
                'title' => __('Service token', 'netaxept'),
                'type' => 'text',
                'desc_tip' => __('Fill in your api key', 'netaxept'),
              ),
              'testmode' => array(
                'title' => __('Test mode', 'netaxept'),
                'type' => 'checkbox',
                'label' => __('Enable Netaxept test mode', 'netaxept'),
                'default' => 'no',
                'description' => sprintf(__('Netaxept test mode can be used to test payments. You will need a test account and you can find the test cardshere <a href="%s">here</a>.', 'netaxept'), 'http://betalingsterminal.no/Netthandel-forside/Teknisk-veiledning/Test-cards/'),
              ),
              'force3d' => array(
                'title' => __('Force 3D secure', 'netaxept'),
                'type' => 'checkbox',
                'default' => 'no',
                'description' => __('Forces the customer to do 3D secure verification', 'netaxept'),
                'label' => __('Enable', 'netaxept'),
              ),
              'paymentmode' => array(
                'title' => __('Payment mode', 'netaxept'),
                'type' => 'select',
                'class' => 'wc-enhanced-select',
                'description' => __('Choose if you wish to make a reservation first or make a direct withdrawal', 'netaxept'),
                'default' => 'sale',
                'desc_tip' => true,
                'options' => array(
                  'sale' => __('Sale', 'netaxept'),
                  'auth' => __('Auth', 'netaxept')
                )
              ),
              'singlepage' => array(
                'title' => __('Single page', 'netaxept'),
                'type' => 'checkbox',
                'label' => __('Enabled', 'netaxept'),
                'description' => __('Shows a singlepage mode in Netaxept terminal', 'netaxept'),
                'desc_tip' => true

              )

            );
        }

    //proces the payment

      public function process_payment($order_id)
      {
          require_once('lib/netaxept-request.php');


        //order id
        $order = wc_get_order($order_id);
      }
    }

    function woocommerce_add_gateway_netaxept($methods)
    {
        $methods[] = 'WC_Gateway_Netaxept';
        return $methods;
    }

    add_filter('woocommerce_payment_gateways', 'woocommerce_add_gateway_netaxept');
}
