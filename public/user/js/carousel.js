document.addEventListener('DOMContentLoaded', function() {
    const prev_btn = document.getElementById('prev_btn');
    const next_btn = document.getElementById('next_btn');
    const carousel = document.querySelector('#eventCarouselCard');
    const carouselItems = carousel.querySelectorAll('.carousel-item');

    // 初始化按钮的显示状态
    if (carouselItems.length <= 1) {
        prev_btn.disabled = true; // 如果只有一个项目，禁用按钮
        next_btn.disabled = true; // 同样禁用下一页按钮
    } else {
        prev_btn.disabled = true; // 默认禁用上一页按钮
        next_btn.disabled = false; // 显示下一页按钮
    }
});

function moveCarousel(step) {
    const prev_btn = document.getElementById('prev_btn');
    const next_btn = document.getElementById('next_btn');
    const carousel = document.querySelector('#eventCarouselCard');
    const carouselItems = carousel.querySelectorAll('.carousel-item');
    const totalItems = carouselItems.length;

    let activeIndex = Array.from(carouselItems).findIndex(item => item.classList.contains('active'));
    let newIndex = activeIndex + step / 2;

    // 确保索引在有效范围内
    if (newIndex < 0) {
        newIndex = 0;
    } else if (newIndex >= totalItems) {
        newIndex = totalItems - 1;
    }

    // 更新活动项目
    carouselItems[activeIndex].classList.remove('active');
    carouselItems[newIndex].classList.add('active');

    // 更新按钮的禁用状态
    prev_btn.disabled = newIndex === 0; // 如果是第一个项目，禁用上一页按钮
    next_btn.disabled = newIndex === totalItems - 1; // 如果是最后一个项目，禁用下一页按钮
}


