<?php
/**
 * 메인 인덱스 템플릿
 * 홈페이지 및 블로그 목록 페이지
 */

get_header();
?>

<main class="site-main">
    <div class="site-container">
        
        <?php if (is_home() && !is_paged()) : ?>
            <!-- 메인 배너 (선택적) -->
            <section class="hero-section">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <?php echo get_bloginfo('description') ? get_bloginfo('description') : '최신 정보와 유용한 팁을 공유합니다'; ?>
                    </h1>
                    <p class="hero-subtitle">매일 업데이트되는 알찬 콘텐츠를 만나보세요</p>
                </div>
            </section>
        <?php endif; ?>
        
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
                    <h2>😢 아직 게시글이 없습니다</h2>
                    <p>곧 유익한 콘텐츠로 찾아뵙겠습니다!</p>
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

<?php get_footer(); ?>
