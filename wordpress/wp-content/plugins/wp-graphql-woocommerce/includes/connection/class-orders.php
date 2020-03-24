<?php
/**
 * Connection - Orders
 *
 * Registers connections to Order
 *
 * @package WPGraphQL\WooCommerce\Connection
 */

namespace WPGraphQL\WooCommerce\Connection;

use WPGraphQL\WooCommerce\Data\Factory;

/**
 * Class - Orders
 */
class Orders {
	/**
	 * Registers the various connections from other Types to Customer
	 */
	public static function register_connections() {
		// From RootQuery.
		register_graphql_connection(
			self::get_connection_config(
				array( 'connectionArgs' => self::get_connection_args( 'private' ) )
			)
		);

		// From Customer.
		register_graphql_connection(
			self::get_connection_config(
				array(
					'fromType'      => 'Customer',
					'fromFieldName' => 'orders',
				)
			)
		);
	}

	/**
	 * Given an array of $args, this returns the connection config, merging the provided args
	 * with the defaults
	 *
	 * @access public
	 * @param array $args - Connection configuration.
	 *
	 * @return array
	 */
	public static function get_connection_config( $args = array() ) {
		$defaults = array(
			'fromType'       => 'RootQuery',
			'toType'         => 'Order',
			'fromFieldName'  => 'orders',
			'connectionArgs' => self::get_connection_args(),
			'resolveNode'    => function( $id, $args, $context, $info ) {
				return Factory::resolve_crud_object( $id, $context );
			},
			'resolve'        => function ( $source, $args, $context, $info ) {
				return Factory::resolve_order_connection( $source, $args, $context, $info );
			},
		);
		return array_merge( $defaults, $args );
	}

	/**
	 * Returns array of where args
	 *
	 * @param string $access  Connection argument access-level.
	 *
	 * @return array
	 */
	public static function get_connection_args( $access = 'public' ) {
		switch ( $access ) {
			case 'private':
				return array_merge(
					get_common_post_type_args(),
					array(
						'statuses'    => array(
							'type'        => array( 'list_of' => 'OrderStatusEnum' ),
							'description' => __( 'Limit result set to orders assigned a specific status.', 'wp-graphql-woocommerce' ),
						),
						'customerId'  => array(
							'type'        => 'Int',
							'description' => __( 'Limit result set to orders assigned a specific customer.', 'wp-graphql-woocommerce' ),
						),
						'customersIn' => array(
							'type'        => array( 'list_of' => 'Int' ),
							'description' => __( 'Limit result set to orders assigned a specific group of customers.', 'wp-graphql-woocommerce' ),
						),
						'productId'   => array(
							'type'        => 'Int',
							'description' => __( 'Limit result set to orders assigned a specific product.', 'wp-graphql-woocommerce' ),
						),
						'orderby'     => array(
							'type'        => array( 'list_of' => 'OrdersOrderbyInput' ),
							'description' => __( 'What paramater to use to order the objects by.', 'wp-graphql-woocommerce' ),
						),
					)
				);

			case 'public':
			default:
				return array(
					'statuses'  => array(
						'type'        => array( 'list_of' => 'OrderStatusEnum' ),
						'description' => __( 'Limit result set to orders assigned a specific status.', 'wp-graphql-woocommerce' ),
					),
					'productId' => array(
						'type'        => 'Int',
						'description' => __( 'Limit result set to orders assigned a specific product.', 'wp-graphql-woocommerce' ),
					),
					'orderby'   => array(
						'type'        => array( 'list_of' => 'OrdersOrderbyInput' ),
						'description' => __( 'What paramater to use to order the objects by.', 'wp-graphql-woocommerce' ),
					),
					'search'    => array(
						'type'        => 'String',
						'description' => __( 'Limit results to those matching a string.', 'wp-graphql-woocommerce' ),
					),
					'dateQuery' => array(
						'type'        => 'DateQueryInput',
						'description' => __( 'Filter the connection based on dates', 'wp-graphql-woocommerce' ),
					),
				);
		}
	}
}
