<?php
/**
 * Abaek Dable Revenue Pro - Functions
 * 데이블 광고 수익 극대화 시스템
 */

// ========================================
// 1. 테마 설정
// ========================================
function abaek_theme_setup() {
    // 테마 지원 기능
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    
    // 이미지 크기
    add_image_size('post-card-thumb', 600, 400, true);
    add_image_size('related-post-thumb', 400, 300, true);
    
    // 메뉴 등록
    register_nav_menus(array(
        'primary' => '메인 메뉴',
        'footer' => '푸터 메뉴'
    ));
}
add_action('after_setup_theme', 'abaek_theme_setup');

// ========================================
// 2. 데이블 광고 설정 (커스터마이저)
// ========================================
function abaek_customizer_settings($wp_customize) {
    // 데이블 광고 섹션
    $wp_customize->add_section('abaek_dable_ads', array(
        'title' => '💰 데이블 광고 설정',
        'priority' => 30,
    ));
    
    // 홈 광고 코드
    $wp_customize->add_setting('abaek_dable_home_code', array(
        'default' => '',
        'sanitize_callback' => 'abaek_sanitize_js'
    ));
    
    $wp_customize->add_control('abaek_dable_home_code', array(
        'label' => '홈 광고 코드 (2개 글마다 노출)',
        'description' => '데이블 스크립트 코드를 붙여넣으세요',
        'section' => 'abaek_dable_ads',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 8,
            'placeholder' => '<script>...</script>'
        )
    ));
    
    // 관련 글 광고 코드
    $wp_customize->add_setting('abaek_dable_related_code', array(
        'default' => '',
        'sanitize_callback' => 'abaek_sanitize_js'
    ));
    
    $wp_customize->add_control('abaek_dable_related_code', array(
        'label' => '관련 글 광고 코드',
        'description' => '글 하단 관련 글 섹션에 노출됩니다',
        'section' => 'abaek_dable_ads',
        'type' => 'textarea',
        'input_attrs' => array(
            'rows' => 8,
            'placeholder' => '<script>...</script>'
        )
    ));
    
    // 광고 활성화 옵션
    $wp_customize->add_setting('abaek_dable_home_enabled', array(
        'default' => true,
        'sanitize_callback' => 'abaek_sanitize_checkbox'
    ));
    
    $wp_customize->add_control('abaek_dable_home_enabled', array(
        'label' => '홈 광고 활성화',
        'section' => 'abaek_dable_ads',
        'type' => 'checkbox'
    ));
    
    $wp_customize->add_setting('abaek_dable_related_enabled', array(
        'default' => true,
        'sanitize_callback' => 'abaek_sanitize_checkbox'
    ));
    
    $wp_customize->add_control('abaek_dable_related_enabled', array(
        'label' => '관련 글 광고 활성화',
        'section' => 'abaek_dable_ads',
        'type' => 'checkbox'
    ));
}
add_action('customize_register', 'abaek_customizer_settings');

// Sanitize 함수
function abaek_sanitize_js($input) {
    return $input; // 스크립트 허용
}

function abaek_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

// ========================================
// 3. 홈페이지 - 2개 글마다 광고 삽입
// ========================================
function abaek_insert_home_ads($query) {
    // 메인 쿼리이고 홈페이지일 때만
    if (!is_admin() && $query->is_main_query() && is_home()) {
        $query->set('posts_per_page', 10); // 페이지당 10개 글
    }
}
add_action('pre_get_posts', 'abaek_insert_home_ads');

// 포스트 리스트에 광고 삽입 함수
function abaek_posts_with_ads($posts) {
    if (!is_home() || !get_theme_mod('abaek_dable_home_enabled', true)) {
        return $posts;
    }
    
    $ad_code = get_theme_mod('abaek_dable_home_code', '');
    if (empty($ad_code)) {
        return $posts;
    }
    
    $new_posts = array();
    $count = 0;
    
    foreach ($posts as $post) {
        $new_posts[] = $post;
        $count++;
        
        // 2개마다 광고 삽입
        if ($count % 2 === 0) {
            $ad_post = new stdClass();
            $ad_post->is_ad = true;
            $ad_post->ad_code = $ad_code;
            $new_posts[] = $ad_post;
        }
    }
    
    return $new_posts;
}

