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
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // 메뉴 등록
    register_nav_menus(array(
        'tab-menu' => '탭 메뉴'
    ));
}
add_action('after_setup_theme', 'aros_post_setup');

// 스타일 및 스크립트 등록
function aros_post_scripts() {
    wp_enqueue_style('noto-sans-kr', 'https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700&display=swap');
    wp_enqueue_style('aros-post-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_script('aros-post-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
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
            'default' => "aros{$i}",
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("tab{$i}_hash", array(
            'label' => "탭 {$i} Hash",
            'description' => '예: aros1',
            'section' => 'aros_tabs',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting("tab{$i}_active", array(
            'default' => ($i === 1),
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
        'label' => '애드센스 클라이언트 ID',
        'description' => 'ca-pub-xxxxx 형식',
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
    // 폼 제출 처리
    if (isset($_POST['generate_post']) && check_admin_referer('aros_generate_post', 'aros_nonce')) {
        aros_create_generated_post($_POST);
    }
    ?>
    <script src="https://js.puter.com/v2/"></script>
    <div class="wrap">
        <h1>Aros 홈페이지형 AI 글 생성기</h1>
        <p>제목과 링크 정보만 입력하세요. 나머지는 AI가 자동으로 작성해줍니다.</p>
        
        <form method="post" action="" id="aros-ai-form">
            <?php wp_nonce_field('aros_generate_post', 'aros_nonce'); ?>
            
            <div style="background: #fff; padding: 20px; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); margin-bottom: 20px;">
                <h3>📝 기본 정보 입력</h3>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="post_title">글 제목 *</label></th>
                        <td><input type="text" id="post_title" name="post_title" class="regular-text" placeholder="예: 2025년 근로장려금 신청방법" required></td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><label>버튼 1</label></th>
                        <td>
                            <input type="text" name="button1_title" placeholder="제목 (예: 온라인)" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="text" name="button1_subtitle" placeholder="부제목 (예: 신청바로가기)" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="url" name="button1_url" placeholder="URL" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="text" name="button1_icon" placeholder="아이콘 (예: 🔥)" class="regular-text" value="🔥">
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><label>버튼 2</label></th>
                        <td>
                            <input type="text" name="button2_title" placeholder="제목" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="text" name="button2_subtitle" placeholder="부제목" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="url" name="button2_url" placeholder="URL" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="text" name="button2_icon" placeholder="아이콘" class="regular-text" value="✨">
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><label>버튼 3</label></th>
                        <td>
                            <input type="text" name="button3_title" placeholder="제목" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="text" name="button3_subtitle" placeholder="부제목" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="url" name="button3_url" placeholder="URL" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="text" name="button3_icon" placeholder="아이콘" class="regular-text" value="📝">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label>추천 링크 1</label></th>
                        <td>
                            <input type="text" name="link1_text" placeholder="텍스트" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="url" name="link1_url" placeholder="URL" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="text" name="link1_icon" placeholder="아이콘" class="regular-text" value="💰">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label>추천 링크 2</label></th>
                        <td>
                            <input type="text" name="link2_text" placeholder="텍스트" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="url" name="link2_url" placeholder="URL" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="text" name="link2_icon" placeholder="아이콘" class="regular-text" value="🏥">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label>추천 링크 3</label></th>
                        <td>
                            <input type="text" name="link3_text" placeholder="텍스트" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="url" name="link3_url" placeholder="URL" class="regular-text" style="margin-bottom:5px;"><br>
                            <input type="text" name="link3_icon" placeholder="아이콘" class="regular-text" value="🔔">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="bottom_button_text">하단 버튼</label></th>
                        <td>
                            <input type="text" id="bottom_button_text" name="bottom_button_text" class="regular-text" value="자세히 알아보기" placeholder="버튼 텍스트" style="margin-bottom:5px;"><br>
                            <input type="url" id="bottom_button_url" name="bottom_button_url" class="regular-text" placeholder="버튼 URL">
                        </td>
                    </tr>
                </table>
            </div>
            
            <input type="hidden" id="main_card_title" name="main_card_title">
            <input type="hidden" id="main_card_subtitle" name="main_card_subtitle">
            <input type="hidden" id="button_section_title" name="button_section_title">
            <input type="hidden" id="date_card_title" name="date_card_title">
            <input type="hidden" id="date_range" name="date_range">
            <input type="hidden" id="info_card_title" name="info_card_title">
            <input type="hidden" id="info_description" name="info_description">
            <input type="hidden" id="req1_title" name="req1_title">
            <input type="hidden" id="req1_desc" name="req1_desc">
            <input type="hidden" id="req2_title" name="req2_title">
            <input type="hidden" id="req2_desc" name="req2_desc">
            <input type="hidden" id="req3_title" name="req3_title">
            <input type="hidden" id="req3_desc" name="req3_desc">
            <input type="hidden" id="documents" name="documents">
            <input type="hidden" id="benefit_title" name="benefit_title">

            <div style="margin-top: 20px;">
                <button type="button" id="ai-generate-btn" class="button button-primary button-large" style="width: 100%; height: 50px; font-size: 16px;">
                    ✨ AI로 내용 생성 및 글 작성 완료
                </button>
                <div id="loading-msg" style="display:none; text-align:center; margin-top:10px; color: #2271b1; font-weight:bold;">
                    AI가 글 내용을 작성중입니다... (약 5~10초 소요)
                </div>
                <input type="submit" name="generate_post" id="real-submit-btn" style="display:none;">
            </div>
        </form>
    </div>

    <script>
    document.getElementById('ai-generate-btn').addEventListener('click', async function() {
        const title = document.getElementById('post_title').value;
        if (!title) {
            alert('글 제목을 입력해주세요.');
            document.getElementById('post_title').focus();
            return;
        }

        // 로딩 표시
        const btn = this;
        const loading = document.getElementById('loading-msg');
        btn.disabled = true;
        btn.style.opacity = '0.7';
        loading.style.display = 'block';

        try {
            // Puter AI 프롬프트 생성
            const prompt = `
                너는 블로그 콘텐츠 생성 전문가야. 아래 주제에 맞춰서 정보성 블로그 글에 들어갈 내용을 JSON 형식으로 생성해줘.
                
                주제: ${title}

                다음 필드들에 들어갈 내용을 한국어로 아주 자연스럽고 매력적으로 작성해줘.
                필수 반환 필드 (JSON Key):
                1. main_card_title: (짧은 제목, 예: 근로장려금 신청)
                2. main_card_subtitle: (클릭을 유도하는 부제목, 예: 지금부터 알아야 330만원 받을수 있습니다)
                3. button_section_title: (버튼 섹션 위의 문구, 예: 최대 460만원, 지금 바로 신청!)
                4. date_card_title: (날짜 카드 제목, 예: 신청기간)
                5. date_range: (가상의 또는 현실적인 기간, 예: 2025.05.01 ~ 05.31)
                6. info_card_title: (안내 카드 제목, 예: 🌏 상세 안내)
                7. info_description: (한 줄 요약 설명)
                8. req1_title: (자격요건 1 제목, 예: 1. 소득 요건)
                9. req1_desc: (자격요건 1 설명, 줄바꿈은 \\n 사용)
                10. req2_title: (자격요건 2 제목)
                11. req2_desc: (자격요건 2 설명)
                12. req3_title: (자격요건 3 제목)
                13. req3_desc: (자격요건 3 설명)
                14. documents: (필요 서류 목록, 불렛포인트 • 사용해서 줄바꿈)
                15. benefit_title: (혜택 섹션 제목, 예: 함께보면 좋은 글)

                응답은 오직 JSON 포맷만 출력해. 마크다운 코드블럭 없이 순수 JSON 문자열만 줘.
            `;

            const response = await puter.ai.chat(prompt);
            
            // 응답 처리 (JSON 파싱)
            let jsonStr = response.message.content;
            // 혹시 모를 마크다운 제거
            jsonStr = jsonStr.replace(/```json/g, '').replace(/```/g, '').trim();
            
            const data = JSON.parse(jsonStr);

            // Hidden Field 채우기
            document.getElementById('main_card_title').value = data.main_card_title || '안내';
            document.getElementById('main_card_subtitle').value = data.main_card_subtitle || title;
            document.getElementById('button_section_title').value = data.button_section_title || '지금 바로 확인하세요';
            document.getElementById('date_card_title').value = data.date_card_title || '신청 기간';
            document.getElementById('date_range').value = data.date_range || '별도 공지 시까지';
            document.getElementById('info_card_title').value = data.info_card_title || '상세 안내';
            document.getElementById('info_description').value = data.info_description || '자세한 내용을 확인하세요.';
            document.getElementById('req1_title').value = data.req1_title || '조건 1';
            document.getElementById('req1_desc').value = data.req1_desc || '';
            document.getElementById('req2_title').value = data.req2_title || '조건 2';
            document.getElementById('req2_desc').value = data.req2_desc || '';
            document.getElementById('req3_title').value = data.req3_title || '조건 3';
            document.getElementById('req3_desc').value = data.req3_desc || '';
            document.getElementById('documents').value = data.documents || '';
            document.getElementById('benefit_title').value = data.benefit_title || '함께 보면 좋은 글';

            // 폼 제출
            document.getElementById('real-submit-btn').click();

        } catch (error) {
            console.error(error);
            alert('AI 생성 중 오류가 발생했습니다. 다시 시도해주시거나 수동으로 입력해주세요.\n' + error.message);
            loading.style.display = 'none';
            btn.disabled = false;
            btn.style.opacity = '1';
        }
    });
    </script>
    <?php
}

// 글 생성 함수
function aros_create_generated_post($data) {
    $content = aros_generate_post_content($data);
    
    $post_data = array(
        'post_title' => sanitize_text_field($data['post_title']),
        'post_content' => $content,
        'post_status' => 'draft',
        'post_type' => 'post',
        'post_author' => get_current_user_id(),
    );
    
    $post_id = wp_insert_post($post_data);
    
    if ($post_id && !is_wp_error($post_id)) {
        echo '<div class="notice notice-success is-dismissible"><p>글이 성공적으로 생성되었습니다! <a href="' . get_edit_post_link($post_id) . '">글 수정하기</a> | <a href="' . get_permalink($post_id) . '">미리보기</a></p></div>';
    } else {
        echo '<div class="notice notice-error is-dismissible"><p>글 생성에 실패했습니다.</p></div>';
    }
}

// 글 내용 생성 함수
function aros_generate_post_content($data) {
    ob_start();
    ?>
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

<div class="aros-gray-card-center">
    <h3><?php echo esc_html($data['main_card_title']); ?></h3>
    <h2><?php echo esc_html($data['main_card_subtitle']); ?></h2>
</div>

<?php if (get_theme_mod('adsense_client') && get_theme_mod('adsense_slot')): ?>
<div>
    <script async crossorigin="anonymous" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo esc_attr(get_theme_mod('adsense_client')); ?>"></script>
    <ins class="adsbygoogle" data-ad-client="<?php echo esc_attr(get_theme_mod('adsense_client')); ?>" data-ad-format="auto" data-ad-slot="<?php echo esc_attr(get_theme_mod('adsense_slot')); ?>" data-full-width-responsive="true" style="display: block;"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
</div>
<?php endif; ?>

<?php if($data['button_section_title']): ?>
<div style="text-align: center; margin: 20px 0 10px; font-weight: bold; font-size: 1.1em; color: #333;">
    <?php echo esc_html($data['button_section_title']); ?>
</div>
<?php endif; ?>

<div class="apply-container">
    <?php for ($i = 1; $i <= 3; $i++):
        if (!empty($data["button{$i}_title"])):
    ?>
    <div class="link-container">
        <a class="custom-link" href="<?php echo esc_url($data["button{$i}_url"]); ?>">
            <div class="button-container">
                <div class="button-content">
                    <span class="button-text"><?php echo esc_html($data["button{$i}_title"] . ' ' . $data["button{$i}_subtitle"]); ?></span>
                    <span><?php echo esc_html($data["button{$i}_icon"]); ?> →</span>
                </div>
            </div>
        </a>
    </div>
    <?php endif; endfor; ?>
</div>

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

    <?php if(!empty($data['bottom_button_url'])): ?>
    <a href="<?php echo esc_url($data['bottom_button_url']); ?>">
        <button class="bottom-button">
            <span><?php echo esc_html($data['bottom_button_text']); ?></span>
            <span>→</span>
        </button>
    </a>
    <?php endif; ?>
</div>
    <?php
    return ob_get_clean();
}
