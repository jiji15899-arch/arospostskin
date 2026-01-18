<?php
/**
 * 페이지 템플릿
 * 고정 페이지용
 */

get_header();
?>

<main class="site-main">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <article id="page-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
            
            <header class="post-header">
                <h1 class="post-title"><?php the_title(); ?></h1>
            </header>
            
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-featured-image-wrapper">
                    <?php the_post_thumbnail('large', array('class' => 'post-featured-image')); ?>
                </div>
            <?php endif; ?>
            
            <div class="post-content">
                <?php the_content(); ?>
                
                <?php
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . '페이지: ',
                    'after' => '</div>',
                ));
                ?>
            </div>
            
        </article>
        
        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>
        
    <?php endwhile; ?>
    
</main>

<?php get_footer(); ?>
