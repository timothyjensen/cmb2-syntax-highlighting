<?php
/**
 * Syntax_Highlighter_Test
 *
 * @package     TimJensen\CMB2SyntaxHighlighting\Tests
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @link        https://www.timjensen.us
 * @since       1.1.0
 */

namespace TimJensen\CMB2SyntaxHighlighting\Tests;

/**
 * Class Syntax_Highlighter_Test
 *
 * @package TimJensen\CMB2SyntaxHighlighting\Tests
 */
class Syntax_Highlighter_Test extends TestCase {

	public function test_get_assets_config() {
		$test_config = self::call_protected_method(
			$this->instances['css'],
			'get_assets_config',
			[]
		);

		$assets_config = include dirname( __DIR__ ) . '/config/assets.php';

		// Cannot compare the full array because certain strings are built dynamically.
		// But it can be assumed that if the first array element is equal, the method is
		// returning the correct file.
		$this->assertEquals( $assets_config, $test_config );
	}

	public function test_should_syntax_highlight() {
		$should_highlight_css = self::call_protected_method(
			$this->instances['css'],
			'should_syntax_highlight',
			[]
		);

		$should_highlight_js = self::call_protected_method(
			$this->instances['js'],
			'should_syntax_highlight',
			[]
		);

		$should_highlight_code = self::call_protected_method(
			$this->instances['code'],
			'should_syntax_highlight',
			[]
		);

		$this->assertTrue( $should_highlight_css );
		$this->assertTrue( $should_highlight_js );
		$this->assertFalse( $should_highlight_code );
	}

	public function test_is_javascript_mode() {
		$is_css_javascript_mode = self::call_protected_method(
			$this->instances['css'],
			'is_javascript_mode',
			[]
		);

		$is_js_javascript_mode = self::call_protected_method(
			$this->instances['js'],
			'is_javascript_mode',
			[]
		);

		$this->assertFalse( $is_css_javascript_mode );
		$this->assertTrue( $is_js_javascript_mode );
	}
}
