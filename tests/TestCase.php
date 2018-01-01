<?php
/**
 * Class TestCase
 *
 * @package TimJensen\CMB2SyntaxHighlighting\Tests
 */

namespace TimJensen\CMB2SyntaxHighlighting\Tests;

use TimJensen\CMB2SyntaxHighlighting\CMB2_Syntax_Highlighter;

/**
 * Test Case.
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase {

	/**
	 * Holds instances of CMB2_Syntax_Highlighter.
	 *
	 * @var array
	 */
	public $instances = [];

	protected function setUp() {
		parent::setUp();

		$css_field_object_args = [
			'id'                  => 'cmb2_css_field',
			'type'                => 'textarea_code',
			'syntax_highlighting' => 'css',
		];

		$js_field_object_args = [
			'id'                  => 'cmb2_js_field',
			'type'                => 'textarea_code',
			'syntax_highlighting' => 'js',
		];

		$code_field_object_args = [
			'id'   => 'cmb2_code_field',
			'type' => 'textarea_code',
		];

		$this->init_highlighter_instance( 'css', $css_field_object_args );
		$this->init_highlighter_instance( 'js', $js_field_object_args );
		$this->init_highlighter_instance( 'code', $code_field_object_args );
	}

	protected function init_highlighter_instance( $type, $field_object_args ) {
		$field_object       = new \stdClass();
		$field_object->args = $field_object_args;

		$instance = new CMB2_Syntax_Highlighter();
		$instance->initialize_syntax_highlighting(
			'cmb2-classes',
			$field_object
		);

		$this->instances[ $type ] = $instance;
	}

	/**
	 * Call protected methods as public.
	 *
	 * @param CMB2_Syntax_Highlighter $instance    Instance of CMB2_Syntax_Highlighter
	 * @param string                  $method_name Name of protected method.
	 * @param array                   $args        Arguments to pass to the method.
	 * @return mixed
	 */
	public static function call_protected_method( $instance, $method_name, array $args ) {
		$class  = new \ReflectionClass( $instance );
		$method = $class->getMethod( $method_name );
		$method->setAccessible( true );

		return $method->invokeArgs( $instance, $args );
	}
}
