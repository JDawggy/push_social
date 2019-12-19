<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/conn.php");


$errors = [];


// echo "<pre>";
// print_r($_POST);
// print_r($_update_query);
// exit;

// ------------------------
// *
// *
// *      Update USER
// *
// *
// ------------------------

if( isset($_POST["action"]) && $_POST["action"] == "update" ) :


    if( isset($_SESSION["user_id"]) && ($_SESSION["user_id"] == $_POST["user_id"] || $_SESSION["role"] == 1) ) {  
        

                             // This is where im getting the error you do not have permission to do that

        $user_id =          htmlspecialchars($_POST["user_id"], ENT_QUOTES);
        $first_name =       htmlspecialchars($_POST["first_name"], ENT_QUOTES);
        $last_name =        htmlspecialchars($_POST["last_name"], ENT_QUOTES);
        $city =             htmlspecialchars($_POST["city"], ENT_QUOTES);
        $email =            htmlspecialchars($_POST["email"], ENT_QUOTES);
        $bio =              htmlspecialchars($_POST["bio"], ENT_QUOTES);
        $display_name =     htmlspecialchars($_POST["display_name"], ENT_QUOTES);

        $profile_photo_id = NULL;

        $province_id = (isset($_POST["province_id"])) ? $_POST["province_id"] : "0"; // ? is if true it will return whatever is after and : is if its false it will return what comes after



        // If the profile picture is set ( uploaded a file in the edit profile page ) and there is no errors with the file upload
        if( isset($_FILES["profile_photo"]) && $_FILES["profile_photo"]["error"] == 0 ) {
            if(
                (
                    $_FILES["profile_photo"]["type"] == "image/jpeg" ||
                    $_FILES["profile_photo"]["type"] == "image/jpg" ||
                    $_FILES["profile_photo"]["type"] == "image/png" ||
                    $_FILES["profile_photo"]["type"] == "image/gif"
                ) 
                && 
                $_FILES["profile_photo"]["size"] < 2000000000000
            ) {
                // if statement true - correct file type and size 

                $file_name = $_SERVER["DOCUMENT_ROOT"] . "/uploads/" . $_FILES["profile_photo"]["name"];

                $file_name = explode(".", $file_name);


                //////////// This is to change the name of the file that gets saved so you can upload the same photo ////////

                
                // this will make all the extensions (.jpg, .png. etc..) and make them all lowercase end only works in arrays
                $file_extension = strtolower( end( $file_name ) );

                // this removes the last piece in the array which is now the end extension from above
                array_pop($file_name);

                // add new element to the end of the array and then add the (.png or whatever again to the end)
                $file_name[] =  date("YmdHis");
                $file_name[] =  $file_extension;

                // implode will rebuild the array and you have to specify the (".", between the array names)
                $file_name = implode(".", $file_name);



                //check if the file already exists
                if( !file_exists( $file_name ) ) {


                    // upload file to uploads folder
                    if( move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $file_name) ) {

                        // echo "<pre>";
                        // print_r($_FILES);
                        // exit;

                        

                        // Insert image into database 
                        $insert_image_query = " INSERT INTO photos (url, owner_id) 
                                                VALUES ( '" . str_replace($_SERVER["DOCUMENT_ROOT"], "", $file_name) . "', $user_id)";

                        
                        
                        mysqli_query($conn, $insert_image_query);

                        
                        if( mysqli_query($conn, $insert_image_query) ) {
                            $profile_photo_id = mysqli_insert_id($conn);
                            
                           
                        }

                        
                            

                        
                    }


                } else {
                    $errors[] = "File already exists";
                }



            } else {
                $errors[] = "Incorrect file type or file too large, please limit .";
            } // end if for file size and type

        } // End if profile picture is set








        if( ($first_name == '' || $last_name == '') && !empty($errors) ) {
            $errors[] = "Fields can not be empty";
        } else {

            $update_query =    "UPDATE users 
                                SET first_name =    '$first_name', 
                                    last_name =     '$last_name',
                                    city =          '$city',
                                    email =         '$email',
                                    display_name =  '$display_name',
                                    bio =           '$bio',
                                    province_id =    $province_id";
            $update_query .= ($profile_photo_id != NULL) ? ",profile_photo_id = $profile_photo_id" : "";
            $update_query .= " WHERE id = $user_id";


            

        
            if ( mysqli_query($conn, $update_query) ) {

                header("Location: " . strtok( $_SERVER["HTTP_REFERER"], "?") . "?user_id=" . $user_id . "&success=User+Updated" );
               

            } else {
                $errors[] = mysqli_error($conn);
            }
        }
        

    } else {
        $errors[] = "You do not have permission to do that.";
    }


    // ------------------------
    // *
    // *
    // *   delete USER 
    // *
    // *
    // ------------------------
    

elseif( isset($_POST["action"]) && $_POST["action"] == "delete") :

    

    $user_id = $_POST["user_id"];
    $delete_query = "DELETE FROM users WHERE id = $user_id";
    $select_query = "SELECT * FROM users WHERE id = $user_id";

    if($user_result = mysqli_query($conn, $select_query)) {
        while($user_row = mysqli_fetch_array($user_result)) {
            if($user_row["role"] != 1) {

                if(mysqli_query($conn, $delete_query)) {
                    if($user_row["id"] == $_SESSION["user_id"]) {

                        session_destroy();
                        header("Location: http://" . $_SERVER["SERVER_NAME"] . "/login.php");

                    } else {

                        header("Location: http://" . $_SERVER["SERVER_NAME"] . "/login.php");
                    }
                    
                } else {
                     
                    $errors[] = mysqli_error($conn); 
                }

            } else {
                $errors[] = "Cannot delete super admin";
            }
        }
    }else {
        $errors[] = "User does not exist" . mysqli_error($conn);
    }

    // ------------------------
    // *
    // *
    // *   Update USER password
    // *
    // *
    // ------------------------

elseif( isset($_POST["action"]) && $_POST["action"] == "change_password") :

    $user_id = $_POST["user_id"];
    $current_password = md5($_POST["password"]);
    $new_password = md5($_POST["new_password"]);
    $new_password2 = md5($_POST["new_password2"]);

    $select_query = "SELECT * FROM users WHERE id = $user_id AND password = '$current_password'";

    $select_result = mysqli_query($conn, $select_query);

    if(mysqli_num_rows($select_result) > 0){

        if($new_password == $new_password2){
            
            $update_query = "UPDATE users SET password = '$new_password' WHERE id = $user_id";
            
            if(mysqli_query($conn, $update_query)) {
                header("Location: http://" . $_SERVER["SERVER_NAME"] . "/edit_profile.php?success=Password+Reset");
            } else {
                $errors[] = "something went wrong: " . mysqli_error($conn); 
            }

        } else {
            $errors[] = "New passwords do not match";
        }
    } else {
        $errors[] = "Current password is incorrect " . mysqli_error($conn); 
    } 

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