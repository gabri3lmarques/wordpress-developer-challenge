<?php 

// Carregando arquivos css e js 
function load_scripts() {
    wp_enqueue_style('bx-desafio-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0');
    wp_enqueue_script('bx-desafio-carousel-js', get_template_directory_uri() . '/assets/js/carousel.js', array(), '1.0.0', true);
    wp_enqueue_script('bx-desafio-main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'load_scripts');

// criando o post type para os videos
function create_video_post_type() {
    $labels = array(
        'name'               => 'Videos',
        'singular_name'      => 'Video',
        'menu_name'          => 'Videos',
        'name_admin_bar'     => 'Video',
        'add_new'            => 'Adicionar Novo',
        'add_new_item'       => 'Adicionar Novo Video',
        'new_item'           => 'Novo Video',
        'edit_item'          => 'Editar Video',
        'view_item'          => 'Ver Video',
        'all_items'          => 'Todos os Videos',
        'search_items'       => 'Procurar Videos',
        'parent_item_colon'  => 'Video Pai:',
        'not_found'          => 'Nenhum video encontrado.',
        'not_found_in_trash' => 'Nenhum video encontrado no lixo.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'video'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'menu_icon'          => 'dashicons-video-alt3'
    );

    register_post_type('video', $args);
}

add_action('init', 'create_video_post_type');

// criando as taxonomias para os videos
function create_video_taxonomy() {
    $labels = array(
        'name'              => 'Tipos de Video',
        'singular_name'     => 'Tipo de Video',
        'search_items'      => 'Procurar Tipos de Video',
        'all_items'         => 'Todos os Tipos de Video',
        'parent_item'       => 'Tipo de Video Pai',
        'parent_item_colon' => 'Tipo de Video Pai:',
        'edit_item'         => 'Editar Tipo de Video',
        'update_item'       => 'Atualizar Tipo de Video',
        'add_new_item'      => 'Adicionar Novo Tipo de Video',
        'new_item_name'     => 'Novo Nome de Tipo de Video',
        'menu_name'         => 'Tipo de Video',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'video_type'),
    );

    register_taxonomy('video_type', array('video'), $args);

    // Adicionar termos padrão
    if (!term_exists('movie', 'video_type')) {
        wp_insert_term('Movie', 'video_type');
    }
    if (!term_exists('serie', 'video_type')) {
        wp_insert_term('Serie', 'video_type');
    }
    if (!term_exists('doc', 'video_type')) {
        wp_insert_term('Doc', 'video_type');
    }
}

add_action('init', 'create_video_taxonomy');

// adicionando campos personalizados

function add_video_meta_boxes() {
    add_meta_box(
        'video_duration_meta_box', // ID da meta box
        'Duração do Video', // Título da meta box
        'display_video_duration_meta_box', // Callback para exibir o conteúdo da meta box
        'video', // Tipo de post ao qual esta meta box pertence
        'side', // Contexto da meta box (lado direito)
        'default' // Prioridade
    );

    add_meta_box(
        'video_id_meta_box', // ID da nova meta box
        'ID do Video', // Título da nova meta box
        'display_video_id_meta_box', // Callback para exibir o conteúdo da nova meta box
        'video', // Tipo de post ao qual esta meta box pertence
        'side', // Contexto da nova meta box (lado direito)
        'default' // Prioridade
    );
}

add_action('add_meta_boxes', 'add_video_meta_boxes');

function display_video_duration_meta_box($post) {
    // Obter o valor atual do campo personalizado
    $duration = get_post_meta($post->ID, 'bx_play_video_duration', true);
    ?>
    <label for="bx_play_video_duration">Duração (em minutos):</label>
    <input type="number" name="bx_play_video_duration" id="bx_play_video_duration" value="<?php echo esc_attr($duration); ?>" min="0" />
    <?php
}

function display_video_id_meta_box($post) {
    // Obter o valor atual do campo personalizado
    $video_id = get_post_meta($post->ID, 'bx_play_video_ID', true);
    ?>
    <label for="bx_play_video_ID">ID do Video:</label>
    <input type="text" name="bx_play_video_ID" id="bx_play_video_ID" value="<?php echo esc_attr($video_id); ?>" />
    <?php
}

function save_video_meta_boxes($post_id) {
    // Verificar se o campo `bx_play_video_duration` está definido
    if (isset($_POST['bx_play_video_duration'])) {
        // Sanitizar o valor antes de salvar
        $duration = sanitize_text_field($_POST['bx_play_video_duration']);
        update_post_meta($post_id, 'bx_play_video_duration', $duration);
    }

    // Verificar se o campo `bx_play_video_ID` está definido
    if (isset($_POST['bx_play_video_ID'])) {
        // Sanitizar o valor antes de salvar
        $video_id = sanitize_text_field($_POST['bx_play_video_ID']);
        update_post_meta($post_id, 'bx_play_video_ID', $video_id);
    }
}

add_action('save_post', 'save_video_meta_boxes');

// campo imagem

function add_video_image_meta_box() {
    add_meta_box(
        'video_image_meta_box', // ID da nova meta box para imagem
        'Imagem do Video', // Título da nova meta box para imagem
        'display_video_image_meta_box', // Callback para exibir o conteúdo da nova meta box para imagem
        'video', // Tipo de post ao qual esta meta box pertence
        'side', // Contexto da nova meta box (lado direito)
        'default' // Prioridade
    );
}

add_action('add_meta_boxes', 'add_video_image_meta_box');

function display_video_image_meta_box($post) {
    // Obter o ID da imagem salva
    $image_id = get_post_meta($post->ID, 'bx_play_image', true);
    ?>
    <label for="bx_play_image">Imagem do Video:</label>
    <input type="hidden" name="bx_play_image" id="bx_play_image" value="<?php echo esc_attr($image_id); ?>" />
    <div class="image-preview">
        <?php
        if ($image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
            $image_title = get_the_title($image_id);
            echo '<img src="' . esc_url($image_url) . '" alt="Imagem do Video" style="max-width:100%;height:auto;" />';
            echo '<p>Nome da Imagem: ' . esc_html($image_title) . '</p>';
        } else {
            echo '<p>Nenhuma imagem selecionada</p>';
        }
        ?>
    </div>
    <p>
        <input type="button" id="upload_image_button" class="button" value="Selecionar Imagem">
        <input type="button" id="remove_image_button" class="button" value="Remover Imagem">
    </p>

    <script>
        jQuery(document).ready(function($) {
            var mediaUploader;

            $('#upload_image_button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Escolher Imagem',
                    button: {
                        text: 'Selecionar Imagem'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#bx_play_image').val(attachment.id);
                    $('.image-preview img').attr('src', attachment.url);
                    $('.image-preview p').html('Nome da Imagem: ' + attachment.title);
                });

                mediaUploader.open();
            });

            $('#remove_image_button').click(function(e) {
                e.preventDefault();
                $('#bx_play_image').val('');
                $('.image-preview img').attr('src', '');
                $('.image-preview p').html('Nenhuma imagem selecionada');
            });
        });
    </script>
    <?php
}

function save_video_image_meta_box($post_id) {
    // Verificar se o campo `bx_play_image` está definido
    if (isset($_POST['bx_play_image'])) {
        // Sanitizar o valor antes de salvar
        $image_id = sanitize_text_field($_POST['bx_play_image']);
        update_post_meta($post_id, 'bx_play_image', $image_id);
    }
}
add_action('save_post', 'save_video_image_meta_box');






