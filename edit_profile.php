<?php

include_once("conn.php");

$user_id = (isset($_POST["user_id"]) ) ? $_POST["user_id"] : $_SESSION["user_id"];

$user_query = " SELECT users.*, photos.url AS profile_photo
                FROM users 
                LEFT JOIN photos
                ON users.profile_photo_id = photos.id
                WHERE users.id = " . $user_id; 

if ( $user_request = mysqli_query($conn, $user_query) ) :

    while ($user_row = mysqli_fetch_array($user_request)) :
    
        
        // print_r($_SESSION);

    


?>

<html>
    <head>
    
        <title></title>

        
        <link rel="stylesheet" href="/edit-profile-styles.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">

        <script src="https://kit.fontawesome.com/ea81b73834.js" crossorigin="anonymous"></script>


    </head>
    <body>
    
    <nav class="navbar header navbar-expand-lg border-bottom">

        <div class="container">
            <a class="navbar-brand col-4" href="/index.php"><img class="logo" src="/images/push-logo-black.png" alt=""></a>


            <form class="form-inline col-4 d-flex justify-content-center">
                <div class="form-group mt-3">
                    <div class="input-icons">
                        <i class="fas fa-search"></i>
                        <input class="form-control mr-sm-2 rounded-pill" type="search" placeholder="Search" aria-label="Search">
                    </div>
                    
                </div>
    
        
                
            </form>
    
            
            <div class="collapse navbar-collapse col-4" id="navbarSupportedContent">
                
                <ul class="navbar-nav ml-auto mr-2">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user fa-2x"></i>
                    
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/new_post.php">New Post</a>
                        <a class="dropdown-item" href="user_posts.php">View Posts</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/edit_profile.php?user_id=<?=$user_row["id"];?>">Edit Profile</a>
                        <a class="dropdown-item" href="/login.php?action=logout">Logout</a>
                        </div>
                    </li>  
                </ul>
                
            </div>
        </div>

        </nav>








<div class="bodyimage">
<div class="container container-size">
    
    <div class="row row-size">

        <div class="col-1"></div>
        <div class="col-10 center-position">

            <div class="background-white">
                <div class="row">

                    <div class="col-1">

                        <a class="decor-none" href="index.php" id="" role="button">

                            <i class="fas fa-undo fa-2x"></i>

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
                                    <span class="pl-1 mb-4 user-center fa-stack fa-2x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fas fa-user fa-stack-1x fa-inverse"></i>
                                    </span>
                                    <?php

                                } else {
                                    ?>

                                    <div class="circular-landscape mx-auto mb-5">
                                        <img class="mx-auto mb-5" id="profileDisplay"  onclick="uploadProfile()" src="<?php echo $user_row["profile_photo"]; ?>" alt="">
                                    </div>
                                    
                                    <?php
                                }

                                ?>
                                
                                
                            </div>

                            <div class="row">

                                <label class="btn btn-default btn-file mx-auto">
                                     <span class="upload-photo">Upload Profile Photo</span> 
                                     <input class="profile_in_feilds" type="file" name="profile_photo" onchange="displayProfile(this)" id="profile_photo" style="display: none;">
                                     
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

<footer>
    <nav class="border-top navbar footer-nav">
        <div class="container">
            <a class="navbar-brand ml-auto mr-auto" href="/index.php"><img class="logo" src="/images/push-logo-black.png" alt=""></a>
        </div>
        
        
        
    </nav>
</footer>






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