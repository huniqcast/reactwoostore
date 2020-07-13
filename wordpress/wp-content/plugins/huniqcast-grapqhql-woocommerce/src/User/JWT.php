<?php

namespace Huniqcast\WPGraphQL\User;

/**
 * Description of JWT
 *
 * @author User
 */
class JWT {
    
    /**
     * This function should help to set user id from jwt token for graphql queries.
     * @param type $user_id
     * @return type
     */
    public static function determine_current_user( $user_id ){
        $current_user_id = $user_id;
        return $current_user_id;
    }
}