// ========================================
// 4. 관련 글 + 데이블 광고 섹션
// ========================================
function abaek_related_posts_with_dable() {
    if (!is_single()) {
        return;
    }
    
    global $post;
    
    // 관련 글 가져오기 (같은 카테고리)
    $categories = get_the_category($post->ID);
    if (empty($categories)) {
        return;
    }
    
    $category_ids = array();
    foreach ($categories as $category) {
        $category_ids[] = $category->term_id;
    }
    
    $args = array(
        'category__in' => $category_ids,
        'post__not_in' => array($post->ID),
        'posts_per_page' => 6,
        'orderby' => 'rand'
    );
    
    $related_query = new WP_Query($args);
    
    if (!$related_query->have_posts()) {
        wp_reset_postdata();
        return;
    }
    
    ?>
    <div class="related-posts-section">
        <h2 class="section-title">📚 함께 읽으면 좋은 글</h2>
        
        <div class="related-posts-grid">
            <?php
            $count = 0;
            while ($related_query->have_posts()) :
                $related_query->the_post();
                $count++;
                ?>
                <article class="related-post-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('related-post-thumb', array('class' => 'related-post-image')); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>">
                            <div class="related-post-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                        </a>
                    <?php endif; ?>
                    
                    <h3 class="related-post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </article>
                
                <?php
                // 3번째 글 다음에 데이블 광고 삽입
                if ($count === 3 && get_theme_mod('abaek_dable_related_enabled', true)) :
                    $dable_code = get_theme_mod('abaek_dable_related_code', '');
                    if (!empty($dable_code)) :
                ?>
                    <div class="dable-ad-related">
                        <div class="dable-ad-label">Sponsored</div>
                        <?php echo $dable_code; ?>
                    </div>
                <?php
                    endif;
                endif;
                ?>
                
            <?php endwhile; ?>
        </div>
        
        <?php
        // 관련 글 하단에도 광고 추가 (옵션)
        if (get_theme_mod('abaek_dable_related_enabled', true)) :
            $dable_code = get_theme_mod('abaek_dable_related_code', '');
            if (!empty($dable_code)) :
        ?>
            <div class="dable-ad-related" style="margin-top: 30px;">
                <div class="dable-ad-label">추천 콘텐츠</div>
                <?php echo $dable_code; ?>
            </div>
        <?php
            endif;
        endif;
        ?>
    </div>
    <?php
    
    wp_reset_postdata();
}

// ========================================
// 5. 버튼 스타일 최적화
// ========================================
function abaek_optimize_buttons() {
    ?>
    <style>
    /* 모든 링크를 버튼처럼 보이게 */
    .post-content a:not(.wp-block-button__link):not(.abaek-internal-link) {
        color: #667eea;
        font-weight: 600;
        text-decoration: none;
        border-bottom: 2px solid rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
        padding-bottom: 2px;
    }
    
    .post-content a:not(.wp-block-button__link):not(.abaek-internal-link):hover {
        border-bottom-color: #667eea;
        color: #764ba2;
    }
    
    /* CTA 버튼 강조 */
    .wp-block-button__link,
    .abaek-internal-link {
        position: relative;
        overflow: hidden;
    }
    
    .wp-block-button__link::before,
    .abaek-internal-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.3s ease;
    }
    
    .wp-block-button__link:hover::before,
    .abaek-internal-link:hover::before {
        left: 100%;
    }
    
    /* 클릭 유도 애니메이션 */
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    .wp-block-button__link:hover,
    .abaek-internal-link:hover {
        animation: pulse 0.6s ease-in-out;
    }
    </style>
    <?php
}
add_action('wp_head', 'abaek_optimize_buttons');

