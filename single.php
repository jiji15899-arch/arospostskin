<?php get_header(); ?>

<!-- 메인 컨텐츠 -->
<div class='container'>
    <div class='main section' id='main'>
        <div class='widget Blog'>
            <div class='blog-posts hfeed'>
                <?php while (have_posts()) : the_post(); ?>
                <div class='post-outer'>
                    <article class='post hentry' <?php post_class(); ?>>
                        <div class='post-body entry-content' id='post-body-<?php the_ID(); ?>'>
                            <?php the_content(); ?>
                        </div>
                    </article>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
