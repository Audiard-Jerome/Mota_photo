<!-- Charge le JS et le CSS de WPCF7 uniquement quand on charge la modale de contact -->
<?php
 
if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
  wpcf7_enqueue_scripts();
}
 
if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
  wpcf7_enqueue_styles();
}
 
?>
<div id="modal1" class="modal" role="dialog" aria-modal="false" style="display:none;">
    <div class="modal-wrapper js-modal-stop">
        <div class="formContactHeader"></div>    
        <?php echo do_shortcode('[contact-form-7 id="7980fc8" title="Formulaire de contact"]') ?>
    </div>
</div>