// ========================================
// 6. 성능 최적화
// ========================================
// 이미지 Lazy Loading
function abaek_lazy_loading($attr, $attachment, $size) {
    $attr['loading'] = 'lazy';
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'abaek_lazy_loading', 10, 3);

// 불필요한 스크립트 제거
function abaek_remove_bloat() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'abaek_remove_bloat', 100);

// ========================================
// 7. SEO 최적화
// ========================================
function abaek_seo_meta() {
    if (is_single()) {
        global $post;
        $excerpt = wp_trim_words(strip_tags($post->post_content), 30, '...');
        ?>
        <meta name="description" content="<?php echo esc_attr($excerpt); ?>">
        <meta property="og:title" content="<?php echo esc_attr(get_the_title()); ?>">
        <meta property="og:description" content="<?php echo esc_attr($excerpt); ?>">
        <?php if (has_post_thumbnail()) : ?>
        <meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url()); ?>">
        <?php endif; ?>
        <meta property="og:type" content="article">
        <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
        <?php
    }
}
add_action('wp_head', 'abaek_seo_meta');

// ========================================
// 8. 클릭 추적 스크립트 (데이블 최적화)
// ========================================
function abaek_click_tracking() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 모든 버튼 클릭 추적
        const buttons = document.querySelectorAll('.wp-block-button__link, .abaek-internal-link, .read-more-btn');
        
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                // 클릭 이벤트 추적 (Google Analytics 등)
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'click', {
                        'event_category': 'Button',
                        'event_label': this.textContent.trim()
                    });
                }
                
                // 시각적 피드백
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 100);
            });
        });
        
        // 광고 노출 추적
        const ads = document.querySelectorAll('.dable-ad-related, .dable-ad-home, .abaek-ad-block');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // 광고 노출 추적
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'ad_impression', {
                            'event_category': 'Advertisement',
                            'event_label': 'Dable Ad View'
                        });
                    }
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        ads.forEach(ad => observer.observe(ad));
    });
    </script>
    <?php
}
add_action('wp_footer', 'abaek_click_tracking');

// ========================================
// 9. 수익 대시보드 (관리자용)
// ========================================
function abaek_revenue_dashboard() {
    add_menu_page(
        '데이블 수익 현황',
        '💰 수익 현황',
        'manage_options',
        'abaek-revenue',
        'abaek_revenue_dashboard_page',
        'dashicons-chart-line',
        3
    );
}
add_action('admin_menu', 'abaek_revenue_dashboard');

