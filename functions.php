<?php
/**
 * 홈페이지 글쓰기 스킨 Functions
 * 커스텀 블록, 숏코드, Puter.js API 연동
 */

// 글쓰기 스킨 관리자 메뉴
function post_skin_admin_menu() {
    add_menu_page(
        '글쓰기 스킨 설정',
        '글쓰기 스킨',
        'manage_options',
        'post-skin-settings',
        'post_skin_settings_page',
        'dashicons-edit-page',
        31
    );
}
add_action('admin_menu', 'post_skin_admin_menu');

// 글쓰기 스킨 설정 페이지
function post_skin_settings_page() {
    if (isset($_POST['post_skin_settings_submit'])) {
        check_admin_referer('post_skin_settings_nonce');
        
        update_option('post_logo_url', esc_url_raw($_POST['logo_url']));
        update_option('post_site_title', sanitize_text_field($_POST['site_title']));
        
        // 탭 URL 저장
        update_option('post_tab1_url', esc_url_raw($_POST['tab1_url']));
        update_option('post_tab2_url', esc_url_raw($_POST['tab2_url']));
        update_option('post_tab3_url', esc_url_raw($_POST['tab3_url']));
        
        // 푸터 설정
        update_option('post_footer_brand', sanitize_text_field($_POST['footer_brand']));
        update_option('post_footer_address', sanitize_text_field($_POST['footer_address']));
        update_option('post_footer_business_number', sanitize_text_field($_POST['footer_business_number']));
        update_option('post_footer_creator', sanitize_text_field($_POST['footer_creator']));
        update_option('post_footer_website_url', esc_url_raw($_POST['footer_website_url']));
        update_option('post_footer_copyright', sanitize_text_field($_POST['footer_copyright']));
        
        echo '<div class="notice notice-success"><p>설정이 저장되었습니다.</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1>글쓰기 스킨 설정</h1>
        
        <form method="post">
            <?php wp_nonce_field('post_skin_settings_nonce'); ?>
            
            <h2>헤더 설정</h2>
            <table class="form-table">
                <tr>
                    <th>로고 URL</th>
                    <td>
                        <input type="url" name="logo_url" 
                               value="<?php echo esc_attr(get_option('post_logo_url', '')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>사이트 제목</th>
                    <td>
                        <input type="text" name="site_title" 
                               value="<?php echo esc_attr(get_option('post_site_title', '오늘의아파트')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
            </table>
            
            <h2>탭 URL 설정</h2>
            <table class="form-table">
                <tr>
                    <th>탭 1 URL (신청방법)</th>
                    <td>
                        <input type="text" name="tab1_url" 
                               value="<?php echo esc_attr(get_option('post_tab1_url', '#')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>탭 2 URL (대상조건)</th>
                    <td>
                        <input type="text" name="tab2_url" 
                               value="<?php echo esc_attr(get_option('post_tab2_url', '#')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>탭 3 URL (지급조회)</th>
                    <td>
                        <input type="text" name="tab3_url" 
                               value="<?php echo esc_attr(get_option('post_tab3_url', '#')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
            </table>
            
            <h2>푸터 설정</h2>
            <table class="form-table">
                <tr>
                    <th>브랜드명</th>
                    <td>
                        <input type="text" name="footer_brand" 
                               value="<?php echo esc_attr(get_option('post_footer_brand', '굿인포')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>사업자 주소</th>
                    <td>
                        <input type="text" name="footer_address" 
                               value="<?php echo esc_attr(get_option('post_footer_address', '')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>사업자 번호</th>
                    <td>
                        <input type="text" name="footer_business_number" 
                               value="<?php echo esc_attr(get_option('post_footer_business_number', '')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>제작자</th>
                    <td>
                        <input type="text" name="footer_creator" 
                               value="<?php echo esc_attr(get_option('post_footer_creator', '아로스')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>홈페이지 URL</th>
                    <td>
                        <input type="url" name="footer_website_url" 
                               value="<?php echo esc_url(get_option('post_footer_website_url', '')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>저작권 문구</th>
                    <td>
                        <input type="text" name="footer_copyright" 
                               value="<?php echo esc_attr(get_option('post_footer_copyright', '')); ?>" 
                               class="large-text">
                    </td>
                </tr>
            </table>
            
            <?php submit_button('설정 저장', 'primary', 'post_skin_settings_submit'); ?>
        </form>
        
        <hr>
        
        <h2>📝 글 작성 가이드</h2>
        <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin-top: 20px;">
            <h3>숏코드 사용법</h3>
            
            <h4>1. 회색 카드 (중앙 정렬)</h4>
            <pre style="background: white; padding: 15px; overflow-x: auto;">[gray_card_center]
&lt;h3&gt;근로장려금 신청&lt;/h3&gt;
&lt;h2&gt;지금부터 알아야 330만원 받을수 있습니다&lt;/h2&gt;
[/gray_card_center]</pre>
            
            <h4>2. 버튼 컨테이너</h4>
            <pre style="background: white; padding: 15px; overflow-x: auto;">[button_container url="https://example.com" text="온라인 신청"]</pre>
            
            <h4>3. 회색 카드 (신청기간)</h4>
            <pre style="background: white; padding: 15px; overflow-x: auto;">[gray_card]
&lt;h3&gt;근로장려금 신청기간&lt;/h3&gt;
&lt;p class="apply-date-text"&gt;2025.05.01 ~ 05.31&lt;/p&gt;
&lt;p class="apply-text"&gt;접수기간 놓치지 않도록&lt;br&gt;실시간으로 알려드려요! 📱&lt;/p&gt;
[/gray_card]</pre>
            
            <h4>4. 혜택 카드</h4>
            <pre style="background: white; padding: 15px; overflow-x: auto;">[benefit_card title="나라에서 주는 용돈 모두 모아보기"]
[benefit_item url="https://example.com/1" text="숨은보험금 찾기" icon="💰"]
[benefit_item url="https://example.com/2" text="건강보험료 환급금" icon="🏥"]
[benefit_item url="https://example.com/3" text="통신비 지원금" icon="🔔"]
[bottom_button url="https://example.com" text="국가 보조금 알아보기"]
[/benefit_card]</pre>
            
            <h4>5. 파란색 카드</h4>
            <pre style="background: white; padding: 15px; overflow-x: auto;">[blue_card title="신청 방법"]
&lt;ul&gt;
  &lt;li&gt;온라인 신청하기&lt;/li&gt;
  &lt;li&gt;오프라인 신청하기&lt;/li&gt;
&lt;/ul&gt;
[/blue_card]</pre>
            
            <h4>6. 흰색 카드</h4>
            <pre style="background: white; padding: 15px; overflow-x: auto;">[white_card title="준비서류"]
&lt;ul&gt;
  &lt;li&gt;소득금액증명원&lt;/li&gt;
  &lt;li&gt;가족관계증명서&lt;/li&gt;
&lt;/ul&gt;
[/white_card]</pre>
            
            <p><strong>💡 팁:</strong> 숏코드를 복사해서 워드프레스 블록 에디터의 "숏코드" 블록에 붙여넣으세요.</p>
        </div>
    </div>
    <?php
}

// ============================================
// 숏코드 등록
// ============================================

// 1. 회색 카드 (중앙 정렬)
function gray_card_center_shortcode($atts, $content = null) {
    return '<div class="aros-gray-card-center">' . do_shortcode($content) . '</div>';
}
add_shortcode('gray_card_center', 'gray_card_center_shortcode');

// 2. 회색 카드
function gray_card_shortcode($atts, $content = null) {
    return '<div class="aros-gray-card">' . do_shortcode($content) . '</div>';
}
add_shortcode('gray_card', 'gray_card_shortcode');

// 3. 파란색 카드
function blue_card_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'title' => ''
    ), $atts);
    
    $output = '<div class="aros-blue-card">';
    if (!empty($atts['title'])) {
        $output .= '<h2>' . esc_html($atts['title']) . '</h2>';
    }
    $output .= do_shortcode($content);
    $output .= '</div>';
    
    return $output;
}
add_shortcode('blue_card', 'blue_card_shortcode');

