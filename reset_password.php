<?php

include_once("conn.php");

$user_id = (isset($_GET["user_id"]) ) ? $_GET["user_id"] : $_SESSION["user_id"];

$user_query = "SELECT * FROM users WHERE id = " . $user_id; 

if ( $user_request = mysqli_query($conn, $user_query) ) :
    

    while ($user_row = mysqli_fetch_array($user_request)) :
    
        print_r($user_row);
    

    

?>

<html>
    <head>
    
        <title></title>

        
        <link rel="stylesheet" href="/edit-profile-styles.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">

        <script src="https://kit.fontawesome.com/ea81b73834.js" crossorigin="anonymous"></script>


    </head>
    <body>


    

        <div class="container">
            <div class="row">
                <div class="col-12">

                    <h1>Change <?php echo $user_row["first_name"] . " " . $user_row["last_name"]; ?>'s Password</h1>

                    <form action="edit_user.php" method="post">

                        <?php

                        include_once($_SERVER["DOCUMENT_ROOT"] . "/includes/error_check.php"); //error check auto outputs error messages
                        ?>

                            <input type="hidden" name="user_id" value="<?php echo $user_row["id"] ?>">

                            <div class="form-row">

                                <div class="col-12 mb-3">
                                    <input type="password" name="password" placeholder="Current Password" class="form-control">
                                </div>

                                <div class="col">
                                    <input type="password" name="new_password" placeholder="New Password" class="form-control">
                                </div>

                                <div class="col">
                                    <input type="password" name="new_password2" placeholder="Confirm New Password" class="form-control">
                                </div>

                            </div>

                            <hr>

                            <?php

                                if($_SESSION["user_id"] == $user_id || $_SESSION["role"] == 1) :

                            ?>

                            <div class="text-right ml-auto">

                                <a href="#" onclick="history.go(-1)"></a>
                                <button type="submit" name="action" value="change_password" class="btn btn-warning" tabindex="3">Update Password</button>
                            </div>

                            <?php

                                endif;

                            ?>

                    </form>

                </div>
            </div>
        </div>








        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <script src="/scripts.js"></script>
  </body>
</html>

<?php

endwhile;

else :
    echo mysqli_error($conn);
endif; 


///////////////////////////////////
///    check for errors array
//////////////////////////////////

if( !empty($errors) ) { // if there was an error this will check the array for errors and send me back to the page i was on and show the error code

    $query = http_build_query( array("errors" => $errors) );

    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?" . $query);
                // STRTOK REMOVIES EVERYTHING IN THE URL AFTER THE ?  
                // AFTER THE STRTOK() . ? TO RESTART THE URL WITH WHAT YOU WANT AT THE END 
                

}   

?>