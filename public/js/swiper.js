const mySwiper = new Swiper('.swiper-container', {  
    observer: true,
    observeParents: true,
    // rebuildOnUpdate: true,
    direction: 'horizontal',
    loop: true,

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
})