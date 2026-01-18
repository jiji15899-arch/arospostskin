<?php
/**
 * 아카이브 템플릿
 * 카테고리, 태그, 날짜 아카이브 등
 */

get_header();
?>

<main class="site-main">
    <div class="site-container">
        
        <!-- 아카이브 헤더 -->
        <header class="archive-header">
            <div class="archive-title-wrapper">
                <?php
                if (is_category()) :
                    $category = get_queried_object();
                    echo '<h1 class="archive-title">🏷️ ' . single_cat_title('', false) . '</h1>';
                    if ($category->description) :
                        echo '<p class="archive-description">' . $category->description . '</p>';
                    endif;
                elseif (is_tag()) :
                    echo '<h1 class="archive-title">🔖 ' . single_tag_title('', false) . '</h1>';
                elseif (is_author()) :
                    echo '<h1 class="archive-title">✍️ ' . get_the_author() . '님의 글</h1>';
                elseif (is_date()) :
                    echo '<h1 class="archive-title">📅 ' . get_the_date('Y년 m월') . '</h1>';
                else :
                    echo '<h1 class="archive-title">📚 아카이브</h1>';
                endif;
                ?>
            </div>
        </header>
        
        <!-- 포스트 그리드 -->
        <div class="posts-grid">
            <?php
            if (have_posts()) :
                
                $post_count = 0;
                $ad_code = get_theme_mod('abaek_dable_home_code', '');
                $ad_enabled = get_theme_mod('abaek_dable_home_enabled', true);
                
                while (have_posts()) :
                    the_post();
                    $post_count++;
                    ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('post-card-thumb', array('class' => 'post-card-image')); ?>
                            </a>
                        <?php else : ?>
                            <a href="<?php the_permalink(); ?>">
                                <div class="post-card-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                                    📄
                                </div>
                            </a>
                        <?php endif; ?>
                        
                        <div class="post-card-content">
                            <h2 class="post-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <p class="post-card-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </p>
                            
                            <div class="post-card-meta">
                                <span class="post-date">
                                    📅 <?php echo get_the_date('Y.m.d'); ?>
                                </span>
                                <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                    자세히 보기 →
                                </a>
                            </div>
                        </div>
                        
                    </article>
                    
                    <?php
                    // 2개 글마다 광고 삽입
                    if ($post_count % 2 === 0 && $ad_enabled && !empty($ad_code)) :
                    ?>
                        <div class="dable-ad-home">
                            <div class="dable-ad-label">Sponsored Content</div>
                            <?php echo $ad_code; ?>
                        </div>
                    <?php endif; ?>
                    
                <?php endwhile; ?>
                
            <?php else : ?>
                
                <div class="no-posts" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                    <h2>😢 해당하는 게시글이 없습니다</h2>
                    <p><a href="<?php echo home_url('/'); ?>" class="read-more-btn">홈으로 돌아가기</a></p>
                </div>
                
            <?php endif; ?>
            
        </div>
        
        <!-- 페이지네이션 -->
        <?php if (have_posts()) : ?>
            <nav class="pagination">
                <div class="pagination-inner">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '← 이전',
                        'next_text' => '다음 →',
                        'type' => 'list',
                        'mid_size' => 2
                    ));
                    ?>
                </div>
            </nav>
        <?php endif; ?>
        
    </div>
</main>

<style>
.archive-header {
    text-align: center;
    padding: 60px 20px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 20px;
    margin-bottom: 50px;
}

.archive-title {
    font-size: 36px;
    font-weight: 900;
    color: var(--text-color);
    margin-bottom: 15px;
}

.archive-description {
    font-size: 16px;
    color: #718096;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .archive-header {
        padding: 40px 20px;
    }
    
    .archive-title {
        font-size: 28px;
    }
}
</style>

<?php get_footer(); ?>
