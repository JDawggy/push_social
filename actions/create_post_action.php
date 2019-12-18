<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/conn.php");

// print_r($_POST); // gets the form data from the add post page

// print_r($_FILES); // Gets the file upload from the add post page


/*

must be logged in
roll is less than 3 = they are a member or the super admin
article is published under current username
take us back to the users articles page

*/

$errors = [];


// user must be logged in with a roll of 2 or 1
if( isset($_SESSION["user_id"]) && ($_SESSION["role"] < 3) ):
    // Get current user by session id
    $user_id = $_SESSION["user_id"];

    $location = htmlspecialchars($_POST["location"], ENT_QUOTES);
    $caption = htmlspecialchars($_POST["caption"], ENT_QUOTES);
    $date_created = date("Y-m-d H:i:s"); 

    
    
    
    // If the profile picture is set ( uploaded a file in the edit user page ) and there is no errors with the file upload
    if( isset($_FILES["uploaded_image"]) && $_FILES["uploaded_image"]["error"] == 0 ) {
        if(
            (
                $_FILES["uploaded_image"]["type"] == "image/jpeg" ||
                $_FILES["uploaded_image"]["type"] == "image/JPEG" ||
                $_FILES["uploaded_image"]["type"] == "image/jpg" ||
                $_FILES["uploaded_image"]["type"] == "image/JPG" ||
                $_FILES["uploaded_image"]["type"] == "image/png" ||
                $_FILES["uploaded_image"]["type"] == "image/gif"
                ) 
                && 
                $_FILES["uploaded_image"]["size"] < 20000000000000000000000
                ) {
                    // if statement true - correct file type and size 
                    
                    
                    
                    $file_name = $_SERVER["DOCUMENT_ROOT"] . "/uploads/" . $_FILES["uploaded_image"]["name"];
                    
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
                        if( move_uploaded_file($_FILES["uploaded_image"]["tmp_name"], $file_name) ) {
                            
                            // Insert image into database 
                            $insert_image_query = "INSERT INTO photos (url, owner_id) VALUES ( '" . str_replace($_SERVER["DOCUMENT_ROOT"], "", $file_name) . "', $user_id)";
                            
                            if( mysqli_query($conn, $insert_image_query) ) {
                                $uploaded_image_id = mysqli_insert_id($conn);
                                
                            } else {
                                $errors[] = "Something sader has happened " . mysqli_error($conn);
                            }
                        } else {
                            $errors[] = "Something sad has happened";
                        }
                        
                        
                    } else {
                        $errors[] = "File already exists";
                    }
                    
                    
                    
                } else {
                    $errors[] = "Incorrect file type or file too large, please limit .";
                } // end if for file size and type
                
            } else { // End if profile picture is set
                $uploaded_image_id = "NULL";
            }
            
            
            
            
            
            
            
            
            
            
            
            
            if($caption != "" && $location != ""){
                // title and content are filled continue                         // date modified 
                


                $query = "  INSERT INTO posts                   
                                (place, caption, image_id, author_id, date_created, date_modified) 
                    VALUES ('$location', '$caption', $uploaded_image_id, $user_id, '$date_created', '$date_created')";

                    // print_r($query);
                    // exit;

                if(mysqli_query($conn, $query)){
                    // get id from last entry to database
                    mysqli_insert_id($conn); 

                    
                    
                    // send me to articles.php page to view articles with out posted article selected specifically 
                    header("Location: http://" . $_SERVER["SERVER_NAME"]);
                } else {
                     $errors[] = "Something went wrong: " . mysqli_error($conn);
                }


            } else {
                // title and content are empty
                $errors[] = "Please fill in all feilds";
            }

else:
    header("Location: http://" . $_SERVER["SERVER_NAME"]);
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