<?php


/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
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
define( 'DB_NAME', "alphawaytech" );

/** MySQL database username */
define( 'DB_USER', "root" );

/** MySQL database password */
define( 'DB_PASSWORD', "Awt@2021");

/** MySQL hostname */
define( 'DB_HOST', "localhost" );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'F+,WJv0^PH|TFs2-imWur7)T]r_9 GT5k)0E|:70V?*>NPUxD7{y|IDk$D.uG5-]' );
define( 'SECURE_AUTH_KEY',  'M(}Hpyxu7ytY`Yx6xh*Ye3`A+E$Y:9L,^`8WJD[Y uhr2KM.^]BMd4tIk0rC[tI@' );
define( 'LOGGED_IN_KEY',    'S%R4Er9Wy69FF|n>r-p2g.s@$p<C{7;[v7U@-P`}2pC3%,##n&Yq48tqZ=V#l_$(' );
define( 'NONCE_KEY',        'In~v)6v{Mtsq5GVo5TXtwe!y-k/KBw{$y[7qrKm-4()sHw2(@?L=Lmv&xo! y) H' );
define( 'AUTH_SALT',        'UuPcxpLq$t.f/3[pd4q&?ppO!q]ruj=^3Q)TnqfIdIhub}lSejDZ]T9T^PhOf;UH' );
define( 'SECURE_AUTH_SALT', 'RTz$f~bW!H-q>x{p)1L1aqQiR^72aCVsN L[Qzo~UO&{iEfB2|)1H@)jp.q(O%hm' );
define( 'LOGGED_IN_SALT',   'f%97.qHsxLPSsvgQ[Z5pnlhakzNhkCc^`S`.&0$5m~Uu%7u*Ag1;N{fk49[ma$L~' );
define( 'NONCE_SALT',       '4-Wbv:h%w.A-EW9:AJe*Btp%e2(x2xJDf]^U{<:{nOLbcy2U]zd-qNQz$4gO#53<' );

/**#@-*/

/**
 * WordPress database table prefix.
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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define( 'ALLOW_UNFILTERED_UPLOADS', true );

define( 'WP_MEMORY_LIMIT', '256M' );

define( 'WP_POST_REVISIONS', 3 );

define( 'WP_SITEURL', 'https://alphawaytech.cani.digital/' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
