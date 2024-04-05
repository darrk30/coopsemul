var swiper = new Swiper('.swiper-banner', {
    loop: true,
    autoplay: {
        delay: 5000, // Cambia el valor según sea necesario (en milisegundos)
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});