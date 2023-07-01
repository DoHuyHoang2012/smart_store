$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

$(window).on('load', function(){ 
    $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails"
    });
});

$('#sortControl').on('change', function(){
    let searchParams= new URLSearchParams(window.location.search);

    params 			= ['page'];

    let link		= "";
    $.each( params, function( key, value ) {
        if (searchParams.has(value) ) {
            link +="&"+ value + "=" + searchParams.get(value) 
        }
    });
    
    let select_value = $(this).val();
    let $url = $(this).data('url');
    
    window.location.href = $url.replace('default', select_value)+link;
});

$('.add_to_cart_detail').click(function (e) {
    e.preventDefault();
    var strurl = $(this).data('url');
    var cartID = $(this).data('id');
   
    $.ajax({
        url: strurl,
        type: "GET",
        dataType: "json",
        data: {id: cartID},
        success: function(response) {
            alertify.alert('Smart Store thông báo',response.message,function(){
                if(response.status === 200){
                    $('.cart_header .box_text').html(response.cart_price);
                    $('#cart-mobile').html(response.cart_mobile);
                } 
            });  
       }, 
      
            
    });
});

function onChangeSL(id){
    var quantity = document.getElementById(id).value;
    let link = $('#'+id).data('url');
    
    $.ajax({
        url: link,
        type: 'GET',
        dataType: 'json',
        data: {id: id, quantity: quantity},
        success: function(response) {
           if(response.code === 200){
            $('.content-cart').html(response.cart_component);
            $('.cart_header .box_text').html(response.cart_price);
          
           }
        },
        error: function(){
        
        }
    });
}

function onRemoveProduct(id){
    let strurl = $('#remove-'+id).data('url');
    $.ajax({
        url: strurl,
        type: 'GET',
        dataType: 'json',
        data: {id: id},
        success: function(response) {
            if(response.code === 200){
                $('.content-cart').html(response.cart_component);
                $('.cart_header .box_text').html(response.cart_price);
                $('#cart-mobile').html(response.cart_mobile);
               }
        }
    });
}

function renderDistrict(){
    var provinceid=$("#province").val();
    var strurl=$("#province").data('url');
    $.ajax({
        url: strurl,
        type: 'GET',
        dataType: 'json',
        data: {'provinceid': provinceid},
        success: function(response) {
            if(response.code === 200){
                $('#district').html(response.district_component);
            }
        }
    });
};

function checkCoupon(){
    var code = $("input[name='coupon']").val();
    var strurl=$("#check-coupon").data('url');
    
    $.ajax({
        url: strurl,
        type: 'GET',
        dataType: 'json',
        data: {code: code},
        success: function(response) {
            if(response.code === 200){
                $('#result_coupon').html(response.coupon_component);
                $('#order-info').html(response.orderInfoComponent);
            }
        }    
    });
}

function removeCoupon(){
    var strurl=$("#remove_coupon").data('url');
    $.ajax({
        url: strurl,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.code === 200){
                $('#result_coupon').html(response.coupon_component);
                $('#order-info').html(response.orderInfoComponent);
            }
        }
    });
}


   

