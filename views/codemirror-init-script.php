<?php
/**
 * @var string $field_id          CMB2 field ID.
 * @var string $codemirror_config CodeMirror configuration in JSON format.
 */

namespace TimJensen\CMB2SyntaxHighlighting;

?>

<script>
    CodeMirror.fromTextArea(<?php echo esc_js( $field_id );?>, <?php echo wp_kses_post( $codemirror_config ); ?>);
</script>
