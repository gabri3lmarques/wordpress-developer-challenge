<?php 

function meu_tema_scripts() {
    wp_enqueue_style('bx-desafio-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0');
    wp_enqueue_script('bx-desafio-script', get_template_directory_uri() . '/assets/js/script.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'meu_tema_scripts');