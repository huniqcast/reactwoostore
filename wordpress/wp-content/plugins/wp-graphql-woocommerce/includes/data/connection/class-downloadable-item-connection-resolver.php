<?php
/**
 * ConnectionResolver - Downloadable_Item_Connection_Resolver
 *
 * Resolves connections to DownloadableItem
 *
 * @package WPGraphQL\WooCommerce\Data\Connection
 * @since 0.4.0
 */

namespace WPGraphQL\WooCommerce\Data\Connection;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQLRelay\Relay;
use GraphQLRelay\Connection\ArrayConnection;
use WPGraphQL\AppContext;
use WPGraphQL\Data\Connection\AbstractConnectionResolver;

/**
 * Class Downloadable_Item_Connection_Resolver
 */
class Downloadable_Item_Connection_Resolver extends AbstractConnectionResolver {
	/**
	 * Include shared connection functions.
	 */
	use WC_Connection_Functions;

	/**
	 * Confirms if downloadable items should be retrieved.
	 *
	 * @return bool
	 */
	public function should_execute() {
		return true;
	}

	/**
	 * Creates downloadable item filters.
	 *
	 * @return array
	 */
	public function get_query_args() {
		$query_args = array( 'filters' => array() );
		if ( ! empty( $this->args['where'] ) ) {
			$where_args = $this->args['where'];
			if ( isset( $where_args['active'] ) ) {
				$active = $where_args['active'];

				$query_args['filters'][] = function( $downloadable_item ) use ( $active ) {
					$is_expired          = isset( $downloadable_item['access_expires'] )
						? time() > $downloadable_item['access_expires']->getTimestamp()
						: false;
					$downloads_remaining = ( 'integer' === gettype( $downloadable_item['downloads_remaining'] ) )
						? 0 < $downloadable_item['downloads_remaining']
						: true;

					return $active ? ( ! $is_expired && $downloads_remaining ) : ( $is_expired || ! $downloads_remaining );
				};
			}

			if ( isset( $where_args['expired'] ) ) {
				$expired = $where_args['expired'];

				$query_args['filters'][] = function( $downloadable_item ) use ( $expired ) {
					$is_expired = isset( $downloadable_item['access_expires'] )
						? time() < $downloadable_item['access_expires']->getTimestamp()
						: false;

					return $expired === $is_expired;
				};
			}

			if ( isset( $where_args['hasDownloadsRemaining'] ) ) {
				$has_downloads_remaining = $where_args['hasDownloadsRemaining'];

				$query_args['filters'][] = function( $downloadable_item ) use ( $has_downloads_remaining ) {
					$downloads_remaining = ( 'integer' === gettype( $downloadable_item['downloads_remaining'] ) )
						? 0 < $downloadable_item['downloads_remaining']
						: true;

					return $has_downloads_remaining === $downloads_remaining;
				};
			}
		}

		/**
		 * Filter the $query_args to allow folks to customize queries programmatically.
		 *
		 * @param array       $query_args The args that will be passed to the WP_Query.
		 * @param mixed       $source     The source that's passed down the GraphQL queries.
		 * @param array       $args       The inputArgs on the field.
		 * @param AppContext  $context    The AppContext passed down the GraphQL tree.
		 * @param ResolveInfo $info       The ResolveInfo passed down the GraphQL tree.
		 */
		$query_args = apply_filters( 'graphql_downloadable_item_connection_query_args', $query_args, $this->source, $this->args, $this->context, $this->info );

		return $query_args;
	}

	/**
	 * Executes query
	 *
	 * @return \WP_Query
	 */
	public function get_query() {
		$items = $this->source->downloadable_items;

		if ( empty( $items ) ) {
			return array();
		}

		if ( ! empty( $this->query_args['filters'] ) && is_array( $this->query_args['filters'] ) ) {
			foreach ( $this->query_args['filters'] as $filter ) {
				$items = array_filter( $items, $filter );
			}
		}

		$cursor_key    = $this->get_offset();
		$cursor_offset = array_search( $cursor_key, \array_column( $items, 'download_id' ), true );

		if ( ! empty( $this->args['after'] ) ) {
			$items = array_splice( $items, $cursor_offset + 1 );
		} elseif ( $cursor_offset ) {
			$items = array_splice( $items, 0, $cursor_offset );
		}

		return $items;
	}

	/**
	 * This returns the offset to be used in the $query_args based on the $args passed to the
	 * GraphQL query.
	 *
	 * @return int|mixed
	 */
	public function get_offset() {
		$offset = null;

		// Get the offset.
		if ( ! empty( $this->args['after'] ) ) {
			$offset = $this->args['after'];
		} elseif ( ! empty( $this->args['before'] ) ) {
			$offset = $this->args['before'];
		}

		/**
		 * Return the higher of the two values
		 */
		return $offset;
	}

	/**
	 * Create cursor for downloadable item node.
	 *
	 * @param array  $node  Cart item.
	 * @param string $key   Cart item key.
	 *
	 * @return string
	 */
	protected function get_cursor_for_node( $node, $key = null ) {
		return $node['download_id'];
	}

	/**
	 * Return an array of items from the query
	 *
	 * @return array
	 */
	public function get_items() {
		return ! empty( $this->query ) ? $this->query : array();
	}

	/**
	 * Validates offset.
	 *
	 * @param integer $offset Post ID.
	 *
	 * @return bool
	 */
	public function is_valid_offset( $offset ) {
		return 'string' === gettype( $offset );
	}
}
