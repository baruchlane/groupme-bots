<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'reciteka_wo6906');

/** MySQL database username */
define('DB_USER', 'reciteka_wo6906');

/** MySQL database password */
define('DB_PASSWORD', 'KCAgAbwoSNw1');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'ppj!d(lRHoH|jxQM[FT_EE!JLVCV{P&xLv>IE@Cfe}h=A/(NTtZL;JsX(c=rsvrEkffLhS-Kp{Vradj(Br$axTzp$/BywM[s&SvbU[WPCV%%oWBHHoQ%sZ>hJYyBh]@c');
define('SECURE_AUTH_KEY', 't>E%y=kc[J}I@|V[|fzVE_j)A;PtG|+|[@?y}VAnAqTme=xzVD*K{mc;HmwcCN$j%mggFvK%dwG<o$ts>bK)^dIES](+zz[bV[=wa{>W$BS?sO$pr%?mZ/sCboR@LTLa');
define('LOGGED_IN_KEY', 'XK!x)d*<i|owdPlIuZ^+b^CMSmp{$roTXf$W++aSQ}&!(;qXjW(&U?n|;cq!N&p_te_+waxpVC?Y>+RB%GVJu?;>vKuu&KqXv&G=H_)bEIfv/$YSi*|$}lIE{h|>x)Xy');
define('NONCE_KEY', 'K/Bgde@*/IbxPfpp}z[bQz*|(iy!vZ(l(oR=KQmKRn<hd!>VW^aK{wQA=ISkK>(u%)pVUMm%&JVyzRPaxfk)U-diqhSboUDKjqyqixRMEMOp]}|PGOadN>S}i(B((dpz');
define('AUTH_SALT', 'ofdF_Mcd({WovD;>MQYcs-f-cqQlO=[sF{BUKx^^b|J_tG$x]N$Ru@s>}(kyo_u)MnEkuFx>c^N[/YwEwRF-FufILSoAlOarLYeiw_e+CXiLF}|*k>SreL$X>&&QvWOG');
define('SECURE_AUTH_SALT', '@O;pDV?SCyj[=tc-lguuQ?CV=X_W_iI;<!t[}XV;ZbFw>iRa(BP}!qCBJt<**D}Y*R%jl!qWwlJwIgHxSwg]qgOB&^(/yqGfP?&R[xfHN->vnHVyqXNr*uQbxKnYvSFH');
define('LOGGED_IN_SALT', 'reOc>/=ZQ<(GdiO$!aX-UiXQTndA@jm?ZM%Kiqazf%Pt(@fK%JZGJt/U)Y}*BhWVjsY]s)j)+jS?Ev_G+*dMPT)fHU/dCnwUA}*(j*>Phet)J$<RZA<_DJMzufpos[=C');
define('NONCE_SALT', 's;%=zst$$pVHaD-$vi<_o)t^gy*uoVqCw/Mjm=eM^a<rAnr+LV|BpuB>)OpsLytr?;Nz?F[biz]DC/HVn*lv)$_NhCpi{AGwu?J-dHRz>hYmY!]D*KVjk+?S/$^^dpIQ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_diqh_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/**
 * Include tweaks requested by hosting providers.  You can safely
 * remove either the file or comment out the lines below to get
 * to a vanilla state.
 */
if (file_exists(ABSPATH . 'hosting_provider_filters.php')) {
	include('hosting_provider_filters.php');
}
