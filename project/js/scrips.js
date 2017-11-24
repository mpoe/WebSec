    

$(document).ready(function () {
    /*******************************/
    /* First name validation */
    $('#email').keyup(function () {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        if (re.test($(this).val())) {

            $("#email_format").text("Correct");
            $("#email_format").css("background-color", "green");



        } else {

            $("#email_format").text("Incorrect");
            $("#email_format").css("background-color", "red");
        }
    });

    /*******************************/
    /* Last name validation */
    $("#lastname").keyup(function() {

        if($(this).val().match('^[a-zA-Z]{3,16}$')){

            $("#lastname_format").text("Valid name");
            $("#lastname_format").css("background-color", "green");

        } 
        else{
            $("#lastname_format").text("Invalid name");
            $("#lastname_format").css("background-color", "red");
        }
    });

    /*******************************/
    /* Phone number validation */
    $('#phone').keyup(function () {
        var re = /^(([1-9]\d{0,2}[ ])|([0]\d{1,3}[-]))((\d{2}([ ]\d{2}){2})|(\d{3}([ ]\d{3})*([ ]\d{2})+))$/i;

        if (re.test($(this).val())) {
            $("#phone_format").text("Valid number");
            $("#phone_format").css("background-color", "green");
        } 
        else {
            $("#phone_format").text("Invalid number");
            $("#phone_format").css("background-color", "red");
        }
    });

    /*******************************/
    /* Password validation */
    $("#password").keyup(function(){

        if($(this).val().match('^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}')){
            $("#password_format").text("Valid password");
            $("#password_format").css("background-color", "green");
        }
        else{
            $("#password_format").text("Invalid password");
            $("#password_format").css("background-color", "red");
        }
    });

    /*******************************/
    /* Re-password check validation */
    $("#repassword").keyup(function(){
       if($(this).val().match($("#password").val())){
           $("#match_format").text("Password matches");
           $("#match_format").css("background-color", "green");
       } 
       else{
           $("#match_format").text("Password doesn't match");
           $("#match_format").css("background-color", "red");
       }
   });

    /*******************************/
    /* Help button */
    $('#button_help').click(function(){
        $('#helped').toggle();
    }); 
});