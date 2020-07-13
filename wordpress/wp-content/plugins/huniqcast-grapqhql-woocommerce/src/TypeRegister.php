<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Huniqcast\WPGraphQL;

use WPGraphQL\WooCommerce\Model\Customer;
use WPGraphQL\WooCommerce\Data\Factory;
use WPGraphQL\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use Huniqcast\WPGraphQL\Connections\WishListResolver;
use GraphQL\Error\UserError;

/**
 * Description of TypeRegister
 *
 * @author User
 */
class TypeRegister {

    public static function extending_wpgraphql_woocommerce() {
        register_graphql_field("createCommentInput", "rating", [
            'type' => "Integer",
            "description" => __("Rating input from review on a product.", "huniqcast-graphql"),
            "resolve" => function() {
                return null;
            }
        ]);

        register_graphql_field("Customer", "avatar", [
            'type' => 'Avatar',
            'description' => __('Avatar object for user. The avatar object can be retrieved in different sizes by specifying the size argument.', 'wp-graphql'),
            'args' => [
                'size' => [
                    'type' => 'Int',
                    'description' => __('The size attribute of the avatar field can be used to fetch avatars of different sizes. The value corresponds to the dimension in pixels to fetch. The default is 96 pixels.', 'wp-graphql'),
                    'defaultValue' => 96,
                ],
                'forceDefault' => [
                    'type' => 'Boolean',
                    'description' => __('Whether to always show the default image, never the Gravatar. Default false'),
                ],
                'rating' => [
                    'type' => 'AvatarRatingEnum',
                ],
            ],
            'resolve' => function( $user, $args, $context, $info ) {

                $avatar_args = [];
                if (is_numeric($args['size'])) {
                    $avatar_args['size'] = \absint($args['size']);
                    if (!$avatar_args['size']) {
                        $avatar_args['size'] = 96;
                    }
                }

                if (!empty($args['forceDefault']) && true === $args['forceDefault']) {
                    $avatar_args['force_default'] = true;
                }

                if (!empty($args['rating'])) {
                    $avatar_args['rating'] = \esc_sql($args['rating']);
                }

                $avatar = \WPGraphQL\Data\DataSource::resolve_avatar($user->customerId, $avatar_args);

                return (!empty($avatar) && true === $avatar->foundAvatar ) ? $avatar : null;
            },
        ]);

        register_graphql_connection([
            "fromType" => "customer",
            "toType" => "Product",
            "fromFieldName" => "wishList",
            "connectionTypeName" => "UserWishListProductConnection",
            "resolve" => function(Customer $source, array $args, AppContext $context, ResolveInfo $info) {
                $wishListResover = new WishListResolver($source, $args, $context, $info);
                return $wishListResover->get_connection();
            },
            "resolveNode" => function($id, $args, $context, $info) {
                return Factory::resolve_crud_object($id, $context);
            }
        ]);

        register_graphql_mutation('addToWishList', [
            'inputFields' => static::get_wishList_input(),
            'outputFields' => static::get_wishList_output(),
            'mutateAndGetPayload' => static::mutate_customer_wishlist(true)
        ]);

        register_graphql_mutation('removeFromWishList', [
            'inputFields' => static::get_wishList_input(),
            'outputFields' => static::get_wishList_output(),
            'mutateAndGetPayload' => static::mutate_customer_wishlist(false)
        ]);
    }

    public static function get_wishList_input() {
        return [
            "productId" => [
                'type' => array('non_null' => 'Int'),
                'description' => __('product database ID', 'huniqcast-graphql'),
            ],
            'userID' => [
                'type' => 'ID',
                'description' => __('The ID of the user', 'huniqcast-graphql'),
            ]
        ];
    }

    public static function get_wishList_output() {
        return [
            "item_ids" => [
                'type' => ["list_of" => "Int"],
                'description' => __('list of database produc ID inside wishlist for the current user.', 'huniqcast-graphql'),
                'resolve' => function( $payload ) {
                    return $payload["wishlist"];
                },
            ]
        ];
    }

    public static function mutate_customer_wishlist($addProduct = false) {
        return function( $input, AppContext $context, ResolveInfo $info ) use ($addProduct) {

            extract($input);

            $productId = (int) $productId;
            $userID = (int) $userID;

            //Validating input...
            if (empty($productId) || !is_int($productId) || !Utils::wc_product_exists($productId)) {
                throw new UserError(__('ValidationError - Invalid product Id provided', 'huniqcast-graphql'));
            }

            if (empty($userID) || !is_int($userID)) {
                throw new UserError(__('ValidationError - Invalid customer ID provided ' . $userID, 'huniqcast-graphql'));
            }

            if (Utils::user_exists($userID) === false) {
                throw new UserError(__('ValidationError - This customer does not exist', 'huniqcast-graphql'));
            }

            $opResponse = false;

            if ($addProduct) {
                $response = \Alg_WC_Wish_List_Item::add_item_to_wish_list($productId, $userID);
                $opResponse = $response !== false;
            } else {
                $opResponse = \Alg_WC_Wish_List_Item::remove_item_from_wish_list($productId, $userID);
            }

            if ($opResponse) {
                return ["wishlist" => \Alg_WC_Wish_List::get_wish_list($userID)];
            } else {
                throw new UserError(__('OpError - An error occured during query execution.', 'huniqcast-graphql'));
            }
        };
    }

}
