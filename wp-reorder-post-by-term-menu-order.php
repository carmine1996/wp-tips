<?php

require_once("wp-load.php");

global $wpdb;

$post_type = 'product';
$taxonomy = 'product_cat';

$query = new WP_Query( 
    array(
        'post_type'             => $post_type,
        'post_status'           => 'publish',
        'posts_per_page' => -1,        
    )
);

echo '<p>Posts count: ' . $query->post_count . '</p>';

$terms = get_terms( array(
    'taxonomy' => $taxonomy,
    'hide_empty' => false,
));

if ( $query->have_posts() ): 
    while( $query->have_posts() ): 
        $query->the_post();
        
        foreach ( $terms as $term ){
            if( has_term($term->term_id, $taxonomy) ){
                $wpdb->update($wpdb->prefix . "posts", array( 'menu_order' => $term->term_order ), array('ID' => get_the_ID()));
                echo '<p>' . $query->post->post_title . ' (' . $query->post->ID . ') Nuovo menu order: '.$luogo->term_order.'</p>';
            }
        }

    endwhile;
    wp_reset_postdata();
endif;
