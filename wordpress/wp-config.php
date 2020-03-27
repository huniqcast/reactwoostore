<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'reactwoostore' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'L+9O}L{-Mb$caB_Sy>*Gbk5zM#W@rnhq{:p9BhzN3.-sjAWDQGOmhaREDXnRjD+n' );
define( 'SECURE_AUTH_KEY',  'K&9cxxP(EG^}45]P>=+LNIu}yf3:bO 0Far6=>&{^>u<KLG8TZ;QO?|-}Qr1%x#g' );
define( 'LOGGED_IN_KEY',    ';8mIh0KQ/+ErDE{k:#;z?JB^i/t+9XuAtGyb<%h_pS>q![(|.cu8|P,1awZ;@tM_' );
define( 'NONCE_KEY',        'FrK#M3?9kmhE53e.X<P@IegdP!twpYI^9Bt#CFq.Ta49t> YN2|4lVP}(JMFg_g$' );
define( 'AUTH_SALT',        's#1+z7DwCI}kt07DwmsBH~8^_^[+RcPX)@(/WL_Q-.8R.S~32srVe~2NxI_Y8tU&' );
define( 'SECURE_AUTH_SALT', '}/yjD<Cb:! S}6S2:lsFN}{TyxSO_x<wp%GM{L:2hQv|{9S}a78DBKU7e$dcTE>)' );
define( 'LOGGED_IN_SALT',   '!|oqEQ^a54<z@{D5c8@ITCg i?8=DJ6gtlND iHC94tqJA6v`#Y44d{|$0rYKN[k' );
define( 'NONCE_SALT',       'O7[`sZD):x&=(5a f,7lB]CVR&,F4)=Hzsr,Wz]Af6p;XpC56ty./u_O^1Zs<D!v' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
