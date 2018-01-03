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
	 * CodeMirror mode, either css or javascript.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $mode = '';

	/**
	 * CodeMirror config.
	 *
	 * @var array
	 */
	protected $codemirror_config = [];

	/**
	 * Path to config directory.
	 *
	 * @var string
	 */
	protected $config_dir;

	/**
	 * Path to views directory.
	 *
	 * @var string
	 */
	protected $views_dir;

	/**
	 * CMB2_Syntax_Highlighter constructor.
	 */
	public function __construct() {
		$this->config_dir = dirname( __DIR__ ) . '/config';
		$this->views_dir  = dirname( __DIR__ ) . '/views';
	}

	/**
	 * Hook into the WP lifecycle.
	 */
	public function init() {
		add_filter( 'cmb2_row_classes', [ $this, 'initialize_syntax_highlighting' ], 10, 2 );
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
		$this->field_obj = $field_obj;

		if ( ! $this->should_syntax_highlight() ) {
			return $classes;
		}

		$this->field_id = $field_obj->args['id'];

		// Use CSS mode unless JavaScript mode has been specified.
		$this->mode = $this->is_javascript_mode() ? 'javascript' : 'css';

		$this->theme = $this->get_codemirror_theme();

		$assets = $this->get_assets_config();

		// Pass the necessary arguments to wp_enqueue_style and wp_enqueue_script.
		array_walk( $assets, function ( $asset ) {
			call_user_func_array( "wp_enqueue_{$asset['type']}", [
				$asset['handle'],
				$asset['src'],
				$asset['dep'],
				$asset['ver'],
			] );
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
				'mode'              => $this->mode,
				'theme'             => $this->theme,
			],
			$this->field_id,
			$this->field_obj
		);

		$this->codemirror_config[ $this->field_id ] = wp_json_encode( $codemirror_config );

		add_action( 'admin_print_footer_scripts', [ $this, 'print_codemirror_init_script' ], 20 );

		return $classes;
	}

	/**
	 * Print the CodeMirror initialization script.
	 *
	 * @since 1.0.0
	 */
	public function print_codemirror_init_script() {
		$codemirror_configs = $this->codemirror_config;

		array_walk( $codemirror_configs, function ( $codemirror_config, $field_id ) {
			include $this->views_dir . '/codemirror-init-script.php';
		} );
	}

	/**
	 * Return a filtered list of scripts and styles that will be enqueued.
	 *
	 * @return array
	 */
	protected function get_assets_config() {
		$scripts_and_styles = include $this->config_dir . '/assets.php';

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
	protected function get_codemirror_theme() {
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

	/**
	 * Determine if syntax highlighting should be added to the field.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	protected function should_syntax_highlight() {
		return 'textarea_code' === $this->field_obj->args['type'] && ! empty( $this->field_obj->args['syntax_highlighting'] );
	}

	/**
	 * Determine if the syntax highlihgting mode should be set to JavaScript.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	protected function is_javascript_mode() {
		return in_array( $this->field_obj->args['syntax_highlighting'], [ 'javascript', 'js' ], true );
	}
}
