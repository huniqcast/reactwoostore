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
define( 'DB_NAME', 'rn-ecommerce' );

/** MySQL database username */
define( 'DB_USER', 'rn-ecommerce-user' );

/** MySQL database password */
define( 'DB_PASSWORD', 'mutrekiphlVo*u_as2qu' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',         'QStmGOLW7-|qlf&:GP-tZohKV;c@kTR5.%WOn}=qdB_t:_>IrRt$^O$IG~_GK_l;');
define('SECURE_AUTH_KEY',  ';)Tbw<5esN?-|!}iV;|U{ZW!^U-}`|=&IkSH[osnm!f+>DN#<v2CLI5!m_wTx:t&');
define('LOGGED_IN_KEY',    '-OHQd8Y f<9DbMDU/qNCcoMKZ*Gt9ea&?+Swbppat>NvLTyg=>:6b)&;Td)qr3+{');
define('NONCE_KEY',        'HfPldrH1!Z+h+yT9=*[dbM*aY@.r@k94[b^w_YW5Ub#+i(+q*gQFy(^:>3nV|qV?');
define('AUTH_SALT',        '@AXJ:ei|{ n}Xyol8IVG_m4?=1%2Jz|l9%$D%rq38|BbkK-4W/=mvaT8/n6Y{T-{');
define('SECURE_AUTH_SALT', '`gf/X0(8]W^/::O{OV%/oGVfW&d/)3sC*srxF,n1p4DKbT~< OSQ[AaUx9x?T5II');
define('LOGGED_IN_SALT',   'XuvCLNO}dC2g?-|9NW%DuHpx_=cLIhhPOC&CCbxg43Vwv%FEOCGbsB!~97[xa;iD');
define('NONCE_SALT',       '6r4WY>U=QKXYh;|3iqX-0G-pcQBU:CU=czadYMlOTiQ$RX;| 3m_yY-A=4wW.HJf');

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
