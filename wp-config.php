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
define( 'DB_NAME', 'xprdb' );

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

define('WP_POST_REVISIONS', false );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'YJs6eOi!aGf|Jn-/7h{TgJ+LQ3(J2%M*o69De^0na.9qlu*3Pi?W$3RaUga0:[0e' );
define( 'SECURE_AUTH_KEY',  'XdoZ2YMsE0*MG$rNCAw;g=_{@6gmhbYC`?.jEX]$m3[:^HZ0r~`+Gj#<JdR9~$kz' );
define( 'LOGGED_IN_KEY',    '8/ WfT!uLCBv+G!Y(K@<7YD6[z:iZ</9-IfJ/I}FR[^`:W7;m42d~,>Jj,B-r%<?' );
define( 'NONCE_KEY',        'oTQz1 u{2PlU!y?x.c7`mj.,w10J!Ax,GL+auc|V?2A>Cq!K Q&Ct4r/Ku#NE@Ay' );
define( 'AUTH_SALT',        ')1qIFZ.ooe9m7vhV4bP7-?Qq/jNJIG)9wOS~:b^->?<Uz#qsff@T%;Y|^*-`9LbB' );
define( 'SECURE_AUTH_SALT', '^~!1|x2Q:1tq_k;CNWxAqYC(n0--C]2g&k71W& IV5.&.k*U+*g,t@]-Ger63(KX' );
define( 'LOGGED_IN_SALT',   '._71==F^G(nZ5t-1`//  E0:/str!ZxE5l>`F(-P&,pam?6Q9)ekwN1}(@6_=q,B' );
define( 'NONCE_SALT',       ';cJFxS2Ws69SH>sg$$Gc`p,?nyRF?<YW->rRlsahXIG[U?ZAf7I^<I_cLJOpC][W' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'xpr_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
