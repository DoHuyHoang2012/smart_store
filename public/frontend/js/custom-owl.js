var owl = $('.owl-carousel-slider');
owl.owlCarousel({
    items:1,
    loop:true,
    margin:10,
    autoplay:true,
    dots:false,
    autoplayTimeout:5000,
    autoplayHoverPause:true
});
$('.play').on('click',function(){
    owl.trigger('play.owl.autoplay',[1000])
})
$('.stop').on('click',function(){
    owl.trigger('stop.owl.autoplay')
})

$('.owl-carousel-product').owlCarousel({
    loop: true,
    margin: 10,
    autoplay: true,
    dots:false,
    autoplayTimeout: 4000,
    responsive: {
        0: {
            items: 2
        },
        600: {
            items: 3
        },
        1000: {
            items: 5
        }
    }
})

$('.owl-carousel-related-prod').owlCarousel({
    loop: false,
    margin: 10,
    dots:false,
    responsive: {
        0: {
            items: 2
        },
        600: {
            items: 3
        },
        1000: {
            items: 5
        }
    }
})