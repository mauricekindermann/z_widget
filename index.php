<html>
<head>
	<title>Zendesk Custom Widget Demo</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <style type="text/css">

    /* Help Button Styles via Elegant Themes */
	.at-help-btn {
	    z-index: 100;
	    position: fixed;
	    right: 20px;
	    bottom: 20px;
	    display: -webkit-inline-box;
	    display: -webkit-inline-flex;
	    display: -ms-inline-flexbox;
	    display: inline-flex;
	    -webkit-box-align: center;
	    -webkit-align-items: center;
	    -ms-flex-align: center;
	    align-items: center;
	    -webkit-box-orient: horizontal;
	    -webkit-box-direction: normal;
	    -webkit-flex-direction: row;
	    -ms-flex-direction: row;
	    flex-direction: row;
	    background: #faa403;
	    padding: 9px;
	    border-radius: 100px;
	    color: #fff !important;
	    font-size: 16px !important;
	    text-decoration: none !important;
	    -webkit-transition: 0.3s ease;
	    transition: 0.3s ease
	}

	.at-help-btn:hover {
	    background: #c88302;
	}

	.at-help-btn__icon {
	    border-radius: 100%;
	    width: 32px;
	    height: 32px;
	    padding: 2px
	}

	.at-help-btn__icon img {
	    display: block;
	    width: 100%
	}

	.at-help-btn__text {
	    display: none
	}

	.at-help-btn__text span {
	    padding: 0 15px 0 10px
	}

	/* Custom Modal Header Styles */
	.modal-header {
		background: #f5f5f5;
		border-radius: 5px 5px 0 0;
	}
	.modal-title{
		font-size:16px;
		font-weight:bold;
	}

	/* Custom Help Button Effects + Anchor Bottom Right on Large Screens */
	#contactModal.modal {
		margin:0;
	}

	@media (min-width: 768px){

		#contactModal.modal .modal-dialog{
		    position: absolute;
		    bottom: 0;
		    right: 40px;
		    margin:0;
		}
		#contactModal.modal .modal-content{
			border-radius: 5px 5px 0 0;
	    	border-bottom: 0;
		}

		#contactModal.modal.fade-scale {
			transform: translate3d(0, 100%, 0);
			opacity: 0;
			-webkit-transition: all .25s linear;
			-o-transition: all .25s linear;
			transition: all .25s linear;
		}
		#contactModal.modal.fade-scale.in {
			opacity: 1;
			transform: none;
		}

	}

    </style>
</head>
<body>

<!-- Hidden Modal -->
<form id="contactModal" method="POST" action="zendesk.php" name="zendesk" class="modal bs-example-modal-sm fade-scale" tabindex="-1" role="dialog" data-backdrop="static" data-toggle="validator" data-disable="true" data-focus="false">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">

    			<button type="button" class="close close-modal" data-dismiss="modal"><span>&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Contact Us</h4>

			</div>
			<div class="modal-body">

				<div class="toggle-success text-center" style="display:none;"><img src="tick_success.png"></div>
				<div class="toggle-form">
					
					<input type="hidden" value="web_widget" id="z_tag" name="z_tag">
					<input type="hidden" value="<?="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" id="z_page" name="z_page">

					<div class="form-group">
						<label class="control-label" for="z_name">Your Name</label>
						<div class="controls">
							<input type="text" class="form-control" value="" id="z_name" name="z_name" placeholder="Your Name" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="z_requestor">Email Address</label>
						<div class="controls">
							<input  type="text" class="form-control" value="" id="z_requester" name="z_requester" placeholder="Email" required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="form-group no_margin">
						<label class="control-label" for="z_description">How can we help you?</label>
						<div class="controls">
							<textarea class="form-control input-lg-desktop-onl" id="z_description" rows="5" name="z_description" placeholder="How can we help you?" data-minlength="5" required></textarea>
						</div>
					</div>

				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link close-modal" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-warning" id="submitContactModal">Send</button>
			</div>
		</div>
	</div>
</form>

