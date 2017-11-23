<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/mainstyle.css">
        <link rel="stylesheet" type="text/css" href="css/wall.css">
        <title></title>
    </head>
    <body>
        
    <div class="TopBar">
        <div class="TopBar_Logo">Avatar Connect</div>
        <div class="TopBar_Greet">Welcome to AvatarConnect!</div>

        <?php
            if(!isset($_SESSION['UserID']))
            {
                ?>
                <form action="api/login.php" method="post" class="TopBar_Form"> <!-- Needs form information -->
                    <button class="Login_Btn" tabindex="3">Log in</button>
                    <input class="TopBar_Password" name="login-password" placeholder="Password" type="password" tabindex="2">
                    <input class="TopBar_Username" name="login-email" placeholder="E-mail"  tabindex="1">
                </form>
                <?php
            }
            else
            {
                ?>
                <button class="Logout_Btn" >Log out</button>
                <?php
            }
        ?>
        
        
    </div>