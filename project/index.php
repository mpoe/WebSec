<?php
session_start();
if(!isset($_SESSION['UserID']))
{
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
            <form action="api/sign-up.php" method="post"  enctype="multipart/form-data"> <!-- Needs form information -->
                <input class="Signup_Email" name="email" placeholder="Email address" type="email" tabindex="4" autocomplete="off" id="email">
                <input class="Signup_Avatarname" name="avatarname" placeholder="Avatar name" type="text" tabindex="5"  autocomplete="off" id="avatarname"> <!-- needs tabindex -->
                <input class="Signup_Firstname" name="fname" placeholder="First name" type="text" tabindex="6" autocomplete="off" id="firstname">
                <input class="Signup_Lastname" name="lname" placeholder="Last name" type="text" tabindex="7" autocomplete="off" id="lastname">
                <input class="Signup_phone" name="phone" placeholder="Phone number" type="text" tabindex="8"  autocomplete="off" id="phone">
                <input class="Signup_Password" name="password1" placeholder="Password" type="password" autocomplete="off" tabindex="9" id="password">
                <input class="Signup_Repassword" name="password2" placeholder="Re-password" type="password" tabindex="10" autocomplete="off" id="repassword">
                <input class="Signup_image" name="profileimage" type="file" tabindex="11" >
                <button class="Signup_Btn Reg_Btn" tabindex="12">Register</button>
            </form>
            <div class="Signup_rules">
                <div class="rule_contain"><p class="format_txt">E-mail:</p> <div class="indicator" id="email_format"></div></div>
                <div class="rule_contain"><p class="format_txt">First name:</p> <div class="indicator" id="firstname_format"></div></div>
                <div class="rule_contain"><p class="format_txt">Last name:</p> <div class="indicator" id="lastname_format"></div></div>
                <div class="rule_contain"><p class="format_txt">Phone:</p> <div class="indicator" id="phone_format"> </div></div>
                <div class="rule_contain"><p class="format_txt">Password:</p> <div class="indicator" id="password_format"></div></div>
                <div class="rule_contain"><p class="format_txt">Password match:</p> <div class="indicator" id="match_format"></div>
            </div>
            <p id="bla"></p>
        </div>
    </div>

    <button id="button_help" class="help">Help</button>
    <div id="helped" class="help_contain">
        <p>E-mail format: test@test.com</p>
        <p>First and last name must not contain numbers</p>
        <p>Phone number format: 12 34 56 78</p>
        <p>Password format: Password!</p>
        <p>(Min. 8 characters, 1 uppercase and 1 special character)</p>
    </div>
    <?php

    //If there has been tampering by the user, alert them that we know
    if(isset($_SESSION['tamperingdetected'])){
        ?>
        <script type="text/javascript">
            // Alert the user
            alert("We have detecting possible tampering from your ip");
        </script>
        <?php
        //Remove the login status error notification
        unset($_SESSION['tamperingdetected']);
    }

    //Notify the the user about the registration
    if(isset($_SESSION['registerstatus'])){

     //Convert the status into an array
        $regArray = json_decode($_SESSION['registerstatus']);
       //Iterate through the array and get the description
        for($i=0; $i<count($regArray); $i++){


            if($regArray[$i]->status == "success"){
                //Success notification
                ?>
                <script type="text/javascript">
            // Alert the user
            swal({
              title: "Success!",
              icon: "success",
          });
      </script>
      <?php
  } else{
    //error notification
    ?>
    <script type="text/javascript">
            // Alert the user
            swal({
              title: "Woops something went wrong!",
              icon: "error",
          });
      </script>

      <?php
  }

        //Print out the error
  echo '<strong class="login-error">' . $regArray[$i]->descr . '</strong>';
}
 //Remove the login status error notification
unset($_SESSION['registerstatus']);
}

include("include/footer.php");
}
else
{
    header("Location: feed.php");
}

?>