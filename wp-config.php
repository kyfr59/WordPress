<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'wordpress');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'qwerty');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+mE%W$#P=7Ya<LUXOD-s&?Mx^sYe^(L#0f-b/+xV8{;pX0x19ud>bXsBX62Wt&/8');
define('SECURE_AUTH_KEY',  '?F:>%4-DAlT4[<~,0crCqEwLZd+T#^yskZPmlG3^]r}+E~#pHa<(]XE|#lDo%PJ=');
define('LOGGED_IN_KEY',    '.#>_Ae!|bQlIGk}k|0t%|&m!.Zf-Y1SiD$nL${-vvO(K45~)P*hat+R@Y={`QpDB');
define('NONCE_KEY',        'nu&G[6Sgc>~u~4tvqC><r?.NBH`?4zC&[s}M6nGsA/ZA|bjp^0gDc=n[kPm.)D2M');
define('AUTH_SALT',        'SR+j|/]0~~Da/+KlU5a#iG;#;BgF gsA[e6Jogbc0`9e2B1X;S:m=FOw2.:X!/w<');
define('SECURE_AUTH_SALT', 'wd&;mujf:?&kre:W!e8itLd-%/9]$I?t1,/SUznE-Qh=^:Jq0xc_;/pZ.X-zyrr9');
define('LOGGED_IN_SALT',   'D+Frc&xI1!6]c9X>uIMx1;.?0i>omJJO-`cdek(.=q*y$Jj*^-xbG-]@=>]BAZo-');
define('NONCE_SALT',       'lbg<s[!WpAn/HrUcP=NC-0TiTmo&u{T8P9#|h`f=7r#MY<^5ec:Aap,GxU {J6|x');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', false); 

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');