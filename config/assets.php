<?php
/**
 * All dep for CodeMirror syntax highlighting.
 */

namespace TimJensen\CMB2SyntaxHighlighting;

return [
	[
		'type'   => 'style',
		'handle' => 'codemirror-css',
		'src'    => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.33.0/codemirror.css',
		'dep'    => [],
		'ver'    => '5.33.0',
	],
	[
		'type'   => 'style',
		'handle' => 'codemirror-theme',
		'src'    => "https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.33.0/theme/{$this->theme}.min.css",
		'dep'    => [],
		'ver'    => '5.33.0',
	],
	[
		'type'   => 'script',
		'handle' => 'codemirror-js',
		'src'    => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.33.0/codemirror.js',
		'dep'    => [],
		'ver'    => '5.33.0',
	],
	[
		'type'   => 'script',
		'handle' => "codemirror-mode-script-{$this->mode}",
		'src'    => "https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.33.0/mode/{$this->mode}/{$this->mode}.js",
		'dep'    => [ 'codemirror-js' ],
		'ver'    => '5.33.0',
	],
	[
		'type'   => 'script',
		'handle' => 'codemirror-close-brackets',
		'src'    => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.33.0/addon/edit/closebrackets.min.js',
		'dep'    => [ 'codemirror-js' ],
		'ver'    => '5.33.0',
	],
	[
		'type'   => 'script',
		'handle' => 'codemirror-active-line',
		'src'    => 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.33.0/addon/selection/active-line.min.js',
		'dep'    => [ 'codemirror-js' ],
		'ver'    => '5.33.0',
	],
];
