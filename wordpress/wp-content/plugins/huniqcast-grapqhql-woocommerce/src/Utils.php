<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Huniqcast\WPGraphQL;

/**
 * Description of Utils
 *
 * @author User
 */
class Utils {

    public static function dd($var, $exit = false) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        if ($exit) {
            die(1);
        }
    }

    public static function x_log($content) {
        file_put_contents(HQC_WPGRAPHQL_PLUGING_DIR . DIRECTORY_SEPARATOR . 'logs/log.txt', '[' . date('d-m-Y') . ']' . (is_array($content) || is_object($content) ? print_r((array)$content, true) : $content) . PHP_EOL, FILE_APPEND);
    }
    
    public static function x_log_graphql(\GraphQL\Executor\ExecutionResult $response){
        if($response !== null ){
            static::x_log([ 'GraphQL_error' => $response->errors[0]->message ]);
        }else{
            static::x_log('the response is not a execution result from graphql executor');
        }
    }

    public static function x_var_dump($mixed = null) {
        ob_start();
        var_dump($mixed);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
    public static function user_exists($userID){
        
        $user = get_user_by("ID", $userID);
        
        if ( $user ) {
            $user_id = $user->ID;
        } else {
            $user_id = false;
        }
        
        return $user_id;
    }
    
    public static function wc_product_exists($productID){
        $product_post = \get_post($productID);
        if (!$product_post) {
            return false;
        }
        
        if ($product_post->post_type == 'product_variation') {
            $_product = new \WC_Product_Variation($productID);
        } else {
            $_product = new \WC_Product($productID);
        }
        
        return $_product->exists();
    }

}
