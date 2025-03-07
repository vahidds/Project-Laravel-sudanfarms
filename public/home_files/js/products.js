$(document).ready(function() {

	$(document).on('click', '.count-call-phone', function () {

		var id     = $(this).data('id');
		var url    = $(this).data('url');
		var method = 'get';

		$.ajax({
			url: url,
			method: method,
		});//end of ajax

	});//end of click phone

	$(document).on('click', '.count-call-email', function () {

		var id     = $(this).data('id');
		var url    = $(this).data('url');
		var method = 'get';

		$.ajax({
			url: url,
			method: method,
		});//end of ajax

	});//end of click email

	$(document).on('click', '.newsletter-email', function (e) {
		e.preventDefault();

		var email   = $('.newsletter-val').val();
		var url    = $(this).data('url');
		var method  = 'post';

		$('.news-form').removeClass('is-invalid');
        $('.newsletter-val-error').text('');

		$.ajax({
			url: url,
			method: method,
			data: {email : email},
			success: function (data) {

				if (data.success == true) {

					if (data.local == 'ar') {

	            		var title    = 'تمت الاضافه بنجاح';

	            	} else {

	            		var title    = 'add success'
	            	}
	            	
	            	var email   = $('.newsletter-val').val('');

			        swal(title, {
			            type: "success",
			            icon: "success",
					  	buttons: false,
					  	timer: 3000,
			            timer: 15000
					});

				} else {

					if (data.local == 'ar') {

	            		var title    = 'تم الاشتراك من قبل';

	            	} else {

	            		var title    = 'Subscribed by'

	            	}

			        swal(title, {
			            type: "success",
			            icon: "success",
					  	buttons: false,
					  	timer: 3000,
			            timer: 15000
					});


				}//en of if
			
			},//end of success
			error: function(data) {

            	message = data.responseJSON.errors.email;
                $('.news-form').addClass('is-invalid');
                $('.newsletter-val-error').text(message);

            },//end of error//end of success

		});//end of ajax

	});//end of click phone

});//end of document redy function