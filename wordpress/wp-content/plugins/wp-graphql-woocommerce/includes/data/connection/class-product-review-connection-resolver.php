<?php
/**
 * Resolves connections to product reviews
 *
 * @package WPGraphQL\WooCommerce\Data\Connection
 * @since 0.3.2
 */

namespace WPGraphQL\WooCommerce\Data\Connection;

use GraphQL\Type\Definition\ResolveInfo;
use WPGraphQL\AppContext;
use WPGraphQL\WooCommerce\Model\Product;

/**
 * Class Product_Review_Connection_Resolver
 */
class Product_Review_Connection_Resolver {
	/**
	 * This prepares the $query_args for use in the connection query. This is where default $args are set, where dynamic
	 * $args from the $this->source get set, and where mapping the input $args to the actual $query_args occurs.
	 *
	 * @param array       $query_args - WP_Query args.
	 * @param mixed       $source     - Connection parent resolver.
	 * @param array       $args       - Connection arguments.
	 * @param AppContext  $context    - AppContext object.
	 * @param ResolveInfo $info       - ResolveInfo object.
	 *
	 * @return mixed
	 */
	public static function get_query_args( $query_args = array(), $source, $args, $context, $info ) {
		/**
		 * Determine where we're at in the Graph and adjust the query context appropriately.
		 */
		if ( is_a( $source, Product::class ) ) {
			// @codingStandardsIgnoreLine
			if ( 'reviews' === $info->fieldName ) {
				$query_args['post_type'] = 'product';
				$query_args['post_id']   = $source->ID;
			}
		}

		$query_args = apply_filters(
			'graphql_product_review_connection_query_args',
			$query_args,
			$source,
			$args,
			$context,
			$info
		);

		return $query_args;
	}
}
