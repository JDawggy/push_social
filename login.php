<?php

include_once( $_SERVER["DOCUMENT_ROOT"] . "/conn.php");

$errors = [];



// if the button VALUE was login 
if( isset( $_POST["action"]) && $_POST["action"] == "login" ) :
    // get the users email and password
    // connect to users table 
    // check if user exists and password matches
    // if not send error
    // if true, login and go to index

    if( 
        ( isset($_POST["email"]) && $_POST["email"] != "" ) &&
        ( isset($_POST["password"]) && $_POST["password"] != "" )
      ) {

        $email = $_POST["email"];
        $password = md5($_POST["password"]);


        $query_users = "SELECT *
                        FROM users
                        WHERE email = '" . $email . "' AND password = '" . $password . "' 
                        LIMIT 1";

        $user_result = mysqli_query($conn, $query_users);

        // Check if user is in database

        // print_r( $query_users ); // to check if im getting a result from the limit =  1

        if( mysqli_num_rows($user_result) > 0 ) {
            // User Found!!!
            while( $user = mysqli_fetch_array($user_result)) {
                // print_r($user);
                session_destroy(); // Destroy current session
                session_start(); //Start a new session

                $_SESSION["email"] = $user["email"];
                $_SESSION["role"] = $user["role"];
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["first_name"] = $user["first_name"];
                $_SESSION["last_name"] = $user["last_name"];

                header("Location: http://" . $_SERVER["SERVER_NAME"]);  // I think this is the piece that takes me to the next page if its all good
            }
        } else {
            $errors[] = "Email or Password Incorrect.";
        }

        // echo $password; to check that the php is getting my password on login from the VALUE of the button

    } else {
        $errors[] = "Please Fill Out Username & Password";
    }


    // if the button VALUE was signup

elseif( isset( $_POST["action"]) && $_POST["action"] == "signup" ) :

        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        $password2 = md5($_POST["password2"]);
        $city = $_POST["city"];
        $province_id = ( isset($_POST["province"]) ) ? $_POST["province"] : 0;
        $date_created = date("Y-m-d H:i:s");

        // echo "<pre>";
        // print_r($_SERVER);
        // echo "</pre>";

        if($password == $password2 && strlen($password) > 7){
            // Continue
            
            if($email != "" && $first_name != "" && $last_name != ""){
                //  Successfull Submition

                $new_user_query = " INSERT 
                                    INTO users 
                                    (email, 
                                    password, 
                                    role, 
                                    city, 
                                    province_id,
                                    date_created, 
                                    first_name, 
                                    last_name) 
                                    VALUES 
                                    ('$email', 
                                    '$password', 
                                    2, 
                                    '$city', 
                                    $province_id, 
                                    '$date_created',
                                    '$first_name', 
                                    '$last_name') ";

                if ( !mysqli_query($conn, $new_user_query) ){
                    echo mysqli_error($conn);
                } else {
                    // Log user in and go to home page 
                    $user_id = mysqli_insert_id($conn);

                    session_destroy();
                    session_start();

                    $_SESSION["user_id"] = $user_id;
                    $_SESSION["role"] = 2;
                    $_SESSION["email"] = $email;

                    header("Location: http://" . $_SERVER["SERVER_NAME"]);
                }

                //  Successfull Submition End
            } else {
                $errors[] = "Please fill-out required feilds";
            }
            
        } else {
            $errors[] = "Passwords do not match";
        }


    // If the Logout button is clicked 

elseif( isset( $_REQUEST["action"]) && $_REQUEST["action"] == "logout" ) :

    session_destroy();
    header("Location: http://" . $_SERVER["SERVER_NAME"] . "/login.php");
    
endif;




if( !empty($errors) ) {

    $query = http_build_query( array("errors" => $errors) );

    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?" . $query);
    
}

?>

<html>
    <head>
    
        <title></title>

        
        <link rel="stylesheet" href="/login-register-styles.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">

        <script src="https://kit.fontawesome.com/ea81b73834.js" crossorigin="anonymous"></script>


    </head>
    <body>
        <div class="container container-size">

            <div class="row row-size">

                <div class="col-1"></div>

                <div class="col-10 center-position">

                    <div class="background-none">


                        <div class="row">
                            <span class="mb-4 user-center">
                                <i class="fas fa-user-circle fa-5x"></i>
                            </span>
                        </div>

                            
                        
                        <!-- Login form  -->
                        <form action="login.php" method="POST"> 
            
            
            
                            <!-- Email -->
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="form-group col-md-6"> 
                                    <div class="input-icons">
                                        <i class="fas fa-envelope"></i>
                                        <input class="rounded-pill form-control" type="email" name="email" placeholder="Email" value="" required>                 
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div> <!-- end of row -->
                            
                        
                            <!-- Password -->
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="form-group col-md-6">                                              
                                    <div class="input-icons">
                                        <i class="fa fa-lock"></i>
                                        <input class="rounded-pill form-control" type="password" name="password" placeholder="Password" value="" required>          
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div> <!-- end of row -->
                            
            
                            <!-- Sumbit button for login form -->
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="form-group col-md-6"> 

                                    <button class="btn btn-warning rounded-pill form-control mb-2" type="submit" name="action" value="login">Login</button>

                                    <a href="/signup.php" class="create text-warning text-center">Create an Account!</a>
                                    
                                </div>
                                
                                <div class="col-md-3"></div>
                            </div>
            
                        </form> <!-- login form -->
                    </div>
                </div>
                <div class="col-1"></div>
            </div>
            
            
        </div> <!-- Container div -->
    </body>
</html>