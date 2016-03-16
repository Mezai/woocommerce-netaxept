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

    require_once('lib/Netaxept.php');

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


            $this->merchant_id = $this->settings['merchant_id'];
            $this->service_token = $this->settings['service_token'];
            $this->testmode = $this->settings['testmode'];


            add_action('woocommerce_update_options_payment_gateways_' . $this->id , array($this, 'process_admin_options'));

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
                'default' => 'yes',
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
          global $woocommerce;
          $order = new WC_Order($order_id);

          /* Do register request and redirect user to the Terminal */

          $request = new Netaxept_Register();

          $parameters = array(
            'merchantId' => (String)$this->merchant_id,
            'token' => (String)$this->service_token,
            'amount' => $order->order_total * 100,
            'orderNumber' => (String)$order->get_order_number(),
            'CurrencyCode' => strtoupper(get_woocommerce_currency()),
            'redirectUrl' => 'http://localhost/test'
          );


          if ($this->testmode == 'yes') {
            Netaxept_Environment::setEnvironment(Netaxept_Environment::TEST);
          } else {
            Netaxept_Environment::setEnvironment(Netaxept_Environment::LIVE);
          }

          $transaction_id = $request->create($parameters);

          $redirect_uri = "https://test.epayment.nets.eu/Terminal/default.aspx?merchantId=12001114&transactionId=" . $transaction_id;

          return array(
            'result' => 'success',
            'redirect' => $redirect_uri
          );

      }
    }

    function woocommerce_add_gateway_netaxept($methods)
    {
        $methods[] = 'WC_Gateway_Netaxept';
        return $methods;
    }

    add_filter('woocommerce_payment_gateways', 'woocommerce_add_gateway_netaxept');
}