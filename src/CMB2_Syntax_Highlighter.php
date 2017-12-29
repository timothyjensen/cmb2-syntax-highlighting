<?php
/**
 * CMB2 Syntax Highlighter
 *
 * @package     TimJensen\CMB2SyntaxHighlighting
 * @author      Tim Jensen <tim@timjensen.us>
 * @license     GNU General Public License 2.0+
 * @link        https://www.timjensen.us
 * @since       0.1.0
 */

namespace TimJensen\CMB2SyntaxHighlighting;

/**
 * Class CMB2_Syntax_Highlighter
 *
 * @package TimJensen\CMB2SyntaxHighlighting
 */
class CMB2_Syntax_Highlighter {

	/**
	 * CMB2 Field Object.
	 *
	 * @var object
	 */
	protected $field_obj;

	/**
	 * CMB2 Field ID.
	 *
	 * @var string
	 */
	protected $field_id = '';

	/**
	 * CodeMirror config.
	 *
	 * @var array
	 */
	protected $codemirror_config = [];

	/**
	 * CMB2_Syntax_Highlighter constructor.
	 */
	public function __construct() {
	}

	/**
	 * Hook into the WP lifecycle.
	 */
	public function init() {
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_filter( 'cmb2_row_classes', [ $this, 'initialize_syntax_highlighting' ], 10, 2 );
	}

	/**
	 * Register scripts and styles that will be later enqueued if a field has the 'syntax_highlighting' option set.
	 */
	public function register_scripts() {
		$assets = $this->get_codemirror_scripts();

		array_walk( $assets, function ( $asset ) {
			// Pass the necessary arguments to wp_register_style and wp_register_script.
			call_user_func_array( "wp_register_{$asset['type']}",
				[
					$asset['handle'],
					$asset['src'],
					$asset['dep'],
					$asset['ver'],
				]
			);
		} );
	}

	/**
	 * Initialize syntax highlighting for fields that have 'syntax_highlighting' set.
	 * We are hooking into cmb2_row_classes since there seems to be no better option.
	 *
	 * @param string $classes Space-separated list of row classes
	 * @param CMB2_Field object $field   This field object
	 * @return string
	 */
	public function initialize_syntax_highlighting( $classes, $field_obj ) {
		if (
			empty( $field_obj->args['syntax_highlighting'] )
			|| 'textarea_code' !== $field_obj->args['type']
		) {
			return $classes;
		}

		$this->field_obj = $field_obj;
		$this->field_id  = $field_obj->args['id'];

		$assets = $this->get_codemirror_scripts();

		array_walk( $assets, function ( $asset ) {
			// Pass the necessary arguments to wp_enqueue_style and wp_enqueue_script.
			call_user_func_array( "wp_enqueue_{$asset['type']}", [ $asset['handle'] ] );
		} );

		/**
		 * Filter the CodeMirror configuration.
		 *
		 * @see http://codemirror.net/2/doc/manual.html#config
		 * @param array  $codemirror_config Configuration for the CodeMirror fromTextArea method.
		 * @param string $field_id          CMB2 field ID.
		 * @param obj    $field_obj         CMB2 field object.
		 */
		$codemirror_config = apply_filters( 'cmb2_syntax_highlighting_codemirror_config',
			[
				'autoCloseBrackets' => true,
				'lineNumbers'       => true,
				'styleActiveLine'   => true,
				'theme'             => $this->get_codemirror_theme(),
			],
			$this->field_id,
			$this->field_obj
		);

		$this->codemirror_config = json_encode( $codemirror_config );

		add_action( 'admin_print_footer_scripts', function () {
			include CMB2_SYNTAX_HIGHLIGHTING_VIEWS_DIR . '/print-script.php';
		}, 99 );

		return $classes;
	}

	/**
	 * Return a filtered list of scripts and styles that will be enqueued.
	 *
	 * @return array
	 */
	protected function get_codemirror_scripts() {
		$scripts_and_styles = include CMB2_SYNTAX_HIGHLIGHTING_CONFIG_DIR . '/scripts-styles.php';

		/**
		 * Filters the list of scripts and styles that will be enqueued.
		 *
		 * @param array  $scripts_and_styles Array of scripts and styles to enqueue/register.
		 * @param string $field_id           CMB2 field ID.
		 * @param obj    $field_obj          CMB2 field object.
		 */
		return apply_filters( 'cmb2_syntax_highlighting_dependencies', $scripts_and_styles, $this->field_id, $this->field_obj );
	}

	/**
	 * Return the CodeMirror theme name that will be used.
	 *
	 * @return string
	 */
	public function get_codemirror_theme() {
		/**
		 * Filters the CodeMirror theme.
		 *
		 * @see https://github.com/codemirror/CodeMirror/tree/master/theme
		 *
		 * @param string $theme     Name of the CodeMirror theme to use.
		 * @param string $field_id  CMB2 field ID.
		 * @param obj    $field_obj CMB2 field object.
		 */
		return apply_filters( 'cmb2_syntax_highlighting_theme', 'monokai', $this->field_id, $this->field_obj );
	}
}
