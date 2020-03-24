<?php
/**
 * Connection type - ProductAttributes
 *
 * Registers connections to ProductAttribute
 *
 * @package WPGraphQL\WooCommerce\Connection
 * @since 0.0.1
 */

namespace WPGraphQL\WooCommerce\Connection;

use WPGraphQL\WooCommerce\Data\Factory;

/**
 * Class Product_Attributes
 */
class Product_Attributes {
	/**
	 * Registers the various connections from other Types to ProductAttribute
	 */
	public static function register_connections() {
		// From Product to ProductAttribute.
		register_graphql_connection( self::get_connection_config() );

		// From Product to LocalProductAttribute.
		register_graphql_connection(
			self::get_connection_config(
				array(
					'toType'        => 'LocalProductAttribute',
					'fromFieldName' => 'localAttributes',
				)
			)
		);

		// From Product to GlobalProductAttribute.
		register_graphql_connection(
			self::get_connection_config(
				array(
					'toType'        => 'GlobalProductAttribute',
					'fromFieldName' => 'globalAttributes',
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
			'fromType'       => 'Product',
			'toType'         => 'ProductAttribute',
			'fromFieldName'  => 'attributes',
			'connectionArgs' => self::get_connection_args(),
			'resolve'        => function ( $root, $args, $context, $info ) {
				return Factory::resolve_product_attribute_connection( $root, $args, $context, $info );
			},
		);

		return array_merge( $defaults, $args );
	}

	/**
	 * Returns array of where args
	 *
	 * @return array
	 */
	public static function get_connection_args() {
		return array(
			'type' => array(
				'type'        => 'ProductAttributeTypesEnum',
				'description' => __( 'Filter results by attribute scope.', 'wp-graphql-woocommerce' ),
			),
		);
	}
}
