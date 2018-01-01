<?php
/**
 * Plugin Name:     CMB2 Syntax Highlighting
 * Plugin URI:      https://github.com/timothyjensen/cmb2-syntax-highlighting
 * Description:     Allows syntax highlighting to be applied to the 'textarea_code' field.
 * Author:          Tim Jensen <tim@timjensen.us>
 * Author URI:      https://www.timjensen.us
 * Text Domain:     cmb2-syntax-highlighting
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         TimJensen\CMB2SyntaxHighlighting
 */

namespace TimJensen\CMB2SyntaxHighlighting;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

require_once __DIR__ . '/src/CMB2_Syntax_Highlighter.php';

$cmb2_syntax_highlighting = new CMB2_Syntax_Highlighter();
$cmb2_syntax_highlighting->init();
