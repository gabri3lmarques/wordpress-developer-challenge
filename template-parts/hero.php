<?php
// Definir os argumentos para a consulta
$args = array(
    'post_type'      => 'video', // Tipo de post
    'posts_per_page' => 1,  // Número de posts a serem retornados
    'tax_query'      => array(
        array(
            'taxonomy' => 'video_type', // Nome da taxonomia
            'field'    => 'slug', // Campo a ser comparado
            'terms'    => 'movie', // Valor da taxonomia
        ),
    ),
    'orderby'        => 'date', // Ordenar por data
    'order'          => 'DESC', // Ordem decrescente
);

// Criar a consulta
$query = new WP_Query($args);

// Verificar se há posts correspondentes
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();

        // Sanitização das metadatas
        $duration   = esc_html(get_post_meta(get_the_ID(), 'bx_play_video_duration', true));
        $type       = esc_html(get_post_meta(get_the_ID(), 'video_type', true));
        $video_link = esc_url(get_post_meta(get_the_ID(), 'bx_play_video_ID', true));
        $image_id   = get_post_meta(get_the_ID(), 'bx_play_image', true);
        $image_url  = esc_url(wp_get_attachment_image_url($image_id, 'full'));

        $terms = get_the_terms(get_the_ID(), 'video_type');

        if ($terms && !is_wp_error($terms)) {
            $terms_list = wp_list_pluck($terms, 'name');
            $terms_list = array_map('esc_html', $terms_list); // Sanitiza cada termo
        }

        ?>

        <div class="bx-desafio-hero">
            <div class="bx-desafio-hero-bg" style="background-image: url('<?php echo $image_url; ?>');">           
            </div>

            <div class="bx-desafio-hero-inner">
                <div class="bx-desafio-hero-meta flex">
                    <button class="bx-desafio-button small taxonomy flex align-items-center justify-content-center"><?php echo implode(', ', $terms_list); ?></button>
                    <button class="bx-desafio-button small time flex align-items-center justify-content-center"><?php echo $duration; ?></button>
                </div>
                <div class="bx-desafio-hero-title">
                    <h1 class="bx-desafio-home"><?php the_title(); ?></h1>
                </div>
                <div class="bx-desafio-hero-cta">
                    <a href="#" class="bx-desafio-button large flex align-items-center justify-content-center">Mais informações</a>
                </div>
            </div> 
        </div>
        
        <?php     

    endwhile;
    // Resetar os dados do post
    wp_reset_postdata();
else :
    // Mensagem caso não haja posts correspondentes
    echo '<p>Nenhum post encontrado.</p>';
endif;
?>
