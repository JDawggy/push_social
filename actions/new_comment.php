<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/conn.php");

$errors = [];

if(!isset($_SESSION)) { // Starts a session to pass session variables
    session_start(); 
}  



// Get current user by session id if they are logged in they can leave comments
if ( isset($_POST["action"]) && ( $_POST["action"] == "share_comment" ) && ( $_POST["comment"] != "") ) :


    if( isset($_SESSION["user_id"]) && ($_SESSION["role"] < 3) ):

        $user_id = $_SESSION["user_id"];
        $comment = htmlspecialchars($_POST["comment"], ENT_QUOTES);
        $post_id = $_POST["post_id"];

        //if the comment feild isnt empty their comment can be uploaded to the database
        if($comment != ""){

            $comment_query = "INSERT INTO comments (owner_id, comment, post_id) VALUES ($user_id, '$comment', $post_id)";
            
                                
            if( mysqli_query($conn, $comment_query) ) {

                header( "Location: http://" . $_SERVER["SERVER_NAME"] . "/index.php#thisPost" . $post_id );
                
            } else {
                $errors[] = "Something sader has happened " . mysqli_error($conn);
            }
        }

    endif;

else :

    $errors = "Make sure to leave a comment!". mysqli_error($conn);

endif;


if( !empty($errors) ) { // if there was an error this will check the array for errors and send me back to the page i was on and show the error code

    $query = http_build_query( array("errors" => $errors) );

    header("Location: " . strtok($_SERVER["HTTP_REFERER"], "?") . "?" . $query);
                // STRTOK REMOVIES EVERYTHING IN THE URL AFTER THE ?  
                // AFTER THE STRTOK() . ? TO RESTART THE URL WITH WHAT YOU WANT AT THE END 
                

}   


?>