// 4. 흰색 카드
function white_card_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'title' => ''
    ), $atts);
    
    $output = '<div class="aros-white-card">';
    if (!empty($atts['title'])) {
        $output .= '<h2>' . esc_html($atts['title']) . '</h2>';
    }
    $output .= do_shortcode($content);
    $output .= '</div>';
    
    return $output;
}
add_shortcode('white_card', 'white_card_shortcode');

// 5. 버튼 컨테이너
function button_container_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url' => '#',
        'text' => '클릭하기'
    ), $atts);
    
    return '<div class="apply-container">
        <div class="link-container">
            <a class="custom-link" href="' . esc_url($atts['url']) . '">
                <div class="button-container">
                    <div class="button-content">
                        <span class="button-text">' . esc_html($atts['text']) . '</span>
                        <span>→</span>
                    </div>
                </div>
            </a>
        </div>
    </div>';
}
add_shortcode('button_container', 'button_container_shortcode');

// 6. 혜택 카드 (부모)
function benefit_card_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'title' => '함께 보면 좋은 글'
    ), $atts);
    
    return '<div class="aros-gray-card benefit-card">
        <h3 class="benefit-title">
            <span class="icon">🎯</span>
            ' . esc_html($atts['title']) . '
        </h3>
        <div class="benefit-list">
            ' . do_shortcode($content) . '
        </div>
    </div>';
}
add_shortcode('benefit_card', 'benefit_card_shortcode');

