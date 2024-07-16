<?php
function add_active_class_based_on_url($url_part) {
    // Obtém a URL atual
    $current_url = $_SERVER['REQUEST_URI'];
    
    // Verifica se a URL atual contém a expressão desejada
    if (strpos($current_url, $url_part) !== false) {
        return 'active';
    }
    return '';
}
?>

<nav  class="bx-desafio-menu">
    <div class="bx-desafio-logo">
        <a href="/">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/template/logo.svg" alt="Site Logo">
        </a>
    </div>
    <ul class="bx-desafio-links">
        <li><a href="<?php echo get_post_type_archive_link('video'); ?>?video_type=movie" class="<?php echo add_active_class_based_on_url('movie'); ?>">Filmes</a></li>
        <li><a href="<?php echo get_post_type_archive_link('video'); ?>?video_type=doc" class="<?php echo add_active_class_based_on_url('doc'); ?>">Documentários</a></li>
        <li><a href="<?php echo get_post_type_archive_link('video'); ?>?video_type=serie" class="<?php echo add_active_class_based_on_url('serie'); ?>">Séries</a></li>
    </ul>
</nav>

<nav  class="bx-desafio-menu-mobile">
    <div class="bx-desafio-menu-mobile-warpper">
        <div class="bx-desafio-logo-mobile visible">
            <a href="/">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/template/logo-mobile.svg" alt="Site Logo">
            </a>
        </div>
        <ul class="bx-desafio-links-mobile">
            <li><a href="<?php echo get_post_type_archive_link('video'); ?>?video_type=movie" class="<?php echo add_active_class_based_on_url('movie'); ?>">Filmes</a></li>
            <li><a href="<?php echo get_post_type_archive_link('video'); ?>?video_type=doc" class="<?php echo add_active_class_based_on_url('doc'); ?>">Documentários</a></li>
            <li><a href="<?php echo get_post_type_archive_link('video'); ?>?video_type=serie" class="<?php echo add_active_class_based_on_url('serie'); ?>">Séries</a></li>
        </ul>        
    </div>
</nav>