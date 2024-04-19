
   var swiper = new Swiper(".mySwiper", {
     slidesPerView: 4,
     spaceBetween: 30,
     pagination: {
       el: ".swiper-pagination",
       clickable: true,
     },
     
     breakpoints: {
        1024: {
         slidesPerView: 4,
         spaceBetween: 30,
       },
        768: {
         slidesPerView: 3,
         spaceBetween: 30,
       },
       640: {
         slidesPerView: 2,
         spaceBetween: 20,
       },
       250: {
         slidesPerView: 1,
         spaceBetween: 10,
       }
     },
     navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
   });
  

   
 