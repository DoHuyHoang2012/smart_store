$(document).ready(function() {
	let $btnSearch        = $("button#btn-search");
	let $btnClearSearch	  = $("button#btn-clear-search");

	let $inputSearchField = $("input[name  = search_field]");
	let $inputSearchValue = $("input[name  = search_value]");

	let $selectFilter     = $("select[name = select_filter]");
	let $selectChangeAttr = $("select[name =  select_change_attr]");
	let $selectChangeAttrAjax = $("select[name =  select_change_attr_ajax]");


	$("a.select-field").click(function(e) {
		e.preventDefault();

		let field 		= $(this).data('field');
		let fieldName 	= $(this).html();
		$("button.btn-active-field").html(fieldName + ' <span class="caret"></span>');
    	$inputSearchField.val(field);
	});

	$btnSearch.click(function () {
        var pathname = window.location.pathname;
        let params = ["filter_status"];
        let searchParams = new URLSearchParams(window.location.search); // ?filter_status=active

        let link = "";
        $.each(params, function (key, param) {
            // filter_status
            if (searchParams.has(param)) {
                link += param + "=" + searchParams.get(param) + "&"; // filter_status=active
            }
        });

        let search_field = $inputSearchField.val();
        let search_value = $inputSearchValue.val();

        if (search_value.replace(/\s/g, "") == "") {
            alert("Nhập vào giá trị cần tìm !!");
        } else {
            window.location.href =
                pathname +
                "?" +
                link +
                "search_field=" +
                search_field +
                "&search_value=" +
                search_value;
        }
    });

	$btnClearSearch.click(function() {
		var pathname	= window.location.pathname;
		let searchParams= new URLSearchParams(window.location.search);

		params 			= ['page', 'filter_status', 'select_filter'];

		let link		= "";
		$.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});

		window.location.href = pathname + "?" + link.slice(0,-1);
	});

	//Event onchange select filter
	$selectFilter.on('change', function () {
		var pathname	= window.location.pathname;
		let searchParams= new URLSearchParams(window.location.search);

		params 			= ['page', 'filter_status', 'search_field', 'search_value'];

		let link		= "";
		$.each( params, function( key, value ) {
			if (searchParams.has(value) ) {
				link += value + "=" + searchParams.get(value) + "&"
			}
		});

		let select_field = $(this).data('field');
		let select_value = $(this).val();
		window.location.href = pathname + "?" + link.slice(0,-1) + 'select_field='+ select_field + '&select_value=' + select_value;
 	});


	$selectChangeAttr.on('change', function() {
		
		let ele = $(this);
		let select_value = $(this).val();
		let url = $(this).data('url');
		url = url.replace('value_new', select_value);
		
		$.ajax({
			type: "GET",
			url: url,
			dataType: "json",
			success: function(response){
				
				ele.notify("Cập nhật thành công",{
					position: 'top center',
					className: 'success'
				})
			}
		})
	});



	$('.status-order').on('click',function(){
		let url = $(this).data('url');
		let btn = $(this);
		let currentClass = $(this).data('class');
		$.ajax({
			type: "GET",
			url: url,
			dataType: "json",
			success: function(response){
				if(response.statusObj){
					btn.removeClass(currentClass);
					btn.addClass(response.statusObj.class);
					btn.html(response.statusObj.name);
					btn.data('url', response.link);
					btn.data('class', response.statusObj.class);
					
					confirm(response.confirm);
					location.reload();
				}else{
					confirm(response.confirm);
					location.reload();
				}
			}
		});
	})

	$('.status-ajax').on('click',function(){
		let url = $(this).data('url');
		let btn = $(this);
		let currentClass = $(this).data('class');
		$.ajax({
			type: "GET",
			url: url,
			dataType: "json",
			success: function(response){
				btn.removeClass(currentClass);
				btn.addClass(response.statusObj.class);
				btn.html(response.statusObj.name);
				btn.data('url', response.link);
				btn.data('class', response.statusObj.class);
				btn.notify("Cập nhật thành công", {
					position: 'top center',
					className: 'success'
				});
			}
		});
	})

	


	//Confirm button delete item
	$('.btn-delete').on('click', function() {
		if(!confirm('Bạn có chắc muốn xóa phần tử?'))
			return false;
	});
});