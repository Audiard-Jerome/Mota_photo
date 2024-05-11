<div id="modal2" class="modal2" role="dialog" aria-modal="false">
    <div class="modal2-wrapper js-modal-stop">
        <div class="previous"><span class="icon_prev"></span>Précédente</div>
        <div class="next">Suivante<span class="icon_next"></span></div>
        <div class="close"></div>
        <div class="photoContainer">
            <div class="photo">
                <?php
                    echo '<img src="' . esc_url(get_template_directory_uri() . '/img/testpor.jpeg') . '" alt="Photo" />';
                ?>
                <p class="photoRef">Ref Photo</p>
                <p class="photoCat">Cat photo</p>
            </div>
        </div> 
    </div>
</div>