function abaek_revenue_dashboard_page() {
    ?>
    <div class="wrap">
        <h1>📊 데이블 광고 수익 현황</h1>
        
        <div class="abaek-dashboard">
            <div class="abaek-card">
                <h2>🎯 최적화 현황</h2>
                <p><strong>홈 광고:</strong> <?php echo get_theme_mod('abaek_dable_home_enabled', true) ? '✅ 활성화' : '❌ 비활성화'; ?></p>
                <p><strong>관련 글 광고:</strong> <?php echo get_theme_mod('abaek_dable_related_enabled', true) ? '✅ 활성화' : '❌ 비활성화'; ?></p>
                <p><strong>총 게시글:</strong> <?php echo wp_count_posts()->publish; ?>개</p>
            </div>
            
            <div class="abaek-card">
                <h2>💡 수익 극대화 팁</h2>
                <ul>
                    <li>✅ 일 방문자 5,000명 이상 유지</li>
                    <li>✅ 고품질 콘텐츠 정기 업로드</li>
                    <li>✅ 내부 링크로 체류 시간 증가</li>
                    <li>✅ 모바일 최적화 확인</li>
                    <li>✅ 광고 클릭률 50%+ 목표</li>
                </ul>
            </div>
            
            <div class="abaek-card">
                <h2>🚀 다음 단계</h2>
                <p><a href="<?php echo admin_url('customize.php?autofocus[section]=abaek_dable_ads'); ?>" class="button button-primary">광고 설정하기</a></p>
                <p><a href="<?php echo admin_url('edit.php'); ?>" class="button">콘텐츠 관리</a></p>
            </div>
        </div>
        
        <style>
        .abaek-dashboard {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        
        .abaek-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .abaek-card h2 {
            margin-top: 0;
            font-size: 18px;
        }
        
        .abaek-card ul {
            list-style: none;
            padding: 0;
        }
        
        .abaek-card li {
            margin-bottom: 8px;
        }
        </style>
    </div>
    <?php
}

// ========================================
// 10. 위젯 영역
// ========================================
function abaek_widgets_init() {
    register_sidebar(array(
        'name' => '사이드바',
        'id' => 'sidebar-1',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'abaek_widgets_init');

// ========================================
// 11. 소셜 공유 버튼
// ========================================
function abaek_social_share_buttons() {
    $url = urlencode(get_permalink());
    $title = urlencode(get_the_title());
    
    $buttons = '<div class="share-buttons">';
    
    // 페이스북
    $buttons .= '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '" target="_blank" rel="noopener" class="share-btn facebook">
        <span>📘</span> 페이스북
    </a>';
    
    // 트위터
    $buttons .= '<a href="https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title . '" target="_blank" rel="noopener" class="share-btn twitter">
        <span>🐦</span> 트위터
    </a>';
    
    // 카카오톡
    $buttons .= '<a href="https://story.kakao.com/share?url=' . $url . '" target="_blank" rel="noopener" class="share-btn kakao">
        <span>💬</span> 카카오톡
    </a>';
    
    // 네이버 블로그
    $buttons .= '<a href="https://share.naver.com/web/shareView.nhn?url=' . $url . '&title=' . $title . '" target="_blank" rel="noopener" class="share-btn naver">
        <span>N</span> 네이버
    </a>';
    
    // URL 복사
    $buttons .= '<a href="#" class="share-btn copy">
        <span>🔗</span> URL 복사
    </a>';
    
    $buttons .= '</div>';
    
    return $buttons;
}

// ========================================
// 12. 조회수 기능
// ========================================
function abaek_get_post_views() {
    $count = get_post_meta(get_the_ID(), 'abaek_post_views', true);
    return $count ? number_format($count) : '0';
}

function abaek_set_post_views($post_id) {
    $count = get_post_meta($post_id, 'abaek_post_views', true);
    if ($count === '') {
        delete_post_meta($post_id, 'abaek_post_views');
        add_post_meta($post_id, 'abaek_post_views', 1);
    } else {
        $count++;
        update_post_meta($post_id, 'abaek_post_views', $count);
    }
}

// ========================================
// 13. 기본 메뉴 (폴백)
// ========================================
function abaek_default_menu() {
    echo '<ul>';
    echo '<li><a href="' . home_url('/') . '">홈</a></li>';
    
    $categories = get_categories(array('number' => 5));
    foreach ($categories as $category) {
        echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
    }
    
    echo '</ul>';
}

// ========================================
// 14. 발췌문 길이 조정
// ========================================
function abaek_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'abaek_excerpt_length');

function abaek_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'abaek_excerpt_more');

// ========================================
// 15. 구글 애널리틱스 (선택적)
// ========================================
function abaek_google_analytics() {
    $ga_code = get_theme_mod('abaek_ga_code', '');
    
    if (!empty($ga_code) && !is_user_logged_in()) {
        echo $ga_code;
    }
}
add_action('wp_head', 'abaek_google_analytics');

// GA 설정 추가
function abaek_ga_customizer($wp_customize) {
    $wp_customize->add_section('abaek_analytics', array(
        'title' => '📊 분석 도구',
        'priority' => 35,
    ));
    
    $wp_customize->add_setting('abaek_ga_code', array(
        'default' => '',
        'sanitize_callback' => 'abaek_sanitize_js'
    ));
    
    $wp_customize->add_control('abaek_ga_code', array(
        'label' => 'Google Analytics 코드',
        'section' => 'abaek_analytics',
        'type' => 'textarea',
        'description' => 'GA4 측정 코드를 붙여넣으세요'
    ));
}
add_action('customize_register', 'abaek_ga_customizer');
