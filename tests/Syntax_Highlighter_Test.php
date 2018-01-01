<?php
/**
 * Syntax_Highlighter_Test
 *
 * @package     TimJensen\CMB2SyntaxHighlighting\Tests
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @link        https://www.timjensen.us
 * @since       1.0.0
 */

namespace TimJensen\CMB2SyntaxHighlighting\Tests;

/**
 * Class Syntax_Highlighter_Test
 *
 * @package TimJensen\CMB2SyntaxHighlighting\Tests
 */
class Syntax_Highlighter_Test extends TestCase {

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
}
