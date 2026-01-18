// 탭 활성화 처리
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab-link');
    const hash = window.location.hash;
    let activeTabFound = false;

    tabs.forEach(tab => {
        if (hash) {
            if (tab.getAttribute('href') && tab.getAttribute('href').includes(hash)) {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                activeTabFound = true;
            }
        }
    });

    if (!activeTabFound) {
        const defaultActiveTab = document.querySelector('.tab-link.active');
        if (defaultActiveTab) {
            defaultActiveTab.classList.add('active');
        }
    }
});
