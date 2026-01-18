<?php
/**
 * 검색 결과 템플릿
 */

get_header();
?>

<main class="site-main">
    <div class="site-container">
        
        <!-- 검색 헤더 -->
        <header class="search-header">
            <div class="search-title-wrapper">
                <h1 class="search-title">
                    🔍 "<?php echo get_search_query(); ?>" 검색 결과
                </h1>
                
                <?php
                global $wp_query;
                if ($wp_query->found_posts > 0) :
                ?>
                    <p class="search-results-count">
                        총 <strong><?php echo $wp_query->found_posts; ?></strong>개의 글을 찾았습니다
                    </p>
                <?php endif; ?>
                
                <!-- 검색 폼 -->
                <div class="search-form-wrapper">
                    <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                        <input type="search" 
                               class="search-field" 
                               placeholder="다시 검색하기..." 
                               value="<?php echo get_search_query(); ?>" 
                               name="s" />
                        <button type="submit" class="search-submit">검색</button>
                    </form>
                </div>
            </div>
        </header>
        
        <!-- 검색 결과 -->
        <div class="posts-grid">
            <?php
            if (have_posts()) :
                
                $post_count = 0;
                
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
                                <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
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
                    
                <?php endwhile; ?>
                
            <?php else : ?>
                
                <div class="no-results" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                    <div class="no-results-icon" style="font-size: 80px; margin-bottom: 20px;">🔍</div>
                    <h2>검색 결과가 없습니다</h2>
                    <p style="margin: 20px 0; color: #718096;">
                        "<strong><?php echo get_search_query(); ?></strong>"에 대한 검색 결과를 찾을 수 없습니다.<br>
                        다른 키워드로 검색해보세요.
                    </p>
                    
                    <!-- 추천 카테고리 -->
                    <?php
                    $categories = get_categories(array('number' => 6, 'orderby' => 'count', 'order' => 'DESC'));
                    if ($categories) :
                    ?>
                        <div class="suggested-categories">
                            <h3 style="margin-bottom: 15px;">🏷️ 인기 카테고리</h3>
                            <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                                <?php foreach ($categories as $category) : ?>
                                    <a href="<?php echo get_category_link($category->term_id); ?>" class="tag-item">
                                        <?php echo $category->name; ?> (<?php echo $category->count; ?>)
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
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
.search-header {
    text-align: center;
    padding: 60px 20px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 20px;
    margin-bottom: 50px;
}

.search-title {
    font-size: 32px;
    font-weight: 900;
    color: var(--text-color);
    margin-bottom: 10px;
}

.search-results-count {
    font-size: 16px;
    color: #718096;
    margin-bottom: 30px;
}

.search-form-wrapper {
    max-width: 600px;
    margin: 0 auto;
}

.search-form {
    display: flex;
    gap: 10px;
}

.search-field {
    flex: 1;
    padding: 14px 20px;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 16px;
    transition: var(--transition);
}

.search-field:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-submit {
    padding: 14px 30px;
    background: var(--button-gradient);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: var(--transition);
}

.search-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.no-results {
    background: var(--light-gray);
    border-radius: 20px;
    padding: 60px 40px;
}

.suggested-categories {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 2px solid var(--border-color);
}

@media (max-width: 768px) {
    .search-header {
        padding: 40px 20px;
    }
    
    .search-title {
        font-size: 24px;
    }
    
    .search-form {
        flex-direction: column;
    }
    
    .search-submit {
        width: 100%;
    }
}
</style>

<?php get_footer(); ?>
