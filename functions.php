<?php
/**
 * 홈페이지형 글쓰기 스킨 - Functions
 * Theme Name: Aros Post Skin
 * Version: 1.0
 */

// 테마 기본 설정
function aros_post_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');
    
    // 메뉴 등록
    register_nav_menus(array(
        'tab-menu' => '탭 메뉴'
    ));
}
add_action('after_setup_theme', 'aros_post_setup');

// 스타일 및 스크립트 등록
function aros_post_scripts() {
    wp_enqueue_style('noto-sans-kr', 'https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700&display=swap');
    wp_enqueue_style('aros-post-style', get_stylesheet_uri());
    wp_enqueue_script('aros-post-script', get_template_directory_uri() . '/js/main.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'aros_post_scripts');

// 테마 커스터마이저
function aros_post_customize_register($wp_customize) {
    // 로고 설정
    $wp_customize->add_section('aros_header', array(
        'title' => '헤더 설정',
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('header_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_logo', array(
        'label' => '로고 이미지',
        'section' => 'aros_header',
        'settings' => 'header_logo',
    )));
    
    $wp_customize->add_setting('site_title', array(
        'default' => '오늘의아파트',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('site_title', array(
        'label' => '사이트 제목',
        'section' => 'aros_header',
        'type' => 'text',
    ));
    
    // 탭 메뉴 설정
    $wp_customize->add_section('aros_tabs', array(
        'title' => '탭 메뉴 설정',
        'priority' => 31,
    ));
    
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("tab{$i}_text", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("tab{$i}_text", array(
            'label' => "탭 {$i} 텍스트",
            'section' => 'aros_tabs',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting("tab{$i}_url", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control("tab{$i}_url", array(
            'label' => "탭 {$i} URL",
            'section' => 'aros_tabs',
            'type' => 'url',
        ));
        
        $wp_customize->add_setting("tab{$i}_hash", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("tab{$i}_hash", array(
            'label' => "탭 {$i} Hash (예: aros1)",
            'section' => 'aros_tabs',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting("tab{$i}_active", array(
            'default' => false,
            'sanitize_callback' => 'wp_validate_boolean',
        ));
        
        $wp_customize->add_control("tab{$i}_active", array(
            'label' => "탭 {$i} 활성화",
            'section' => 'aros_tabs',
            'type' => 'checkbox',
        ));
    }
    
    // 애드센스 설정
    $wp_customize->add_section('aros_adsense', array(
        'title' => '애드센스 설정',
        'priority' => 32,
    ));
    
    $wp_customize->add_setting('adsense_client', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('adsense_client', array(
        'label' => '애드센스 클라이언트 ID (ca-pub-xxxxx)',
        'section' => 'aros_adsense',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('adsense_slot', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('adsense_slot', array(
        'label' => '애드센스 슬롯 ID',
        'section' => 'aros_adsense',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('adsense_blocker_url', array(
        'default' => 'https://aros100.com',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('adsense_blocker_url', array(
        'label' => '무효 트래픽 방지 리다이렉트 URL',
        'section' => 'aros_adsense',
        'type' => 'url',
    ));
    
    // 푸터 설정
    $wp_customize->add_section('aros_footer', array(
        'title' => '푸터 설정',
        'priority' => 33,
    ));
    
    $wp_customize->add_setting('footer_brand', array(
        'default' => '굿인포',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_brand', array(
        'label' => '브랜드명',
        'section' => 'aros_footer',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('footer_address', array(
        'default' => '대전광역시동구동부로10번길55',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_address', array(
        'label' => '사업자 주소',
        'section' => 'aros_footer',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('footer_business_number', array(
        'default' => '784-15-02513',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_business_number', array(
        'label' => '사업자 번호',
        'section' => 'aros_footer',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('footer_creator', array(
        'default' => '아로스',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_creator', array(
        'label' => '제작자',
        'section' => 'aros_footer',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('footer_website', array(
        'default' => 'https://aros100.com',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('footer_website', array(
        'label' => '홈페이지 URL',
        'section' => 'aros_footer',
        'type' => 'url',
    ));
    
    $wp_customize->add_setting('footer_copyright', array(
        'default' => 'Copyrights © 2020 All Rights Reserved by (주)아백',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_copyright', array(
        'label' => '저작권 문구',
        'section' => 'aros_footer',
        'type' => 'text',
    ));
}
add_action('customize_register', 'aros_post_customize_register');

// Gutenberg 블록 에디터에 커스텀 카드 블록 추가
function aros_register_custom_blocks() {
    // 스크립트 등록
    wp_register_script(
        'aros-editor-script',
        get_template_directory_uri() . '/js/editor-blocks.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components'),
        '1.0'
    );
    
    // 에디터 스타일
    wp_register_style(
        'aros-editor-style',
        get_template_directory_uri() . '/css/editor-style.css',
        array('wp-edit-blocks'),
        '1.0'
    );
    
    // 프론트엔드 스타일
    wp_register_style(
        'aros-block-style',
        get_template_directory_uri() . '/css/block-style.css',
        array(),
        '1.0'
    );
    
    // 블록 카테고리 등록
    register_block_type('aros/custom-blocks', array(
        'editor_script' => 'aros-editor-script',
        'editor_style' => 'aros-editor-style',
        'style' => 'aros-block-style',
    ));
}
add_action('init', 'aros_register_custom_blocks');

// 커스텀 블록 카테고리 추가
function aros_block_categories($categories) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'aros-blocks',
                'title' => 'Aros 카드 블록',
                'icon' => 'admin-customizer',
            ),
        )
    );
}
add_filter('block_categories_all', 'aros_block_categories', 10, 2);

// 관리자 페이지에 커스텀 메뉴 추가
function aros_add_admin_menu() {
    add_menu_page(
        'Aros 글 생성기',
        'Aros 글 생성기',
        'edit_posts',
        'aros-post-generator',
        'aros_post_generator_page',
        'dashicons-edit-page',
        20
    );
}
add_action('admin_menu', 'aros_add_admin_menu');

// 글 생성기 페이지
function aros_post_generator_page() {
    ?>
    <div class="wrap">
        <h1>Aros 홈페이지형 글 생성기</h1>
        <p>아래 양식을 채워서 자동으로 홈페이지형 글을 생성하세요.</p>
        
        <form method="post" action="">
            <?php wp_nonce_field('aros_generate_post', 'aros_nonce'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="post_title">글 제목</label></th>
                    <td><input type="text" id="post_title" name="post_title" class="regular-text" required></td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="main_card_title">메인 카드 제목</label></th>
                    <td><input type="text" id="main_card_title" name="main_card_title" class="regular-text" value="근로장려금 신청"></td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="main_card_subtitle">메인 카드 부제목</label></th>
                    <td><textarea id="main_card_subtitle" name="main_card_subtitle" rows="3" class="large-text">지금부터 알아야 330만원 받을수 있습니다</textarea></td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="button_section_title">버튼 섹션 제목</label></th>
                    <td><input type="text" id="button_section_title" name="button_section_title" class="regular-text" value="최대 460만원, 지금 바로 신청!"></td>
                </tr>
                
                <tr>
                    <th scope="row"><label>버튼 1</label></th>
                    <td>
                        <input type="text" name="button1_title" placeholder="제목" class="regular-text" value="온라인"><br>
                        <input type="text" name="button1_subtitle" placeholder="부제목" class="regular-text" value="신청gogo"><br>
                        <input type="url" name="button1_url" placeholder="URL" class="regular-text"><br>
                        <input type="text" name="button1_icon" placeholder="아이콘 (이모지)" value="🔥">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label>버튼 2</label></th>
                    <td>
                        <input type="text" name="button2_title" placeholder="제목" class="regular-text" value="오프라인"><br>
                        <input type="text" name="button2_subtitle" placeholder="부제목" class="regular-text" value="신청하기"><br>
                        <input type="url" name="button2_url" placeholder="URL" class="regular-text"><br>
                        <input type="text" name="button2_icon" placeholder="아이콘 (이모지)" value="✨">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label>버튼 3</label></th>
                    <td>
                        <input type="text" name="button3_title" placeholder="제목" class="regular-text"><br>
                        <input type="text" name="button3_subtitle" placeholder="부제목" class="regular-text"><br>
                        <input type="url" name="button3_url" placeholder="URL" class="regular-text"><br>
                        <input type="text" name="button3_icon" placeholder="아이콘 (이모지)">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="date_card_title">신청기간 카드 제목</label></th>
                    <td><input type="text" id="date_card_title" name="date_card_title" class="regular-text" value="근로장려금 신청기간"></td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="date_range">신청 기간</label></th>
                    <td><input type="text" id="date_range" name="date_range" class="regular-text" value="2025.05.01 ~ 05.31"></td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="info_card_title">안내 카드 제목</label></th>
                    <td><input type="text" id="info_card_title" name="info_card_title" class="regular-text" value="🌏 근로장려금 안내"></td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="info_description">안내 설명</label></th>
                    <td><textarea id="info_description" name="info_description" rows="3" class="large-text">근로장려금을 받을 수 있는 조건을 확인하세요!</textarea></td>
                </tr>
                
                <tr>
                    <th scope="row"><label>요건 1</label></th>
                    <td>
                        <input type="text" name="req1_title" placeholder="요건 제목" class="regular-text" value="1. 소득 요건"><br>
                        <textarea name="req1_desc" placeholder="요건 설명" rows="2" class="large-text">• 가구 합산 연간 소득이 기준 금액 이하인 경우
• 근로, 사업, 기타 소득 포함</textarea>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label>요건 2</label></th>
                    <td>
                        <input type="text" name="req2_title" placeholder="요건 제목" class="regular-text" value="2. 재산 요건"><br>
                        <textarea name="req2_desc" placeholder="요건 설명" rows="2" class="large-text">• 가구 재산 총액이 2억 원 이하
• 주택, 자동차, 금융 자산 등 포함</textarea>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label>요건 3</label></th>
                    <td>
                        <input type="text" name="req3_title" placeholder="요건 제목" class="regular-text" value="3. 지원 내용"><br>
                        <textarea name="req3_desc" placeholder="요건 설명" rows="2" class="large-text">• 최대 지원 금액은 가구 구성과 소득에 따라 결정
• 신청 기간 내 반드시 접수 필요</textarea>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="documents">준비서류</label></th>
                    <td><textarea id="documents" name="documents" rows="3" class="large-text">• 소득금액증명원
• 가족관계증명서
• 혼인관계증명서 (해당자)</textarea></td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="benefit_title">함께보면 좋은 글 제목</label></th>
                    <td><input type="text" id="benefit_title" name="benefit_title" class="regular-text" value="나라에서 주는 용돈 모두 모아보기"></td>
                </tr>
                
                <tr>
                    <th scope="row"><label>추천 링크 1</label></th>
                    <td>
                        <input type="text" name="link1_text" placeholder="텍스트" class="regular-text" value="• 숨은보험금 찾기"><br>
                        <input type="url" name="link1_url" placeholder="URL" class="regular-text"><br>
                        <input type="text" name="link1_icon" placeholder="아이콘" value="💰">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label>추천 링크 2</label></th>
                    <td>
                        <input type="text" name="link2_text" placeholder="텍스트" class="regular-text" value="• 건강보험료 환급금"><br>
                        <input type="url" name="link2_url" placeholder="URL" class="regular-text"><br>
                        <input type="text" name="link2_icon" placeholder="아이콘" value="🏥">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label>추천 링크 3</label></th>
                    <td>
                        <input type="text" name="link3_text" placeholder="텍스트" class="regular-text" value="• 통신비 지원금"><br>
                        <input type="url" name="link3_url" placeholder="URL" class="regular-text"><br>
                        <input type="text" name="link3_icon" placeholder="아이콘" value="🔔">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="bottom_button_text">하단 버튼 텍스트</label></th>
                    <td><input type="text" id="bottom_button_text" name="bottom_button_text" class="regular-text" value="국가 보조금 알아보기"></td>
                </tr>
                
                <tr>
                    <th scope="row"><label for="bottom_button_url">하단 버튼 URL</label></th>
                    <td><input type="url" id="bottom_button_url" name="bottom_button_url" class="regular-text"></td>
                </tr>
            </table>
            
            <?php submit_button('글 생성하기', 'primary', 'generate_post'); ?>
        </form>
    </div>
    <?php
    
    // 폼 제출 처리
    if (isset($_POST['generate_post']) && check_admin_referer('aros_generate_post', 'aros_nonce')) {
        aros_create_generated_post($_POST);
    }
}

// 글 생성 함수
function aros_create_generated_post($data) {
    $content = aros_generate_post_content($data);
    
    $post_data = array(
        'post_title' => sanitize_text_field($data['post_title']),
        'post_content' => $content,
        'post_status' => 'draft',
        'post_type' => 'post',
    );
    
    $post_id = wp_insert_post($post_data);
    
    if ($post_id) {
        echo '<div class="notice notice-success"><p>글이 성공적으로 생성되었습니다! <a href="' . get_edit_post_link($post_id) . '">글 수정하기</a></p></div>';
    } else {
        echo '<div class="notice notice-error"><p>글 생성에 실패했습니다.</p></div>';
    }
}

// 글 내용 생성 함수
function aros_generate_post_content($data) {
    ob_start();
    ?>
<!--상단 탭-->
<div class="tab-wrapper">
    <div class="container">
        <nav class="tab-container">
            <ul class="tabs">
                <?php for ($i = 1; $i <= 3; $i++): 
                    $tab_text = get_theme_mod("tab{$i}_text");
                    $tab_url = get_theme_mod("tab{$i}_url");
                    $tab_hash = get_theme_mod("tab{$i}_hash");
                    $is_active = get_theme_mod("tab{$i}_active");
                    if ($tab_text && $tab_url):
                ?>
                <li class="tab-item">
                    <a class="tab-link <?php echo $is_active ? 'active' : ''; ?>" data-tab="<?php echo esc_attr($tab_hash); ?>" href="<?php echo esc_url($tab_url . '#' . $tab_hash); ?>">
                        <?php echo esc_html($tab_text); ?>
                    </a>
                </li>
                <?php endif; endfor; ?>
            </ul>
        </nav>
    </div>
</div>

<!--1.상단 주목도 높은 메시지-->
<div class="aros-gray-card-center">
    <h3><?php echo esc_html($data['main_card_title']); ?></h3>
    <h2><?php echo esc_html($data['main_card_subtitle']); ?></h2>
</div>

<!--애드센스 광고-->
<?php if (get_theme_mod('adsense_client') && get_theme_mod('adsense_slot')): ?>
<div>
    <script async crossorigin="anonymous" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo esc_attr(get_theme_mod('adsense_client')); ?>"></script>
    <ins class="adsbygoogle" data-ad-client="<?php echo esc_attr(get_theme_mod('adsense_client')); ?>" data-ad-format="auto" data-ad-slot="<?php echo esc_attr(get_theme_mod('adsense_slot')); ?>" data-full-width-responsive="true" style="display: block;"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
</div>
<?php endif; ?>

<!--2.메뉴 버튼들-->
<div class="apply-container">
    <?php for ($i = 1; $i <= 3; $i++):
        if (!empty($data["button{$i}_title"])):
    ?>
    <div class="link-container">
        <a class="custom-link" href="<?php echo esc_url($data["button{$i}_url"]); ?>">
            <div class="button-container">
                <div class="button-content">
                    <span class="button-text"><?php echo esc_html($data["button{$i}_title"] . ' ' . $data["button{$i}_subtitle"]); ?></span>
                    <span>→</span>
                </div>
            </div>
        </a>
    </div>
    <?php endif; endfor; ?>
</div>

<!--3.신청기간 안내 박스-->
<div class="aros-gray-card" style="margin: 20px 0px;">
    <div style="align-items: center; display: flex; justify-content: space-between;">
        <div style="flex: 3 1 0%;">
            <h3><?php echo esc_html($data['date_card_title']); ?></h3>
            <p class="apply-date-text"><?php echo esc_html($data['date_range']); ?></p>
            <p class="apply-text">접수기간 놓치지 않도록<br>실시간으로 알려드려요! 📱</p>
        </div>
        <div style="flex: 1 1 0%; text-align: right;">
            <div style="font-size: 40px;">📅</div>
        </div>
    </div>
</div>

<!--4.상품 설명-->
<div class="aros-gray-card">
    <h3><?php echo esc_html($data['info_card_title']); ?></h3>
    <p class="description"><?php echo esc_html($data['info_description']); ?></p>
    
    <div class="highlight-box requirements">
        <?php for ($i = 1; $i <= 3; $i++):
            if (!empty($data["req{$i}_title"])):
        ?>
        <div class="requirement-item">
            <p class="requirement-title"><?php echo esc_html($data["req{$i}_title"]); ?></p>
            <p class="requirement-desc"><?php echo nl2br(esc_html($data["req{$i}_desc"])); ?></p>
        </div>
        <?php endif; endfor; ?>
    </div>
    
    <div class="highlight-box documents">
        <p class="documents-title">📋 준비서류</p>
        <p class="documents-list"><?php echo nl2br(esc_html($data['documents'])); ?></p>
    </div>
</div>

<!--5. 함께보면 좋은 글-->
<div class="aros-gray-card benefit-card">
    <h3 class="benefit-title">
        <span class="icon">🎯</span>
        <?php echo esc_html($data['benefit_title']); ?>
    </h3>
    
    <div class="benefit-list">
        <?php for ($i = 1; $i <= 3; $i++):
            if (!empty($data["link{$i}_text"])):
        ?>
        <a href="<?php echo esc_url($data["link{$i}_url"]); ?>">
            <div class="benefit-item">
                <span class="benefit-text"><?php echo esc_html($data["link{$i}_text"]); ?></span>
                <span><?php echo esc_html($data["link{$i}_icon"]); ?></span>
            </div>
        </a>
        <?php endif; endfor; ?>
    </div>

    <a href="<?php echo esc_url($data['bottom_button_url']); ?>">
        <button class="bottom-button">
            <span><?php echo esc_html($data['bottom_button_text']); ?></span>
            <span>→</span>
        </button>
    </a>
</div>
    <?php
    return ob_get_clean();
}
