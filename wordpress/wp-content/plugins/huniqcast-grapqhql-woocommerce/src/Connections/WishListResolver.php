<?php

namespace Huniqcast\WPGraphQL\Connections;

use WPGraphQL\Data\Connection\AbstractConnectionResolver;
use WPGraphQL\WooCommerce\Data\Connection\WC_Connection_Functions; 

/**
 * Description of WishListResolver
 *
 * @author User
 */
class WishListResolver extends AbstractConnectionResolver {
   
    use WC_Connection_Functions;
    
    public function get_items(): array {
        if(is_a($this->source, \WPGraphQL\WooCommerce\Model\Customer::class)){
            $userID = $this->source->ID;
            $wishlist =  \Alg_WC_Wish_List::get_wish_list($userID, false);
            return $wishlist;
        }
        return [];
    }

    public function get_query() {
        
    }

    public function get_query_args(): array {
        return [];
    }

    public function is_valid_offset($offset): bool {
        return $this->is_valid_post_offset($offset);
    }

    public function should_execute(): bool {
        return true;
    }

}
