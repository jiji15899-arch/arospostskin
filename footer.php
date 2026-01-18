<!-- 푸터 -->
    <footer class="site-footer">
        <div class="footer-content">
            
            <!-- 푸터 위젯 영역 -->
            <div class="footer-widgets">
                <div class="footer-widget-area">
                    <h3>📌 주요 메뉴</h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container' => false,
                        'fallback_cb' => false,
                        'depth' => 1
                    ));
                    ?>
                </div>
                
                <div class="footer-widget-area">
                    <h3>📧 문의</h3>
                    <p>이메일: <?php echo get_option('admin_email'); ?></p>
                    <p>언제든지 연락주세요!</p>
                </div>
                
                <div class="footer-widget-area">
                    <h3>🔗 소셜 미디어</h3>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="페이스북">📘</a>
                        <a href="#" class="social-link" aria-label="트위터">🐦</a>
                        <a href="#" class="social-link" aria-label="인스타그램">📷</a>
                        <a href="#" class="social-link" aria-label="유튜브">📹</a>
                    </div>
                </div>
            </div>
            
            <!-- 저작권 정보 -->
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                <p class="powered-by">
                    Powered by <strong>Abaek Dable Revenue Pro</strong> 💰
                </p>
            </div>
            
        </div>
    </footer>
    
    <!-- 상단 이동 버튼 -->
    <button id="scroll-to-top" class="scroll-to-top" aria-label="맨 위로 이동">
        ↑
    </button>
    
</div><!-- #page -->

<?php wp_footer(); ?>

<style>
/* 푸터 위젯 */
.footer-widgets {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
    margin-bottom: 40px;
    padding-bottom: 40px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-widget-area h3 {
    font-size: 18px;
    margin-bottom: 15px;
    color: white;
}

.footer-widget-area ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-widget-area li {
    margin-bottom: 8px;
}

.footer-widget-area a {
    color: #cbd5e0;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-widget-area a:hover {
    color: white;
}

.social-links {
    display: flex;
    gap: 15px;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    font-size: 20px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
}

.footer-bottom {
    text-align: center;
    padding-top: 20px;
}

.footer-bottom p {
    font-size: 14px;
    color: #a0aec0;
    margin: 5px 0;
}

.powered-by {
    font-size: 12px;
}

/* 상단 이동 버튼 */
.scroll-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: var(--button-gradient);
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 999;
}

.scroll-to-top.visible {
    opacity: 1;
    visibility: visible;
}

.scroll-to-top:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

@media (max-width: 768px) {
    .footer-widgets {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .scroll-to-top {
        width: 45px;
        height: 45px;
        bottom: 20px;
        right: 20px;
        font-size: 20px;
    }
}
</style>

<script>
// 상단 이동 버튼 기능
(function() {
    const scrollBtn = document.getElementById('scroll-to-top');
    
    if (!scrollBtn) return;
    
    // 스크롤 시 버튼 표시/숨김
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollBtn.classList.add('visible');
        } else {
            scrollBtn.classList.remove('visible');
        }
    });
    
    // 클릭 시 상단 이동
    scrollBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // URL 복사 기능
    const copyButtons = document.querySelectorAll('.share-btn.copy');
    copyButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = window.location.href;
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(function() {
                    alert('✅ URL이 복사되었습니다!');
                });
            } else {
                // 구형 브라우저 지원
                const temp = document.createElement('input');
                document.body.appendChild(temp);
                temp.value = url;
                temp.select();
                document.execCommand('copy');
                document.body.removeChild(temp);
                alert('✅ URL이 복사되었습니다!');
            }
        });
    });
})();

// 이미지 레이지 로딩 폴백
if ('loading' in HTMLImageElement.prototype) {
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
        img.src = img.dataset.src || img.src;
    });
} else {
    // 폴백: IntersectionObserver 사용
    const imageObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src || img.src;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });
    
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => imageObserver.observe(img));
}
</script>

</body>
</html>