// 7. 혜택 아이템 (자식)
function benefit_item_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url' => '#',
        'text' => '',
        'icon' => '💰'
    ), $atts);
    
    return '<a href="' . esc_url($atts['url']) . '">
        <div class="benefit-item">
            <span class="benefit-text">• ' . esc_html($atts['text']) . '</span>
            <span>' . $atts['icon'] . '</span>
        </div>
    </a>';
}
add_shortcode('benefit_item', 'benefit_item_shortcode');

// 8. 하단 버튼 (혜택 카드용)
function bottom_button_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url' => '#',
        'text' => '더 알아보기'
    ), $atts);
    
    return '<a href="' . esc_url($atts['url']) . '">
        <button class="bottom-button">
            <span>' . esc_html($atts['text']) . '</span>
            <span>→</span>
        </button>
    </a>';
}
add_shortcode('bottom_button', 'bottom_button_shortcode');

// 9. 파란색 버튼
function blue_button_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'url' => '#'
    ), $atts);
    
    return '<div class="aros-blue-button">
        <a href="' . esc_url($atts['url']) . '">
            ' . do_shortcode($content) . '
        </a>
    </div>';
}
add_shortcode('blue_button', 'blue_button_shortcode');

// 10. 회색 버튼
function gray_button_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'url' => '#'
    ), $atts);
    
    return '<div class="aros-gray-button">
        <a href="' . esc_url($atts['url']) . '">
            ' . do_shortcode($content) . '
        </a>
    </div>';
}
add_shortcode('gray_button', 'gray_button_shortcode');

// 광고 숏코드
function ad_container_shortcode($atts, $content = null) {
    return '<div class="ad-container">' . do_shortcode($content) . '</div>';
}
add_shortcode('ad_container', 'ad_container_shortcode');

// ============================================
// Gutenberg 블록 등록
// ============================================

function register_post_skin_blocks() {
    // 회색 카드 블록
    register_block_type('post-skin/gray-card', array(
        'editor_script' => 'post-skin-blocks',
        'render_callback' => function($attributes, $content) {
            return '<div class="aros-gray-card">' . $content . '</div>';
        }
    ));
    
    // 파란색 카드 블록
    register_block_type('post-skin/blue-card', array(
        'editor_script' => 'post-skin-blocks',
        'render_callback' => function($attributes, $content) {
            return '<div class="aros-blue-card">' . $content . '</div>';
        }
    ));
    
    // 버튼 블록
    register_block_type('post-skin/button', array(
        'editor_script' => 'post-skin-blocks',
        'attributes' => array(
            'url' => array('type' => 'string', 'default' => ''),
            'text' => array('type' => 'string', 'default' => '클릭하기')
        ),
        'render_callback' => function($attributes) {
            return button_container_shortcode($attributes);
        }
    ));
}
add_action('init', 'register_post_skin_blocks');

// 블록 에디터 스크립트 추가
function enqueue_post_skin_block_editor_assets() {
    wp_enqueue_script(
        'post-skin-blocks',
        get_template_directory_uri() . '/js/post-skin-blocks.js',
        array('wp-blocks', 'wp-element', 'wp-editor'),
        filemtime(get_template_directory() . '/js/post-skin-blocks.js')
    );
}
add_action('enqueue_block_editor_assets', 'enqueue_post_skin_block_editor_assets');

