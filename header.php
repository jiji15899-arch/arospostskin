<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <?php wp_head(); ?>
    
    <!-- Google Fonts (Noto Sans KR for Korean) -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- 추가 스타일 -->
    <style>
    /* 히어로 섹션 */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 80px 20px;
        text-align: center;
        color: white;
        margin-bottom: 60px;
        border-radius: 0 0 30px 30px;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path d="M0,0 C300,100 900,100 1200,0 L1200,120 L0,120 Z" fill="rgba(255,255,255,0.1)"/></svg>') no-repeat bottom;
        background-size: cover;
        opacity: 0.3;
    }
    
    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .hero-title {
        font-size: 42px;
        font-weight: 900;
        margin-bottom: 15px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        line-height: 1.3;
    }
    
    .hero-subtitle {
        font-size: 18px;
        opacity: 0.95;
        font-weight: 500;
    }
    
    /* 페이지네이션 */
    .pagination {
        margin: 60px 0 40px;
        text-align: center;
    }
    
    .pagination ul {
        display: inline-flex;
        list-style: none;
        gap: 8px;
        padding: 0;
        margin: 0;
    }
    
    .pagination li {
        margin: 0;
    }
    
    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 10px 16px;
        background: white;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-color);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }
    
    .pagination a:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }
    
    .pagination .current {
        background: var(--button-gradient);
        color: white;
        border-color: transparent;
    }
    
    /* 소셜 공유 버튼 */
    .social-share-top,
    .social-share-bottom {
        margin: 30px 0;
        padding: 25px;
        background: var(--light-gray);
        border-radius: 12px;
        text-align: center;
    }
    
    .share-title {
        font-size: 18px;
        margin-bottom: 20px;
        color: var(--text-color);
    }
    
    .share-buttons {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    
    .share-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition);
        color: white;
    }
    
    .share-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    
    .share-btn.facebook {
        background: #1877f2;
    }
    
    .share-btn.twitter {
        background: #1da1f2;
    }
    
    .share-btn.kakao {
        background: #fee500;
        color: #3c1e1e;
    }
    
    .share-btn.naver {
        background: #03c75a;
    }
    
    .share-btn.copy {
        background: #718096;
    }
    
    /* 작성자 박스 */
    .author-box {
        display: flex;
        gap: 20px;
        padding: 30px;
        background: var(--light-gray);
        border-radius: 12px;
        margin: 40px 0;
        align-items: center;
    }
    
    .author-avatar {
        flex-shrink: 0;
    }
    
    .author-avatar img {
        border-radius: 50%;
        width: 80px;
        height: 80px;
    }
    
    .author-name {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--text-color);
    }
    
    .author-bio {
        font-size: 14px;
        color: #718096;
        line-height: 1.6;
        margin: 0;
    }
    
    /* 태그 */
    .post-tags {
        margin: 30px 0;
        padding: 20px;
        background: var(--light-gray);
        border-radius: 8px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }
    
    .tags-label {
        font-weight: 700;
        color: var(--text-color);
    }
    
    .tag-item {
        display: inline-block;
        padding: 6px 14px;
        background: white;
        border: 2px solid var(--border-color);
        border-radius: 20px;
        text-decoration: none;
        color: var(--primary-color);
        font-size: 13px;
        font-weight: 600;
        transition: var(--transition);
    }
    
    .tag-item:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }
    
    /* 모바일 메뉴 */
    .mobile-menu-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: var(--text-color);
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 28px;
        }
        
        .hero-subtitle {
            font-size: 16px;
        }
        
        .hero-section {
            padding: 50px 20px;
        }
        
        .mobile-menu-toggle {
            display: block;
        }
        
        .main-nav {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        .main-nav.active {
            display: block;
        }
        
        .main-nav ul {
            flex-direction: column;
            gap: 15px;
        }
        
        .author-box {
            flex-direction: column;
            text-align: center;
        }
        
        .share-buttons {
            gap: 8px;
        }
        
        .share-btn {
            padding: 10px 16px;
            font-size: 13px;
        }
    }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    
    <!-- 헤더 -->
    <header class="site-header">
        <div class="header-inner">
            
            <!-- 로고 / 사이트 제목 -->
            <div class="site-branding">
                <?php
                if (has_custom_logo()) :
                    the_custom_logo();
                else :
                ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div>
            
            <!-- 모바일 메뉴 토글 -->
            <button class="mobile-menu-toggle" aria-label="메뉴 열기">
                ☰
            </button>
            
            <!-- 네비게이션 -->
            <nav class="main-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'fallback_cb' => 'abaek_default_menu'
                ));
                ?>
            </nav>
            
        </div>
    </header>
    
    <script>
    // 모바일 메뉴 토글
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.querySelector('.mobile-menu-toggle');
        const nav = document.querySelector('.main-nav');
        
        if (toggle && nav) {
            toggle.addEventListener('click', function() {
                nav.classList.toggle('active');
                this.textContent = nav.classList.contains('active') ? '✕' : '☰';
            });
        }
    });
    </script>
