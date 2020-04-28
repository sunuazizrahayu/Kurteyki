/**
 * to top
 */
 $(window).scroll(function() {
 	if ($(this).scrollTop() > 100) {
 		$('#toTop').fadeIn();
 	} else {
 		$('#toTop').fadeOut();
 	}
 });

 $("#toTop").click(function () {
 	$("html, body").animate({scrollTop: 0}, 500);
 });

/**
* Module Categories on Select
*/
$('#select-category,#selectmenu').on('change', function() {
	var value = $(this).find('option:selected').val();
	window.location.href = value
});	


/**
* Module Add Courses 
*/
$('.btn-process-courses').on('click', function(e) {
	e.preventDefault();

	let button = $(this);

	button.prop("disabled", true);

	var data = [];
	data.push({ name: "id", value: button.data('id') });
	data.push({ name: "redirect", value: button.data('redirect') });

	$.ajax({
		url: button.data('action'),
		method: "POST",
		data: data,
		dataType: 'JSON',
		success: function(data) {

			if (data.status == true) {

				Swal.fire({
					title: data.message,
					icon: 'success',
					confirmButtonColor: '#3085d6',
				})
				.then((result) => {
					window.location.href = data.redirect;
				})                    

			}else {

				Swal.fire({
					title: data.message,
					icon: 'error',
					confirmButtonColor: '#3085d6',
				})

			}

			button.prop("disabled", false);
		},
		error: function(xhr, ajaxOptions, thrownError) {

			Swal.fire({
				title: 'Error Processing !',
				icon: 'error',
				confirmButtonColor: '#3085d6',
			})

			button.prop("disabled", false);

		}
	});

});	

/**
* Module user lesson
*/
$('.btn-process-lesson').on('click', function(e) {
	e.preventDefault();

	let button = $(this);

	button.prop("disabled", true);

	var data = [];
	data.push({ name: "id_courses", value: button.data('id-courses') });
	data.push({ name: "id_lesson", value: button.data('id-lesson') });	

	$.ajax({
		url: button.data('action'),
		method: "POST",
		data: data,
		dataType: 'text',
		success: function(status) {

			if (status == 'set_false') {

				$("i",button).removeClass().addClass('fa fa-check u-color-white u-m-zero');            
			}
			else if (status == 'set_true') {

				$("i",button).removeClass().addClass('fa fa-check u-color-success u-m-zero');             
			}else{

				/** error */
			}

			button.prop("disabled", false);
		},
		error: function(xhr, ajaxOptions, thrownError) {

			Swal.fire({
				title: 'Error Processing !',
				icon: 'error',
				confirmButtonColor: '#3085d6',
			})

			button.prop("disabled", false);

		}
	});

});	


/**
* Module add to wishlist 
*/
$('.btn-process-wishlist').on('click', function(e) {
	e.preventDefault();

	let button = $(this);

	button.prop("disabled", true);

	var data = [];
	data.push({ name: "id", value: button.data('id') });

	$.ajax({
		url: button.data('action'),
		method: "POST",
		data: data,
		dataType: 'text',
		success: function(status) {

			if (status == 'success_remove') {

				$("i",button).removeClass().addClass('fa fa-heart-o');            
			}
			else if (status == 'success_add') {


				$("i",button).removeClass().addClass('fa fa-heart u-text-danger');             
			}else{

				/** error */
			}

			button.prop("disabled", false);
		},
		error: function(xhr, ajaxOptions, thrownError) {

			Swal.fire({
				title: 'Error Processing !',
				icon: 'error',
				confirmButtonColor: '#3085d6',
			})

			button.prop("disabled", false);

		}
	});

});	

/**
 * Module remove wish list
 */

 $('.btn-remove-wishlist').on('click', function(e) {
 	e.preventDefault();
 	Swal.fire({
 		title: $(this).data('title'),
 		text: $(this).data('text'),
 		icon: 'warning',
 		showCancelButton: true,
 		confirmButtonColor: '#3085d6',
 		cancelButtonColor: '#d33',
 		confirmButtonText: 'Yes',
 		cancelButtonText: 'No'        
 	}).then((result) => {
 		if (result.value) {
 			window.location.href = $(this).data('action');
 		}
 	})
 });

/**
* Payment
*/
$('#form-payment').on('keyup keypress', function(e) {
	var keyCode = e.keyCode || e.which;
	if (keyCode === 13) { 
		e.preventDefault();
		return false;
	}
});
$("#form-payment").submit(function(e) {
	e.preventDefault();

	$("button[type='submit']").prop("disabled", true); /* disable submit button */

	let	payment_method = $("input[name='payment_method']").val(),
	free_code = $("input[name='free_code']").val();

	if (free_code) {
		process_free($("input[name='free_action']").val(),$(this).serialize());
	}
	else if (payment_method == 'Midtrans' && free_code == '') {
		process_midtrans()
	}
	else if (payment_method == 'Manual' && free_code == '') {
		process_manual($("input[name='action']").val(),$(this).serialize());
	}

	$("button[type='submit']").prop("disabled", false);
})

