<?php
/**
 * @var object $this Instance of CMB2_Syntax_Highlighter.
 */

namespace TimJensen\CMB2SyntaxHighlighting;

?>

<script>
    CodeMirror.fromTextArea(<?php echo esc_js( $this->field_id );?>, <?php echo wp_kses_post( $this->codemirror_config ); ?>);
</script>
