<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    include("include/header.php");
?>
        
        <video playsinline autoplay muted loop id="bgvid">
            <source src="Video/WoW Places - Mists of Pandaria sightseeing.mp4" type="video/mp4">
        </video>  
        
        <div class="Introduction">
            <h3>AvatarConnect helps you reach out to other avatars online</h3>
            <div class="Intro_Txt">
                Avatars help you find your friends you have met in the virtual world, <br> 
                and share you insites within those virtual worlds. <br>
                
                if you think people you have enjoyed in a game have a presence on our site, <br>
                jump in, create an account and get in contact with them.
            </div>
        </div>
        
        <div class="Signup">
            <div class="regnow">Register now!</div>
            <form action="api/sign-up.php" method="post"> <!-- Needs form information -->
                <input class="Signup_Email" name="email" placeholder="Email address" type="text" tabindex="4" autocomplete="off" id="email">
                <input class="Signup_Avatarname" name="avatarname" placeholder="Avatar name" type="text" autocomplete="off" id="avatarname"> <!-- needs tabindex -->
                <input class="Signup_Firstname" name="fname" placeholder="First name" type="text" tabindex="5" autocomplete="off" id="firstname">
                <input class="Signup_Lastname" name="lname" placeholder="Last name" type="text" tabindex="6" autocomplete="off" id="lastname">
                <input class="Signup_phone" name="phone" placeholder="Phone number" type="text" autocomplete="off" id="phone">
                <input class="Signup_Password" name="password1" placeholder="Password" type="password" tabindex="7" autocomplete="off" id="password">
                <input class="Signup_Repassword" name="password2" placeholder="Re-password" type="password" tabindex="8" autocomplete="off" id="repassword">
                <input class="Signup_image" name="profileimage" type="file">
                <button class="Signup_Btn Reg_Btn" tabindex="9">Register</button>
            </form>
        </div>
        
        <div class="Signup_rules">
            <div class="rule_contain"><p class="format_txt">E-mail:</p> <div class="indicator" id="email_format"></div></div>
            <div class="rule_contain"><p class="format_txt">First name:</p> <div class="indicator" id="firstname_format"></div></div>
            <div class="rule_contain"><p class="format_txt">Last name:</p> <div class="indicator" id="lastname_format"></div></div>
            <div class="rule_contain"><p class="format_txt">Phone:</p> <div class="indicator" id="phone_format"> </div></div>
            <div class="rule_contain"><p class="format_txt">Password:</p> <div class="indicator" id="password_format"></div></div>
            <div class="rule_contain"><p class="format_txt">Password match:</p> <div class="indicator" id="match_format"></div></div>
            <p id="bla"></p>
        </div>
        
        <?php
            include("include/footer.php");
        ?>

        <!-- Email validation -->
        <script type='text/javascript'>
        $(document).ready(function () {
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
        });
    </script>
    
    <!-- name validation -->
    <!-- First name -->
    <script>
$(document).ready(function () {       
    $("#firstname").keyup(function() {
        
    if($(this).val().match('^[a-zA-Z]{3,16}$')){
        
        $("#firstname_format").text("Valid name");
        $("#firstname_format").css("background-color", "green");
        
    } 
    else{
        $("#firstname_format").text("Invalid name");
        $("#firstname_format").css("background-color", "red");
    }
    });

});
    </script>
    <!-- Last name -->
    <script>
$(document).ready(function () {       
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

});
    </script>
    <!-- Phone -->
    <script>
    $(document).ready(function () { 
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
});
    </script>
    
    <!-- Password validation -->
    <script>
    $(document).ready(function(){
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
    });
    </script>
    <!-- Password match -->
    <script>
    $(document).ready(function(){
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
    });
    </script>
    
    <button id="button_help" class="help">Help</button>
    <div id="helped" class="help_contain">
        <p>email format: test@test.com</p>
        <p>first and last name must not contain numbers</p>
        <p>phone number format: 12 34 56 78</p>
        <p>password format: abcdefgh1!A 8</p>
        <p>(8 characters, 1 special character, 1 digit and 1 uppercase)</p>
    </div>
    
    <script>
    $('#button_help').click(function(){
   $('#helped').toggle();
});
    </script>
    
    </body>
</html>