/**
* Payment Free
*/
var process_free = function(url,data){
	$.ajax({
		url: url,
		method: "POST",
		data: data,
		dataType: 'JSON',
		success: function(data) {

			if (data.status == true) {
				window.location.href = data.redirect;
			}else {
				Swal.fire({
					title: data.error,
					icon: 'error',
					confirmButtonColor: '#3085d6',
				})
			}

		},
		error: function(xhr, ajaxOptions, thrownError) {
			Swal.fire({
				title: 'Error Processing !',
				icon: 'error',
				confirmButtonColor: '#3085d6',
			})
		}
	}); 
}

/**
* Payment Manual
*/
var process_manual = function(url,data){
	$.ajax({
		url: url,
		method: "POST",
		data: data,
		dataType: 'JSON',
		success: function(data) {

			if (data.status == true) {

				$("#form-payment").trigger("reset");
				top.location.href = data.redirect;
				
			}else {
				Swal.fire({
					title: data.error,
					icon: 'error',
					confirmButtonColor: '#3085d6',
				})
			}

		},
		error: function(xhr, ajaxOptions, thrownError) {
			Swal.fire({
				title: 'Error Processing !',
				icon: 'error',
				confirmButtonColor: '#3085d6',
			})
		}
	}); 
}

/**
* Payment Midtrans
*/
var process_midtrans = function(){
	let token = $("input[name='token']").val(),
	lang = $("input[name='lang']").val(),
	action = $("input[name='action']").val();

	snap.pay(token, {
		language: lang,
		onSuccess: function(result){
			result['token'] = token;
			insert_order(result,action)	
		},
		onPending: function(result){
			result['token'] = token;
			insert_order(result,action)
		},
		onClose: function(){
			$("button[type='submit']").prop("disabled", false);
			console.log('customer closed the popup without finishing the payment');
		}
	});
}	
var insert_order = function(result,action){


	result.id_courses_user = $("input[name='id_courses_user']").val();
	result.coupon = $("input[name='code']").val();

	$.ajax({
		url: action,
		method: "POST",
		data: JSON.stringify(result),
		contentType: "application/json; charset=utf-8",
		dataType: 'JSON',
		success: function(data) {

			if (data.status == true) {                  

				window.location.href = data.redirect;

			}else {

				Swal.fire({
					title: data.message,
					icon: 'error',
					confirmButtonColor: '#3085d6',
				})

			}

		},
		error: function(xhr, ajaxOptions, thrownError) {

			Swal.fire({
				title: 'Error Processing !',
				icon: 'error',
				confirmButtonColor: '#3085d6',
			})

		}
	}); 
}

/**
* Midtrans Check
*/
$('.btn-check-payment').on('click', function(e) {
	e.preventDefault();

	let  button = $(this),
	token = button.data("token"),
	lang = button.data("lang");

	button.prop("disabled", true);

	snap.pay(token, {
		language: lang,
		onPending: function(result){
			button.prop("disabled", false);			
			check_order(result)	
		},
		onError: function(){
			button.prop("disabled", false);
			return false; 
		},
		onClose: function(){
			button.prop("disabled", false);
			return false; 
		}
	});
});	

var check_order = function(result){

	$.ajax({
		url: result.finish_redirect_url,
		method: "POST",
		data: JSON.stringify(result),
		contentType: "application/json; charset=utf-8",
		dataType: 'JSON',
		success: function(data) {

			if (data.status == true) {                  

				window.location.href = data.redirect;

			}

		},
		error: function(xhr, ajaxOptions, thrownError) {
			Swal.fire({
				title: 'Error Processing !',
				icon: 'error',
				confirmButtonColor: '#3085d6',
			})
		}
	}); 
}

