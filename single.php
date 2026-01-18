<?php
/**
 * 단일 포스트 템플릿
 * 개별 글 페이지
 */

get_header();
?>

<main class="site-main">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
            
            <!-- 포스트 헤더 -->
            <header class="post-header">
                
                <h1 class="post-title"><?php the_title(); ?></h1>
                
                <div class="post-meta">
                    <span class="meta-item">
                        📅 <?php echo get_the_date('Y년 m월 d일'); ?>
                    </span>
                    
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) :
                    ?>
                        <span class="meta-item">
                            🏷️ <?php echo esc_html($categories[0]->name); ?>
                        </span>
                    <?php endif; ?>
                    
                    <span class="meta-item">
                        👁️ <?php echo abaek_get_post_views(); ?> 조회
                    </span>
                </div>
                
            </header>
            
            <!-- 대표 이미지 -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-featured-image-wrapper">
                    <?php the_post_thumbnail('large', array('class' => 'post-featured-image')); ?>
                </div>
            <?php endif; ?>
            
            <!-- 소셜 공유 버튼 (상단) -->
            <div class="social-share-top">
                <?php echo abaek_social_share_buttons(); ?>
            </div>
            
            <!-- 포스트 콘텐츠 -->
            <div class="post-content">
                <?php the_content(); ?>
            </div>
            
            <!-- 태그 -->
            <?php
            $tags = get_the_tags();
            if ($tags) :
            ?>
                <div class="post-tags">
                    <span class="tags-label">🏷️ 태그:</span>
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="tag-item">
                            #<?php echo esc_html($tag->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <!-- 소셜 공유 버튼 (하단) -->
            <div class="social-share-bottom">
                <h3 class="share-title">📤 이 글이 도움이 되셨나요? 공유해주세요!</h3>
                <?php echo abaek_social_share_buttons(); ?>
            </div>
            
            <!-- 작성자 정보 -->
            <div class="author-box">
                <div class="author-avatar">
                    <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                </div>
                <div class="author-info">
                    <h4 class="author-name"><?php the_author(); ?></h4>
                    <p class="author-bio"><?php echo get_the_author_meta('description') ? get_the_author_meta('description') : '유익한 정보를 공유합니다.'; ?></p>
                </div>
            </div>
            
        </article>
        
        <!-- 관련 글 + 데이블 광고 섹션 -->
        <?php abaek_related_posts_with_dable(); ?>
        
        <!-- 댓글 -->
        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>
        
    <?php endwhile; ?>
    
</main>

<?php
// 조회수 증가
abaek_set_post_views(get_the_ID());

get_footer();
?>