// ============================================
// Puter.js API 연동
// ============================================

function enqueue_puter_post_js() {
    if (is_singular('post')) {
        wp_enqueue_script('puter-js', 'https://js.puter.com/v2/', array(), null, true);
        
        wp_add_inline_script('puter-js', "
            document.addEventListener('DOMContentLoaded', async function() {
                try {
                    // Puter.js를 사용한 동적 콘텐츠 로딩
                    // 예: 외부 데이터 가져오기, 파일 업로드 등
                    
                    console.log('Puter.js 초기화 완료');
                } catch (error) {
                    console.error('Puter.js 오류:', error);
                }
            });
        ");
    }
}
add_action('wp_enqueue_scripts', 'enqueue_puter_post_js');

// ============================================
// 클래식 에디터 버튼 추가
// ============================================

function add_post_skin_tinymce_buttons() {
    add_filter('mce_buttons', 'register_post_skin_tinymce_buttons');
    add_filter('mce_external_plugins', 'add_post_skin_tinymce_plugin');
}
add_action('init', 'add_post_skin_tinymce_buttons');

function register_post_skin_tinymce_buttons($buttons) {
    array_push($buttons, 'post_skin_gray_card', 'post_skin_blue_card', 'post_skin_button');
    return $buttons;
}

function add_post_skin_tinymce_plugin($plugin_array) {
    $plugin_array['post_skin_buttons'] = get_template_directory_uri() . '/js/post-skin-tinymce.js';
    return $plugin_array;
}

// ============================================
// 관리자 CSS 추가 (프리뷰용)
// ============================================

function post_skin_admin_css() {
    echo '<style>
        .aros-gray-card,
        .aros-blue-card,
        .aros-white-card {
            border-radius: 16px;
            padding: 20px;
            margin: 15px 0;
        }
        .aros-gray-card {
            background: rgb(248, 249, 250);
        }
        .aros-blue-card {
            background: #EEF6FF;
        }
        .aros-white-card {
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>';
}
add_action('admin_head', 'post_skin_admin_css');
?>
<?php
/**
 * 홈페이지 목차 스킨 Functions
 * 커스텀 포스트 타입, 옵션 페이지, Puter.js API 연동
 */

// 테마 설정
function index_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'index_theme_setup');

// 커스텀 포스트 타입: 섹션 (각 섹션의 카드들)
function create_index_section_post_type() {
    register_post_type('index_section',
        array(
            'labels' => array(
                'name' => '목차 섹션',
                'singular_name' => '섹션',
                'add_new' => '새 섹션 추가',
                'add_new_item' => '새 섹션 추가',
                'edit_item' => '섹션 수정',
                'new_item' => '새 섹션',
                'view_item' => '섹션 보기',
                'search_items' => '섹션 검색',
                'not_found' => '섹션이 없습니다',
                'not_found_in_trash' => '휴지통에 섹션이 없습니다'
            ),
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-grid-view',
            'supports' => array('title', 'page-attributes'),
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'create_index_section_post_type');

// 섹션 메타박스 추가
function add_index_section_metaboxes() {
    add_meta_box(
        'index_section_details',
        '섹션 설정',
        'render_index_section_metabox',
        'index_section',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_index_section_metaboxes');

// 섹션 메타박스 렌더링
function render_index_section_metabox($post) {
    wp_nonce_field('index_section_metabox', 'index_section_metabox_nonce');
    
    $section_id = get_post_meta($post->ID, 'section_id', true);
    $cards = get_post_meta($post->ID, 'cards', true);
    
    if (!is_array($cards)) {
        $cards = array();
    }
    ?>
    
    <div class="index-section-metabox">
        <p>
            <label><strong>섹션 ID (예: aros1, aros2):</strong></label><br>
            <input type="text" name="section_id" value="<?php echo esc_attr($section_id); ?>" 
                   style="width: 100%;" placeholder="aros1">
        </p>
        
        <hr>
        
        <h3>카드 목록</h3>
        <div id="cards-container">
            <?php
            $card_index = 0;
            foreach ($cards as $card) :
            ?>
            <div class="card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                <h4>카드 #<?php echo ($card_index + 1); ?></h4>
                
                <p>
                    <label>제목:</label><br>
                    <input type="text" name="cards[<?php echo $card_index; ?>][title]" 
                           value="<?php echo esc_attr($card['title']); ?>" style="width: 100%;">
                </p>
                
                <p>
                    <label>부제목:</label><br>
                    <input type="text" name="cards[<?php echo $card_index; ?>][subtitle]" 
                           value="<?php echo esc_attr($card['subtitle']); ?>" style="width: 100%;">
                </p>
                
                <p>
                    <label>URL:</label><br>
                    <input type="url" name="cards[<?php echo $card_index; ?>][url]" 
                           value="<?php echo esc_url($card['url']); ?>" style="width: 100%;">
                </p>
                
                <p>
                    <label>아이콘 (이모지):</label><br>
                    <input type="text" name="cards[<?php echo $card_index; ?>][icon]" 
                           value="<?php echo esc_attr($card['icon']); ?>" style="width: 100px;">
                </p>
                
                <p>
                    <label>배경색 클래스:</label><br>
                    <select name="cards[<?php echo $card_index; ?>][color_class]" style="width: 100%;">
                        <?php
                        $colors = array(
                            'card-blue' => '파란색',
                            'card-blue2' => '파란색2',
                            'card-blue3' => '파란색3',
                            'card-blue4' => '파란색4',
                            'card-royalblue' => '로얄블루',
                            'card-deepskyblue' => '딥스카이블루',
                            'card-darkblue' => '다크블루',
                            'card-teal' => '청록색',
                            'card-teal-dark' => '다크청록색',
                            'card-cyan' => '시안',
                            'card-green' => '녹색',
                            'card-forestgreen' => '포레스트그린',
                            'card-seagreen' => '시그린',
                            'card-purple' => '보라색',
                            'card-purple-light' => '연보라색',
                            'card-lightpurple' => '라이트퍼플',
                            'card-deeppurple' => '딥퍼플',
                            'card-violet' => '바이올렛',
                            'card-orange' => '주황색',
                            'card-amber' => '호박색',
                            'card-darkgold' => '다크골드',
                            'card-mustard' => '머스타드',
                            'card-bronze' => '브론즈',
                            'card-darkyellow' => '다크옐로우'
                        );
                        
                        foreach ($colors as $class => $label) :
                            $selected = ($card['color_class'] === $class) ? 'selected' : '';
                        ?>
                            <option value="<?php echo esc_attr($class); ?>" <?php echo $selected; ?>>
                                <?php echo esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                
                <button type="button" class="button remove-card" style="background: #dc3232; color: white;">
                    카드 삭제
                </button>
            </div>
            <?php
            $card_index++;
            endforeach;
            ?>
        </div>
        
        <button type="button" id="add-card" class="button button-primary">
            새 카드 추가
        </button>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        let cardIndex = <?php echo count($cards); ?>;
        
        $('#add-card').on('click', function() {
            const colorOptions = <?php echo json_encode($colors); ?>;
            let optionsHtml = '';
            
            for (const [value, label] of Object.entries(colorOptions)) {
                optionsHtml += `<option value="${value}">${label}</option>`;
            }
            
            const newCard = `
                <div class="card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                    <h4>카드 #${cardIndex + 1}</h4>
                    
                    <p>
                        <label>제목:</label><br>
                        <input type="text" name="cards[${cardIndex}][title]" style="width: 100%;">
                    </p>
                    
                    <p>
                        <label>부제목:</label><br>
                        <input type="text" name="cards[${cardIndex}][subtitle]" style="width: 100%;">
                    </p>
                    
                    <p>
                        <label>URL:</label><br>
                        <input type="url" name="cards[${cardIndex}][url]" style="width: 100%;">
                    </p>
                    
                    <p>
                        <label>아이콘 (이모지):</label><br>
                        <input type="text" name="cards[${cardIndex}][icon]" style="width: 100px;" value="🔥">
                    </p>
                    
                    <p>
                        <label>배경색 클래스:</label><br>
                        <select name="cards[${cardIndex}][color_class]" style="width: 100%;">
                            ${optionsHtml}
                        </select>
                    </p>
                    
                    <button type="button" class="button remove-card" style="background: #dc3232; color: white;">
                        카드 삭제
                    </button>
                </div>
            `;
            
            $('#cards-container').append(newCard);
            cardIndex++;
        });
        
        $(document).on('click', '.remove-card', function() {
            $(this).closest('.card-item').remove();
        });
    });
    </script>
    <?php
}

// 섹션 저장
function save_index_section_meta($post_id) {
    if (!isset($_POST['index_section_metabox_nonce'])) return;
    if (!wp_verify_nonce($_POST['index_section_metabox_nonce'], 'index_section_metabox')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['section_id'])) {
        update_post_meta($post_id, 'section_id', sanitize_text_field($_POST['section_id']));
    }
    
    if (isset($_POST['cards'])) {
        $cards = array();
        foreach ($_POST['cards'] as $card) {
            $cards[] = array(
                'title' => sanitize_text_field($card['title']),
                'subtitle' => sanitize_text_field($card['subtitle']),
                'url' => esc_url_raw($card['url']),
                'icon' => sanitize_text_field($card['icon']),
                'color_class' => sanitize_text_field($card['color_class'])
            );
        }
        update_post_meta($post_id, 'cards', $cards);
    }
}
add_action('save_post_index_section', 'save_index_section_meta');

// 관리자 설정 페이지
function index_admin_menu() {
    add_menu_page(
        '목차 스킨 설정',
        '목차 스킨',
        'manage_options',
        'index-skin-settings',
        'index_settings_page',
        'dashicons-admin-generic',
        30
    );
}
add_action('admin_menu', 'index_admin_menu');

// 설정 페이지 렌더링
function index_settings_page() {
    if (isset($_POST['index_settings_submit'])) {
        check_admin_referer('index_settings_nonce');
        
        update_option('index_logo_url', esc_url_raw($_POST['logo_url']));
        update_option('index_site_title', sanitize_text_field($_POST['site_title']));
        update_option('index_ad_code', wp_kses_post($_POST['ad_code']));
        
        // 탭 저장
        if (isset($_POST['tabs'])) {
            $tabs = array();
            foreach ($_POST['tabs'] as $tab) {
                $tabs[] = array(
                    'title' => sanitize_text_field($tab['title']),
                    'url' => esc_url_raw($tab['url']),
                    'active' => isset($tab['active'])
                );
            }
            update_option('index_tabs', $tabs);
        }
        
        // 메인 카드 저장
        update_option('index_main_card', array(
            'title' => sanitize_text_field($_POST['main_card_title']),
            'content' => wp_kses_post($_POST['main_card_content']),
            'icon' => sanitize_text_field($_POST['main_card_icon'])
        ));
        
        // 푸터 설정
        update_option('index_footer_brand', sanitize_text_field($_POST['footer_brand']));
        update_option('index_footer_address', sanitize_text_field($_POST['footer_address']));
        update_option('index_footer_business_number', sanitize_text_field($_POST['footer_business_number']));
        update_option('index_footer_creator', sanitize_text_field($_POST['footer_creator']));
        update_option('index_footer_website_url', esc_url_raw($_POST['footer_website_url']));
        update_option('index_footer_copyright', sanitize_text_field($_POST['footer_copyright']));
        
        echo '<div class="notice notice-success"><p>설정이 저장되었습니다.</p></div>';
    }
    
    $logo_url = get_option('index_logo_url', '');
    $site_title = get_option('index_site_title', '오늘의 아파트');
    $ad_code = get_option('index_ad_code', '');
    $tabs = get_option('index_tabs', array());
    $main_card = get_option('index_main_card', array());
    
    ?>
    <div class="wrap">
        <h1>목차 스킨 설정</h1>
        
        <form method="post">
            <?php wp_nonce_field('index_settings_nonce'); ?>
            
            <h2>헤더 설정</h2>
            <table class="form-table">
                <tr>
                    <th>로고 URL</th>
                    <td>
                        <input type="url" name="logo_url" value="<?php echo esc_attr($logo_url); ?>" 
                               class="regular-text">
                        <p class="description">로고 이미지 URL을 입력하세요.</p>
                    </td>
                </tr>
                <tr>
                    <th>사이트 제목</th>
                    <td>
                        <input type="text" name="site_title" value="<?php echo esc_attr($site_title); ?>" 
                               class="regular-text">
                    </td>
                </tr>
            </table>
            
            <h2>탭 설정</h2>
            <table class="form-table">
                <?php
                if (empty($tabs)) {
                    $tabs = array(
                        array('title' => '신청방법', 'url' => '#aros1', 'active' => true),
                        array('title' => '대상조건', 'url' => '#aros2', 'active' => false),
                        array('title' => '지급조회', 'url' => '#aros3', 'active' => false)
                    );
                }
                
                foreach ($tabs as $i => $tab) :
                ?>
                <tr>
                    <th>탭 <?php echo ($i + 1); ?></th>
                    <td>
                        <input type="text" name="tabs[<?php echo $i; ?>][title]" 
                               value="<?php echo esc_attr($tab['title']); ?>" placeholder="제목">
                        <input type="text" name="tabs[<?php echo $i; ?>][url]" 
                               value="<?php echo esc_attr($tab['url']); ?>" placeholder="URL">
                        <label>
                            <input type="checkbox" name="tabs[<?php echo $i; ?>][active]" 
                                   <?php checked($tab['active'], true); ?>>
                            기본 활성화
                        </label>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            
            <h2>메인 카드</h2>
            <table class="form-table">
                <tr>
                    <th>제목</th>
                    <td>
                        <input type="text" name="main_card_title" 
                               value="<?php echo esc_attr($main_card['title'] ?? ''); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>내용</th>
                    <td>
                        <textarea name="main_card_content" rows="5" class="large-text"><?php 
                            echo esc_textarea($main_card['content'] ?? ''); 
                        ?></textarea>
                        <p class="description">줄바꿈은 &lt;br/&gt;로 입력하세요.</p>
                    </td>
                </tr>
                <tr>
                    <th>아이콘</th>
                    <td>
                        <input type="text" name="main_card_icon" 
                               value="<?php echo esc_attr($main_card['icon'] ?? '🎁'); ?>">
                    </td>
                </tr>
            </table>
            
            <h2>광고 설정</h2>
            <table class="form-table">
                <tr>
                    <th>광고 코드</th>
                    <td>
                        <textarea name="ad_code" rows="8" class="large-text"><?php 
                            echo esc_textarea($ad_code); 
                        ?></textarea>
                    </td>
                </tr>
            </table>
            
            <h2>푸터 설정</h2>
            <table class="form-table">
                <tr>
                    <th>브랜드명</th>
                    <td>
                        <input type="text" name="footer_brand" 
                               value="<?php echo esc_attr(get_option('index_footer_brand', '굿인포')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>사업자 주소</th>
                    <td>
                        <input type="text" name="footer_address" 
                               value="<?php echo esc_attr(get_option('index_footer_address', '')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>사업자 번호</th>
                    <td>
                        <input type="text" name="footer_business_number" 
                               value="<?php echo esc_attr(get_option('index_footer_business_number', '')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>제작자</th>
                    <td>
                        <input type="text" name="footer_creator" 
                               value="<?php echo esc_attr(get_option('index_footer_creator', '아로스')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>홈페이지 URL</th>
                    <td>
                        <input type="url" name="footer_website_url" 
                               value="<?php echo esc_url(get_option('index_footer_website_url', '')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>저작권 문구</th>
                    <td>
                        <input type="text" name="footer_copyright" 
                               value="<?php echo esc_attr(get_option('index_footer_copyright', '')); ?>" 
                               class="large-text">
                    </td>
                </tr>
            </table>
            
            <?php submit_button('설정 저장', 'primary', 'index_settings_submit'); ?>
        </form>
    </div>
    <?php
}

// Puter.js API 연동 (선택사항)
function enqueue_puter_js() {
    if (is_page_template('page-index.php')) {
        wp_enqueue_script('puter-js', 'https://js.puter.com/v2/', array(), null, true);
        
        wp_add_inline_script('puter-js', "
            // Puter.js 초기화 및 데이터 로딩 예제
            document.addEventListener('DOMContentLoaded', async function() {
                try {
                    // Puter.js를 사용한 데이터 로딩 로직
                    // 필요시 구현
                } catch (error) {
                    console.error('Puter.js error:', error);
                }
            });
        ");
    }
}
add_action('wp_enqueue_scripts', 'enqueue_puter_js');
?>
