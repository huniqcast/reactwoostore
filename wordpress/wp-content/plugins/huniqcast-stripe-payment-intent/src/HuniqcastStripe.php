<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Huniqcast\Stripe;

use Stripe\Stripe;
use Stripe\PaymentIntent;

/**
 * Description of HuniqcastStripe
 *
 * @author User
 */
class HuniqcastStripe {

    /**
     * HuniqcastStripe version.
     *
     * @var string
     */
    public $version = '0.0.1';

    /**
     * The single instance of the class.
     *
     * @var HuniqcastStripe
     * @since 2.1
     */
    protected static $_instance = null;
    
    
    protected static $zero_decimal_currencies = [
      'mga', 
      'bif',
      'clp',  
      'pyg', 
      'djf',
      'rwf', 
      'gnf', 
      'ugx', 
      'vnd',
      'jpy', 
      'vuv', 
      'xaf', 
      'kmf',
      'xof', 
      'krw', 
      'xpf'   
    ];

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Cloning is forbidden.
     *
     * @since 2.1
     */
    public function __clone() {
        wc_doing_it_wrong(__FUNCTION__, __('Cloning is forbidden.', 'huniqcast-stripe'), '0.0.1');
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 2.1
     */
    public function __wakeup() {
        wc_doing_it_wrong(__FUNCTION__, __('Unserializing instances of this class is forbidden.', 'huniqcast-stripe'), '0.0.1');
    }

    /**
     * WooCommerce Constructor.
     */
    private function __construct() {
        $this->init_hooks();
    }

    /**
     * Hook into actions and filters.
     *
     * @since 2.3
     */
    private function init_hooks() {
        add_action('rest_api_init', array($this, 'rest_api_init'));
    }

    public function rest_api_init() {
        register_rest_route('huniqcast-stripe/v1', '/payment-intent', [
            'methods' => 'POST',
            'callback' => array($this, 'payment_intent')
        ]);
    }
    
    private function centimeOrUnit($currency){
        return is_array(strtolower($currency), self::$zero_decimal_currencies) ? 1 : 100;
    }

    public function payment_intent(\WP_REST_Request $request) {
        
        //Read params
        $amount = $request->get_param('amount');
        
        $currency = get_woocommerce_currency();
        $currency_symbol_html = html_entity_decode(get_woocommerce_currency_symbol());
        $amountWithoutCurrency = str_replace($currency_symbol_html, '', $amount);
        
        $paymentMethodId = $request->get_param('paymentMethodId');
        
        if(is_null($amount) || is_null($paymentMethodId)) return new \WP_REST_Response (array('error' => 'Please provide the amount and the payment method ID.'), 500);

        //Setup stripe payment intent.
        Stripe::setApiKey('sk_test_Msu6oek3IKtMUfnXAEe7EBPT00W5A9Hj5d');


        try{
            
            //automatic confirmation
            $intent = PaymentIntent::create([
                        'amount' => ((float)$amountWithoutCurrency) * $this->centimeOrUnit($currency),
                        'currency' => $currency,
                        'payment_method' => $paymentMethodId,
                        'confirmation_method' => 'automatic',
                        'confirm' => true,
                        'off_session' => false
            ]);
            
            return $this->generateResponse($intent);
            
        } catch (Stripe\Exception\ApiErrorException $ex) {
            return new \WP_REST_Response(['error' => $ex->getMessage()], 500); 
        } catch(\Exception $ex){
            return new \WP_REST_Response(['error' => $ex->getMessage()], 500);
        }
        
    }
    
    private function generateResponse(PaymentIntent $intent){
        $responseData = [];
        if($intent->status === 'requires_action'){
            $responseData['requires_action'] = true;
            $responseData['payment_intent_client_secret'] = $intent->client_secret;
        }else if($intent->status === 'succeeded'){
            $responseData['payment_completed'] = true;
            $responseData['txn_id'] = isset($intent->charges->data[0]) ? $intent->charges->data[0]->id : null;
        }else{
            return new \WP_REST_Response(['error' => 'Invalid paymentIntent status'], 500);
        }
        
        return new \WP_REST_Response($responseData, 201);
    }

}
