<?php get_header(); ?>

<!-- 메인 컨텐츠 -->
<div class='container'>
    <div class='main section' id='main'>
        <div class='widget Blog'>
            <div class='blog-posts hfeed'>
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class='post-outer'>
                            <article class='post hentry' <?php post_class(); ?>>
                                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <div class='post-body entry-content'>
                                    <?php the_excerpt(); ?>
                                </div>
                            </article>
                        </div>
                    <?php endwhile; ?>
                    
                    <div class="pagination">
                        <?php 
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => '« 이전',
                            'next_text' => '다음 »',
                        )); 
                        ?>
                    </div>
                <?php else : ?>
                    <p>게시물이 없습니다.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