/**
 * Module Coupon
 */
 $('#check-coupon').on('click', function(e) {

 	e.preventDefault();

 	if ($("input[name='code']").val() == '') {
 		$("input[name='code']").focus();
 		return false;
 	}

 	let button = $(this);
 	button.prop("disabled", true);

 	$.ajax({
 		url: button.data('action'),
 		method: "POST",
 		data: $("#form-payment").serialize(),
 		dataType: 'JSON',
 		success: function(data) {

 			if (data.status == 'valid_not_free_manual') {
 				$("input[name='code']").prop("readonly", true); /* set input voucher disable */
 				$("input[name='free_code']").val(''); /* set value input free_code */
 				$("#order-discount-coupon, #remove-coupon").removeClass('u-hidden'); /* show coupon meessage, show remove coupon button */
 				$("#check-coupon").addClass('u-hidden'); /* hide coupon check button */
 				$("#order-discount-coupon > h4").html(data.discount_coupon); /* show discount price */
 				$("#order-price-total").html(data.price_total); /* set price total */
 				$("#coupon-respon").html('<small class="c-field__message u-color-success"><i class="fa fa-check"></i> ' + data.message + '</small>'); 				
 			} 
 			else if (data.status == 'valid_not_free_midtrans') {
 				$("input[name='code']").prop("readonly", true); /* set input voucher disable */
 				$("input[name='free_code']").val(''); /* set value input free_code */
 				$("#order-discount-coupon, #remove-coupon").removeClass('u-hidden'); /* show coupon meessage, show remove coupon button */
 				$("#check-coupon").addClass('u-hidden'); /* hide coupon check button */
 				$("#order-discount-coupon > h4").html(data.discount_coupon); /* show discount price */
 				$("#order-price-total").html(data.price_total); /* set price total */
 				$("input[name='token']").val(data.midtrans_token); /* set input midtrans token */
 				$("#coupon-respon").html('<small class="c-field__message u-color-success"><i class="fa fa-check"></i> ' + data.message + '</small>'); 				
 			}  			
 			else if (data.status == 'valid_to_free') {
 				$("input[name='code']").prop("readonly", true); /* set input voucher disable */
 				$("input[name='free_code']").val(data.free_code); /* set input free code */
 				$("#order-discount-coupon, #remove-coupon").removeClass('u-hidden'); /* show coupon meessage, show remove coupon button */
 				$("#check-coupon").addClass('u-hidden'); /* hide coupon check button */
 				$("#order-discount-coupon > h4").html(data.discount_coupon); /* show discount price */
 				$("#order-price-total").html(data.price_total); /* set price total */
 				$("#coupon-respon").html('<small class="c-field__message u-color-success"><i class="fa fa-check"></i> ' + data.message + '</small>');

 				$("button[type='submit']").prop("disabled", false); /* enable order button */
 			}
 			else if (data.status == 'invalid') {
 				$("#coupon-respon").html('<small class="c-field__message u-color-danger"><i class="fa fa-times-circle"></i> ' + data.message + '</small>');
 			}else {
 				Swal.fire({
 					title: 'Error Processing !',
 					icon: 'error',
 					confirmButtonColor: '#3085d6',
 				})
 			}

 			button.prop("disabled", false);
 		},
 		error: function(xhr, ajaxOptions, thrownError) {
 			Swal.fire({
 				title: 'Error Processing !',
 				icon: 'error',
 				confirmButtonColor: '#3085d6',
 			})
 		}
 	});
 })

 $('#remove-coupon').on('click', function(e) {
 	e.preventDefault();

 	let	payment_method = $("input[name='payment_method']").val();

 	$("input[name='free_code']").val(''); /* remove value free code */
 	$("input[name='code']").val('').prop("readonly", false); /* remove discount price, enable input */
 	$("#order-discount-coupon").addClass('u-hidden'); /* hidden coupon message */
 	$("#order-price-total").html($('#order-price-total').data('price-total')); /* set price total to default */ 				
 	$("#coupon-respon").html(''); /* remove coupon message */

 	if (payment_method == 'Midtrans') {
 		$("input[name='token']").val($("input[name='token']").data('value')); /* set token default */
 	}

 	if (payment_method == 'Manual' && $("input:radio[name=transaction]:checked").val() == undefined) {
 		$("button[type='submit']").prop("disabled", true); /* enable order button */
 	}

 	$("#check-coupon").removeClass('u-hidden'); /* show check coupon button */
 	$("#remove-coupon").addClass('u-hidden'); /* hidden remove coupon button */
 });

 /**
 * Module transaction
 */
 $('input:radio[name="transaction"]').change(function(){
 	if($(this).is(":checked")){
 		$("button[type='submit']").prop("disabled", false); /* disable order button */
 	}
 });

/**
* Module confirmation
*/
$(".custom-input-file-trigger").on( "keydown", function( event ) {  
	if ( event.keyCode == 13 || event.keyCode == 32 ) {  
		$(".custom-input-file").click();  
	}  
});
$(".custom-input-file-trigger").on( "click", function( event ) {
	$(".custom-input-file").click();
	return false;
});  
$(".custom-input-file").on( "change", function( event ) {  

	var reader = new FileReader();
	reader.onload = function(){
		$(".file-return").attr('src',reader.result);
	};

	reader.readAsDataURL(event.target.files[0]);
});  

/**
 * Module rating
 */
 $(document).ready(function(){

 	/* 1. Visualizing things on Hover - See next part for action on click */
 	$('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
    	if (e < onStar) {
    		$(this).addClass('hover');
    	}
    	else {
    		$(this).removeClass('hover');
    	}
    });
    
}).on('mouseout', function(){
	$(this).parent().children('li.star').each(function(e){
		$(this).removeClass('hover');
	});
});


/* 2. Action to perform on click */
$('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
    	$(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
    	$(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
    	msg = "Thanks! You rated this " + ratingValue + " stars.";
    }
    else {
    	msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
    }
    responseMessage(msg);
    
});


});


 function responseMessage(msg) {
 	$('.success-box').fadeIn(200);  
 	$('.success-box div.text-message').html("<span>" + msg + "</span>");
 }	