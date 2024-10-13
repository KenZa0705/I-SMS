$(document).ready(function(){
    $('#login_form').validate({

        rules:{
            
            email:{
                required: true,
                email: true
            },

            password:{
                required: true,
                minlength: 6
            }

        },

        highlight: function(element) {  
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }

    })
});

$(document).ready(function(){
    $('#new_password_form').validate({

        rules:{
            
            email:{
                required: true,
                email: true
            },

            password:{
                required: true,
                minlength: 6
            }

        },

        highlight: function(element) {  
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }

    })
});

$("#signin").click(function (event) {
    event.preventDefault();

    if ($("#login_form").valid()) {
        var recaptchaResponse = grecaptcha.getResponse();

        if (recaptchaResponse.length === 0) {
            alert("Please complete the recaptcha");
        } else {
            $("#login_form").submit();
        }
    }
});

//for password reset 
var modal = document.getElementById("resetPasswordModal");
var btn = document.getElementById("resetPasswordBtn");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
  modal.style.display = "block";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

