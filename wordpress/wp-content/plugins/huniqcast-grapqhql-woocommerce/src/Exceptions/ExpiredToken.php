<?php

namespace Huniqcast\WPGraphQL\Exceptions;

/**
 * Description of ExpiredToken
 *
 * @author User
 */
class ExpiredToken extends \Exception implements GraphQL\Error\ClientAware {
    
    //put your code here
    public function getCategory(): string {
        return "JWT";
    }

    public function isClientSafe(): bool {
        return true;
    }

}
