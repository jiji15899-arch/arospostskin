<?php
/**
 * 404 에러 페이지
 */

get_header();
?>

<main class="site-main">
    <div class="site-container">
        
        <div class="error-404-content">
            
            <div class="error-icon">404</div>
            
            <h1 class="error-title">페이지를 찾을 수 없습니다</h1>
            
            <p class="error-description">
                죄송합니다. 요청하신 페이지가 존재하지 않거나<br>
                이동되었을 수 있습니다.
            </p>
            
            <!-- 검색 폼 -->
            <div class="error-search">
                <h3>🔍 검색하기</h3>
                <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                    <input type="search" 
                           class="search-field" 
                           placeholder="찾으시는 내용을 검색해보세요..." 
                           name="s" />
                    <button type="submit" class="search-submit">검색</button>
                </form>
            </div>
            
            <!-- 인기 글 -->
            <?php
            $popular_posts = new WP_Query(array(
                'posts_per_page' => 6,
                'meta_key' => 'abaek_post_views',
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
            ));
            
            if ($popular_posts->have_posts()) :
            ?>
                <div class="error-popular-posts">
                    <h3>📌 인기 글</h3>
                    <div class="posts-grid">
                        <?php while ($popular_posts->have_posts()) : $popular_posts->the_post(); ?>
                            <article class="post-card">
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
                                    <h4 class="post-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                    
                                    <div class="post-card-meta">
                                        <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                            읽어보기 →
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php
            endif;
            wp_reset_postdata();
            ?>
            
            <!-- 카테고리 -->
            <?php
            $categories = get_categories(array('number' => 8));
            if ($categories) :
            ?>
                <div class="error-categories">
                    <h3>🏷️ 카테고리 둘러보기</h3>
                    <div class="category-grid">
                        <?php foreach ($categories as $category) : ?>
                            <a href="<?php echo get_category_link($category->term_id); ?>" class="category-card">
                                <span class="category-name"><?php echo $category->name; ?></span>
                                <span class="category-count"><?php echo $category->count; ?>개</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- 홈 버튼 -->
            <div class="error-home-button">
                <a href="<?php echo home_url('/'); ?>" class="btn-home">
                    🏠 홈으로 돌아가기
                </a>
            </div>
            
        </div>
        
    </div>
</main>

<style>
.error-404-content {
    max-width: 900px;
    margin: 0 auto;
    padding: 60px 20px;
    text-align: center;
}

.error-icon {
    font-size: 120px;
    font-weight: 900;
    background: var(--button-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 20px;
    line-height: 1;
}

.error-title {
    font-size: 36px;
    font-weight: 900;
    color: var(--text-color);
    margin-bottom: 15px;
}

.error-description {
    font-size: 16px;
    color: #718096;
    margin-bottom: 50px;
    line-height: 1.8;
}

.error-search {
    max-width: 600px;
    margin: 0 auto 60px;
}

.error-search h3 {
    font-size: 20px;
    margin-bottom: 20px;
    color: var(--text-color);
}

.error-popular-posts,
.error-categories {
    margin-bottom: 60px;
}

.error-popular-posts h3,
.error-categories h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 30px;
    color: var(--text-color);
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    max-width: 800px;
    margin: 0 auto;
}

.category-card {
    padding: 20px;
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    text-decoration: none;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.category-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.category-name {
    font-weight: 700;
    color: var(--text-color);
    font-size: 16px;
}

.category-count {
    font-size: 13px;
    color: #a0aec0;
}

.error-home-button {
    margin-top: 60px;
}

.btn-home {
    display: inline-block;
    padding: 16px 40px;
    background: var(--button-gradient);
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 18px;
    transition: var(--transition);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-home:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

@media (max-width: 768px) {
    .error-icon {
        font-size: 80px;
    }
    
    .error-title {
        font-size: 28px;
    }
    
    .category-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .posts-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