<a href="#contactModal" class="at-help-btn" type="button" data-toggle="modal" data-target="#contactModal"><div class="at-help-btn__icon"> <svg width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <image x="9" y="9" width="32" height="32" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABGdBTUEAA1teXP8meAAABN1JREFUaAXtmUuMVEUUhnsQGAEVwiBkUGPc6MqAD5SlwTVGo4HExA2BuNGdBuLKGBS3EkbAmLjTGBfGOOJGjTHu1BiIUfFFfBBjABegDJBA+/1jd3Pmv1X30d2DC/sk/9w6p/5z6lTd6qq6Na3WSEYj8P8egbFhdL/dbi8gzj1gE7gb3AomwbVAcgb8Do6Cz8FH4LOxsbFLPP87IfGbwIvgOGgqv+KwB9xwxXtAo6vAQXABDCrnCbAfTFyRjtDQo+AUGLacJODWeesEwReBV0qyPk3d62A72AAmwOIO9MZk2wHeAGdATl6mYuFQO0LApeBQpsXvsG8DS+o2Clfx1NHvQUqmMdaOV9ougTTy7ydaOYvtKdD3aOGr2DvBDHB5F0PfsXudIkhq2mjkbu+RBiwQax34EbhMDRSaaPrBunyJYXUuMHV3gANAU0srjHAUaKVZV+K3hvrDwGVLzqfUTpTrga82Gvlk8tiXgFdBmVyiUp27OtU4dnXC38QJbCtT/FIbTgdBFM355LTBruQ/ieSK8sfU5zqxnrpz5r+vNFmvxFk77AUL8rTzujq8qpG3ULPq/q6/P6ndZQ7q0FrnZXXIOh5E0XxOrgjYNeddvsawGWi5XAYeAN+CKJpOyd8Edq1OP0Qy5eezCccKiAvAcXPeFjmxDO+AcZX88shRGdsK4J3IrjJwd4Aov6BUHz4hbYxelLXDZjcV6vR2omz25Ls6pAcjkfI33Tp/Uqc395fxNzhPx2AXHYmjTHPsnYkGK99s+oemR/WDqFC+xfSeSpt/o7zXM/xbuN/0VqoDOs9H0dk9KzQ0DqKczZJbraus7qLprnrbdzkh1QF9jEQ5HJUByw+Zf1Vsr7/N/Isqc843r6Gc04mr9f1Pm9OPFTO4bIG72vgnLtdmSjj4+r84Q61tJuYjwI/Qb2MrXVWoHwdRzlc2CnuoHSDe7phBp3yIZ3Zl6yYJp68O+BRa1Q3Y9EkCz3YSjo/XUJKboseH19cU+iq2Rrmw9npDKR0/7dAXLdZUipuz4et70hHnplYhXX1EWR+VBuUn4Mb4n6I/2cBfVD9qeG5zGujG1r1NlE1RaVC+z7jPsVk0vQfyjctzsyZQeW332mvX6rG0yCy34KMPmSjLyj3m1uJ4DfCjhG+yc52k4aTD3G8gyvYic34tNP54TIDyz6B02e1lBHGPOetLbFGPMM8F2tJ1zE+Ww+7azeJ4I/ApsLN2AIjWeLuh7zPmfw59skkMJaCP8CgzKL4qZGNGR5WzRKuAeidQwlH2Gq1axXsC6Lovij6411R79/cGiD0JjoEof6CsqNNmgYPj1hipU9bVR2Un3K8Q3AzwlfwR90N/2KjNVAL4VFIbehP9bnCFBIilaXMMuDSfOh6diAvBtEdG129iF+h7dcJXq41+sD7nMbXfAf4B5OnV0wmke59UJzDP3h7oA7z2RgVXm5TWeV8qMc2Kkq88rdbLvsMioN7E1Gz49B/t2G8CJbYR6CQ53oHKsqnuLeA7LKae7KU0nJFP9ZDgW4Cu+4YtWm0G+8GmEk7ZaGgl2AdScxdzI1GMl0B/S2Uqwbo2Gl0LXgC6dGoqOtvoa63ZDmvJ1TscmZOrJKFzv648dPzVU7cHSuw6IDkN4r9ZdXf0Bcfr2ju0goxkNAKjESiOwD8N88OiY3W3TgAAAABJRU5ErkJggg==" transform="translate(-11 -11)" fill="none" fill-rule="evenodd"></image> </svg></div><div class="at-help-btn__text"> <span>Help</span></div> </a><!--Scripts-->

<!-- jQuery 1.11.3 -->			<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Twitter Bootstrap -->		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
<!-- Bootstrap Validator -->	<script src="//cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

<script>
$(document).ready(function() {

    //Help Button
    $('.at-help-btn').hover(function(){
        $(this).children('.at-help-btn__text').stop().animate({
            width:'toggle', opacity:'toggle',
        },
        300);
    });

    //Custom Modal Interactions
    $('#contactModal').on('show.bs.modal', function (event)    {
        var modal = $(this); //Help Button
        var button = $(event.relatedTarget); //Button that triggered the modal

        $(button).hide();

        $('.close-modal').on('click', function (e) {
            $(modal).modal('hide');
            $(button).show();
        });

        $('#contactModal').validator().on('submit', function (e)
        {
            if (e.isDefaultPrevented())
            {
                // handle the invalid form...
            }
            else
            {
                e.preventDefault();

                //Disable button after successful Submission
                $('#submitContactModal').prop('disabled', true); 

                //Process Zendesk API cURL Request
                $.ajax({
                    type: 'POST',
                    url: 'zendesk.php',
                    data: $('#contactModal').serialize(),
                    success: function ()
                    {
                        //Show Success Message
                        $('#contactModal').closest('form').find("textarea").val("");

                        $(".toggle-form").hide();
                        $(".toggle-success").show();

                        $(".modal-footer").hide();

                        modal.find('.modal-title').text("Message Sent");

                        //Reset the Form
                        setTimeout(function()
                        {
                            $(modal).modal('hide');
                            $(".toggle-success").hide();
                            $(".toggle-form").show();
                            $(".modal-footer").show();
                            modal.find('.modal-title').text("Contact Us");
                            $('#submitContactModal').prop('disabled', false);

                            //Show Help Button Again
                            $(button).show();
                        }, 2000);
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>