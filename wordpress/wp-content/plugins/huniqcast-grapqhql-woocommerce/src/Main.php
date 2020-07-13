<?php

namespace Huniqcast\WPGraphQL;

//use Huniqcast\WPGraphQL\Exceptions\ExpiredToken;

/**
 * Description of Main
 *
 * @author User
 */
class Main {

    use Traits\Singleton;

    public function i18n() {
        load_plugin_textdomain('huniqcast-graphql');
    }

    public function initialization() {
        $this->i18n();
        $this->graphql_register_types();
    }

    public function graphql_register_types() {
        add_action('graphql_register_types', [TypeRegister::class, "extending_wpgraphql_woocommerce"]);
        add_filter("graphql_comment_insert_post_args", [Hooks\CommentMutation::class, "setup_post_for_wc_rating"], 10, 2);
    }

}
