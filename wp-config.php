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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wordpress' );

/** MySQL hostname */
define( 'DB_HOST', 'db:3306' );

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
define( 'AUTH_KEY',         'PchXXpY)LHH7$JuM<g/2E5eHQ8YPwp,SiCeG14(nA@{K{JP]FIup ||dDU_U~BUY' );
define( 'SECURE_AUTH_KEY',  '.Yic*`A;mtwQOi7xffQe1x:@$@<!xcg:H{XF8YBPdSbBA2A~oB.vb:bpA_cVTC%>' );
define( 'LOGGED_IN_KEY',    'wt4v]N<;f(Z3BbMw]WE4F2iPA;-W`_G5BY<mW*>KN+wP$iJAm~2b}77>|5Y`50*-' );
define( 'NONCE_KEY',        '`s-Z0)n{[-/I~SEw? )}:]B5]WSjHvfqm_gEgwo]k:vkU1]Bv<e!d$ /J26gf.&y' );
define( 'AUTH_SALT',        'Q2M>]vfVO*.[%A=PEh@2defD`Nc_Bf#@L>J( .$NRO8T69/F?7nL2aHsCt{H-6nU' );
define( 'SECURE_AUTH_SALT', '*1<!txN4hCU.@ nw,_D0D>@#5e>+1m=eT1 -F}lj}hya1#_WisA2<d:j4%FoR8IQ' );
define( 'LOGGED_IN_SALT',   'hOMqJBwUpPy$kcw `<[T4o0I>06ht5b]]T{&<u3+s~XlG_J5Id+c=Dz(!2mS.B>a' );
define( 'NONCE_SALT',       'Vpt9,b:-0glp^+%)Y}ll$?Rj;K)A}ww[W!mW8u{`Yt*0=ipW(qFJ`3gaxcl62Ht#' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
