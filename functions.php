<?php
/**
 * 홈페이지형 글쓰기 스킨 - Functions
 * Theme Name: Aros Post Skin
 * Version: 1.1
 */

// 테마 기본 설정
function aros_post_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus(array('tab-menu' => '탭 메뉴'));
}
add_action('after_setup_theme', 'aros_post_setup');

// 스타일 및 스크립트 등록
function aros_post_scripts() {
    wp_enqueue_style('noto-sans-kr', 'https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700&display=swap');
    wp_enqueue_style('aros-post-style', get_stylesheet_uri(), array(), '1.1.0'); // 버전 업데이트
    wp_enqueue_script('aros-post-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'aros_post_scripts');

// -------------------------------------------------------
// [핵심] 정보 카드 숏코드 생성 (글쓰기 문제 해결)
// 사용법: [info_card title="신청방법" sub1="자격요건" desc1="설명..." doc="신분증,등본" btn_text="신청하기" btn_url="링크"]
// -------------------------------------------------------
function aros_info_card_shortcode($atts) {
    $a = shortcode_atts(array(
        'title' => '신청 안내',
        'sub1'  => '', 'desc1' => '',
        'sub2'  => '', 'desc2' => '',
        'sub3'  => '', 'desc3' => '',
        'doc'   => '', // 준비서류
        'btn_text' => '공식 홈페이지 바로가기',
        'btn_url'  => '#'
    ), $atts);

    ob_start();
    ?>
    <div class="aros-gray-card">
        <h3 class="benefit-title">📌 <?php echo esc_html($a['title']); ?></h3>

        <?php if($a['sub1']): ?>
        <div class="requirement-item">
            <p class="requirement-title">✔️ <?php echo esc_html($a['sub1']); ?></p>
            <p class="requirement-desc"><?php echo nl2br(esc_html($a['desc1'])); ?></p>
        </div>
        <?php endif; ?>

        <?php if($a['sub2']): ?>
        <div class="requirement-item">
            <p class="requirement-title">✔️ <?php echo esc_html($a['sub2']); ?></p>
            <p class="requirement-desc"><?php echo nl2br(esc_html($a['desc2'])); ?></p>
        </div>
        <?php endif; ?>

        <?php if($a['sub3']): ?>
        <div class="requirement-item">
            <p class="requirement-title">✔️ <?php echo esc_html($a['sub3']); ?></p>
            <p class="requirement-desc"><?php echo nl2br(esc_html($a['desc3'])); ?></p>
        </div>
        <?php endif; ?>

        <?php if($a['doc']): ?>
        <div class="highlight-box">
            <p class="documents-title">📋 준비서류</p>
            <p class="documents-list"><?php echo nl2br(esc_html($a['doc'])); ?></p>
        </div>
        <?php endif; ?>

        <?php if($a['btn_url'] && $a['btn_url'] !== '#'): ?>
        <a href="<?php echo esc_url($a['btn_url']); ?>" class="apply-button" target="_blank">
            <?php echo esc_html($a['btn_text']); ?> 👉
        </a>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('info_card', 'aros_info_card_shortcode');

// 커스터마이저 (기존 유지)
function aros_post_customize_register($wp_customize) {
    // 헤더 설정
    $wp_customize->add_section('aros_header', array('title' => '헤더 설정'));
    $wp_customize->add_setting('header_logo');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_logo', array('label' => '로고', 'section' => 'aros_header')));
    $wp_customize->add_setting('site_title', array('default' => '블로그 제목'));
    $wp_customize->add_control('site_title', array('label' => '사이트 제목', 'section' => 'aros_header', 'type' => 'text'));

    // 푸터 설정
    $wp_customize->add_section('aros_footer', array('title' => '푸터 설정'));
    $wp_customize->add_setting('footer_brand', array('default' => '굿인포'));
    $wp_customize->add_control('footer_brand', array('label' => '브랜드명', 'section' => 'aros_footer', 'type' => 'text'));
}
add_action('customize_register', 'aros_post_customize_register');
