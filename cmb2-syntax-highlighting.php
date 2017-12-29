<?php
/**
 * Plugin Name:     CMB2 Syntax Highlighting
 * Plugin URI:      https://github.com/timothyjensen/cmb2-syntax-highlighting
 * Description:     Allows CSS syntax highlighting to be applied to the 'textarea_code' field.
 * Author:          Tim Jensen <tim@timjensen.us>
 * Author URI:      https://www.timjensen.us
 * Text Domain:     cmb2-syntax-highlighting
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         TimJensen\CMB2SyntaxHighlighting
 */

namespace TimJensen\CMB2SyntaxHighlighting;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'CMB2_SYNTAX_HIGHLIGHTING_CONFIG_DIR', __DIR__ . '/config' );
define( 'CMB2_SYNTAX_HIGHLIGHTING_VIEWS_DIR', __DIR__ . '/views' );

require_once __DIR__ . '/src/CMB2_Syntax_Highlighter.php';

$cmb2_syntax_highlighting = new CMB2_Syntax_Highlighter();
$cmb2_syntax_highlighting->init();