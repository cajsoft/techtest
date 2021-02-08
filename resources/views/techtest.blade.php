<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Profile</title>
        
    	 <!-- Scripts -->
    	<script src="{{ asset('js/app.js') }}"></script>
    	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    	<!-- Styles -->
    	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    	
    	<link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
    	<style>
      		body {
			font-family: 'Open Sans', sans-serif;
			 margin: 0;
    		 padding: 0;
    		 float: left;
    		 background-image: url("{{url('/images/background.png')}}");
	      	}
			
			.left-header {
 				 float: left;
 				 color: red;
 				 font-size: 20px;
  				 padding: 15px;
			}

			.right-header {
			  float: right;
			  padding: 15px;
			  font-size:10px;
			}

			

			#container 
			{ 
		     left: 636px; 
		     top: 189px; 
		     position: absolute; 
		     width: 648px;
		     height: 720px;
		     z-index:2;
			} 
			#lock-modal {
		  display: none;
		  background-color: black;
		  opacity: 0.6;
		  position: absolute;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  border-radius: inherit;
		}

	
		@keyframes spin {
		  0% {
		    transform: rotate(0deg);
		  }
		  100% {
		    transform: rotate(360deg);
		  }
		}

		#profile_photo {
			padding: 0;
		}

		#submit {
			padding: 1em 0em 0em 0em;
		}

		.spinner-border {
    position: absolute;
    
    z-index: 9999;
    display: none;
    
}
    	</style>
    </head>
    <body class="profile_body">
    <div id="background">
    	<!--<div id="Background"><img src="{{url('/images/background.png')}}"></div>-->
		<div id="container" class="container">
		<form class="form-horizontal"  enctype="multipart/form-data">
			
		<fieldset>

		<!-- Form Name -->
		<p class="left-header">Get Started</p>
		<p class="right-header">* Donates required field</p>
		<!-- Text input-->

		<!-- Text input-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="name" style="max-width:100%;">Whats your name? *</label>  
			<div class="col-md-4">
				<input id="name" name="name" type="text" placeholder="name" class="form-control input-md" required="">	
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label" for="email">Email address *</label>  
			<div class="col-md-4">
				<input id="email" name="email" type="text" placeholder="email" class="form-control input-md" required="">	
			</div>
		</div>

		

		<!-- File Button --> 
		<div class="form-group">
			<label class="col-md-4 control-label" for="profile_photo">Profile photo</label>
			<div class="col-md-4">
				<input id="profile_photo" name="profile_photo" class="btn btn-small" type="file">
				<input id="submit" type="submit" value="Submit" class="btn">
			</div>
		</div>
		<div class="form-group">
            <b><span class="text-success" id="success-message"> </span><b>
        </div>
		</fieldset>
		
  			<span class="spinner-border spinner-border-sm"></span>
		</form>
		
      </div>

    </body>
</html>
 <script type="text/javascript">
 	$('.spinner-border').hide();
 	$.ajaxSetup({
   		headers: {
    	 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   		}
   		
	});

    $('.form-horizontal').submit(function(event){
        event.preventDefault();
      	var formData = new FormData($(this)[0]);
        $.ajax({
          processData: false,
		  contentType: false,
          url: "/postform",
          type:"POST",
          data:formData,
           beforeSend: function() {
		     $('.spinner-border').show();

		   },
		 	complete: function(){
		     $('.spinner-border').hide();
			},
	        success:function(response){
            console.log(response);
            var first_name = $('#name').val().split(' ')[0]
            var success = "Thanks " + first_name + ", Your data has been submitted to the database.";
            $('#success-message').text(success);
          },
          error: function(data){
            console.log(data);
    	  }
    	});
    }); 
 </script>	

<script>

$(document).ready(function() {
  const lockModal = $("#lock-modal");
  const loadingCircle = $("#loading-circle");
  const form = $(".form-horizontal");


  form.on('submit', function(e) {
    e.preventDefault(); //prevent form from submitting


    // lock down the form
    lockModal.css("display", "block");
    loadingCircle.css("display", "block");

    form.children("input").each(function() {
      $(this).attr("readonly", true);
    });


    setTimeout(function() {
      // re-enable the form
      lockModal.css("display", "none");
      loadingCircle.css("display", "none");

      form.children("input").each(function() {
        $(this).attr("readonly", false);
      });

    }, 3000);
  });

});
</script>

