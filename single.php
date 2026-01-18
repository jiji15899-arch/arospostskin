<?php get_header(); ?>

<div class='container'>
    <div class='main section' id='main'>
        <div class='widget Blog'>
            <div class='blog-posts hfeed'>
                <?php while (have_posts()) : the_post(); ?>
                
                <article class='post hentry' <?php post_class(); ?>>
                    <header class="post-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        
                        <div class="post-meta">
                            <span class="date"><?php echo get_the_date('Y.m.d'); ?></span>
                            <span class="author"> · <?php the_author(); ?></span>
                        </div>
                    </header>

                    <div class='post-body entry-content' id='post-body-<?php the_ID(); ?>'>
                        <?php the_content(); ?>
                    </div>
                </article>

                <div class="post-navigation" style="margin-top:50px; border-top:1px solid #eee; padding-top:20px;">
                    <?php 
                        the_post_navigation(array(
                            'prev_text' => '<span class="nav-subtitle">이전 글</span> <span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-subtitle">다음 글</span> <span class="nav-title">%title</span>',
                        )); 
                    ?>
                </div>

                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
