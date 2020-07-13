<?php

namespace Huniqcast\WPGraphQL\Hooks;

/**
 * Description of CommentMutation
 *
 * @author User
 */
class CommentMutation {
    /**
     * 
     * @param type $output_args
     * @param type $input
     */
    public static function setup_post_for_wc_rating($output_args, $input){
        //The WC_Comment class required that some $_POST's key variables should be 
        //set for it to handle comment rating properly.
        $_POST['comment_post_ID'] = $output_args["comment_post_ID"];
        $_POST['rating'] = $input["rating"];
        return $output_args;
    }
}
