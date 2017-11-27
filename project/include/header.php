<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/mainstyle.css">
    <link rel="stylesheet" type="text/css" href="css/wall.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <title>Avatar Connect</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Avatar Connect</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            </ul>

            

            <?php
            if(!isset($_SESSION['UserID']))
            {
                ?>
                <form class="form-inline my-2 my-lg-0" action="api/login.php" method="post"> <!-- Needs form information -->
                    <?php 

                    //If there is a login status
                    if(isset($_SESSION['loginstatus'])){
                        //Convert the status into an array
                        $loginArray = json_decode($_SESSION['loginstatus']);

                        //Iterate through the array and get the description
                        for($i=0; $i<count($loginArray); $i++){
                            //Print out the error
                            echo '<strong class="login-error">' . $loginArray[$i]->descr . '</strong>';
                            //Update user input as invalid
                            ?>
                            <input type="email" class="form-control mr-sm-2 is-invalid" name="login-email" placeholder="E-mail"  tabindex="1" >
                            <input class="form-control mr-sm-2 is-invalid" name="login-password" placeholder="Password" type="password" tabindex="2">
                            <?php
                        }
                        //Remove the login status error notification
                        unset($_SESSION['loginstatus']);
                    } else{
                         //Show normal inputs
                        ?>
                        <input type="email" class="form-control mr-sm-2" name="login-email" placeholder="E-mail"  tabindex="1">
                        <input class="form-control mr-sm-2" name="login-password" placeholder="Password" type="password" tabindex="2">
                        <?php 

                    }                    ?>
                    <button class="btn" tabindex="3">Log in</button>
                </form>
                <?php
            }
            else
            {
                ?>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="nav-search" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="dropdown-menu bd-search-results" id="search-results"></div>
                </form>
                <form class="form-inline my-2 my-lg-0" action ="api/logout.php">
                    <button class="btn" id="btn-logout">Log out</button>
                </form>
                <?php
            }
            ?>
        </div>
    </nav>