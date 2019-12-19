<?php

include_once("conn.php");

$user_id = (isset($_POST["user_id"]) ) ? $_POST["user_id"] : $_SESSION["user_id"];

$user_query = " SELECT users.*, photos.url AS profile_photo
                FROM users 
                LEFT JOIN photos
                ON users.profile_photo_id = photos.id
                WHERE users.id = " . $user_id; 

require "header.php";

if ( $user_request = mysqli_query($conn, $user_query) ) :

    while ($user_row = mysqli_fetch_array($user_request)) :
    
        
        // print_r($user_row);
        

    

?>


<div class="bodyimage">
<div class="container container-size">
    
    <div class="row row-size">

        <div class="col-1"></div>
        <div class="col-10 center-position">

            <div class="profile-background-white">
                <div class="row">

                    <div class="col-1">

                        <a class="decor-none" href="index.php" id="" role="button">

                            <i class="fas fa-chevron-left fa-2x"></i>

                        </a>

                    </div>

                    <div class="col-10">
                        <h2 class="mb-4 create mx-auto"> Edit Profile</h2>
                    </div>
                    
                    <div class="col-1 dropdown">

                        
                            <a class="decor-none" href="#" id="" role="button" data-toggle="dropdown">

                                <i class="fas fa-cog fa-2x"></i>

                            </a>

                            <div class="dropdown-menu dropdown-menu-right">

                                <a class="dropdown-item decor-none" href="/reset_password.php">Change Password</a>
                            
                                <div class="dropdown-divider"></div>

                                <form action="/actions/edit_user_action.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $user_row["id"]; ?>">

                                    <button class="dropdown-item" type="submit" name="action" value="delete">Delete Account</button>
                                </form>
                            </div>
                        
                    </div>




                </div>
                
                
                <!-- Register form  -->
                <form action="/actions/edit_user_action.php" method="POST" enctype="multipart/form-data"> 
    
    
                    <!-- Profile Photo -->
                    <div class="row mb-2 mt-3">
                        <div class="form-group col-md-6"> 

                            <div class="row mt-4">

                                <?php
                                
                                // echo "<pre>";
                                // print_r($user_row);


                                


                                if ( !isset($user_row["profile_photo_id"]) ) {
                                    
                                    ?>

                                    <div class="circular-landscape mx-auto mb-5">
                                        <img class="mx-auto mb-5" id="profileDisplay" onclick="uploadProfile()" src="/images/NoProfilePhoto.jpg" alt="">
                                    </div>
                                    
                                    <?php

                                } else {
                                    
                                    ?>

                                    <div class="circular-landscape mx-auto mb-5">
                                        <img class="mx-auto mb-5" id="profileDisplay1" onclick="uploadProfile1()" src="<?= $user_row["profile_pic"]; ?>" alt="">
                                    </div>
                                    
                                    <?php
                                }

                                ?>
                                
                                
                            </div>

                            <div class="row">

                                <label class="btn btn-default btn-file mx-auto">
                                     <span class="upload-photo">Upload Profile Photo</span> 
                                     <input class="profile_in_feilds" type="file" name="profile_photo" onchange="displayProfile(this)" id="uploadedProfile" style="display: none;">
                                     
                                </label>


                            </div>

                            
                           
                        
                        </div>
        
        
                        <!-- Bio -->
                        <div class="form-group col-md-6 mt-5"> 
                            <div class="input-icons">
                                <i class="fas fa-user"></i>
                                <textarea class="form-control form-rounded profile_ta" name="bio" id="" placeholder="Bio" cols="30" rows="7"><?= $user_row["bio"]; ?></textarea>
                                
                            </div>
                        </div> <!-- end of form group -->
                    </div> <!-- end of row -->
            
                    
                    <!-- ID -->
                    
                    <input type="hidden" name="user_id" value="<?php echo $user_row["id"]; ?>">                 
                            
        
    
                    <!-- First Name -->
                    <div class="row mb-2">
                        <div class="form-group col-md-6"> 
                            <div class="input-icons">
                                <i class="fas fa-signature"></i>
                                <input class="rounded-pill form-control profile_in_feild" type="text" name="first_name" placeholder="First Name" value="<?php echo $user_row["first_name"]; ?>" required>                 
                            </div>
                        </div>
        
                    
                        <!-- Last Name -->
                        <div class="form-group col-md-6"> 
                            <div class="input-icons">
                                <i class="fas fa-signature"></i>
                                <input class="rounded-pill form-control profile_in_feild" type="text" name="last_name" placeholder="Last Name" value="<?php echo $user_row["last_name"]; ?>" required>  
                            </div>               
                        </div> <!-- end of form group -->
                    </div> <!-- end of row -->




                    <!-- Display Name -->
                    <div class="row mb-2">
                        <div class="form-group col-md-6"> 
                            <div class="input-icons">
                                <i class="fas fa-user-friends"></i>
                                <input class="rounded-pill form-control profile_in_feild" type="text" name="display_name" placeholder="Display Name" value="<?php echo $user_row["display_name"]; ?>">                 
                            </div>
                        </div>
        
                    
                        <!-- Email -->
                        <div class="form-group col-md-6"> 
                            <div class="input-icons">
                                <i class="fas fa-envelope"></i>
                                <input class="rounded-pill form-control profile_in_feild" type="email" name="email" placeholder="Email" value="<?php echo $user_row["email"]; ?>" required>  
                            </div>              
                        </div> <!-- end of form group -->
                    </div> <!-- end of row -->
                    
    
    
                    
                
                    <!-- City -->
                    <div class="row mb-">
                        <div class="form-group col-md-6">                                              
                            <div class="input-icons">
                                <i class="fa fa-city"></i>
                                <input class="rounded-pill form-control profile_in_feild" type="text" name="city" placeholder="City" value="<?php echo $user_row["city"]; ?>">
                            </div>
                        </div>
                    


        
                        <!-- Province -->
                        <div class="form-group col-md-6">                                               
                            <div class="input-icons">
                                <select class="form-control select-rounded" name="province_id" id="province_id">
                                    
                                    <?php  

                                    $province_query = "SELECT * FROM provinces";

                                    if( $province_results = mysqli_query($conn, $province_query) ) :
                                        
                                        echo "<option class='profile_opt' disabled ";
                                        if(!$user_row["province_id"]) echo "selected";
                                        echo ">Province</option>";

                                        while($province = mysqli_fetch_array($province_results)) :
                                            ?>
                                            <option class="profile_opt" value="<?= $province["id"];?>" <?php 
                                                if($province["id"] == $user_row["province_id"]) echo " selected";
                                            ?>><?= $province["name"]; ?></option>
                                            <?php
                                        endwhile;

                                    else :
                                        echo mysqli_error($conn);
                                    endif;



                                    

                                    ?>
                                </select> 
                            </div>
                        </div> <!-- end of form group -->
                    </div> <!-- end of row -->
                    
    
                    <!-- Sumbit button for edit profile form -->

                    <div class="row">
                        <div class="col-md-3">

                                <!-- <button class="btn rounded-pill form-control mt-4" type="submit" name="" value="">Change Password</button> -->
                        </div>
                        <div class="form-group col-md-6 mt-4"> 
                            <button class="btn register-button btn-warning rounded-pill form-control" type="submit" name="action" value="update">Update Account</button>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
    
                </form> <!-- Register form -->
            </div>
        </div>
        <div class="col-1"></div>
    </div>
    
    
</div> <!-- Container div -->
</div>


<?php

include "footer.php";



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