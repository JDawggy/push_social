<?php

include_once("conn.php");

$user_id = (isset($_GET["user_id"]) ) ? $_GET["user_id"] : $_SESSION["user_id"];

$user_query = " SELECT users.*, provinces.name AS province_name, photos.url AS profile_pic 
                FROM users
                LEFT JOIN provinces 
                ON users.province_id = provinces.id 
                LEFT JOIN photos
                ON users.profile_photo_id = photos.id
                WHERE users.id = " . $user_id; 
// echo $user_query;
if ( $user_request = mysqli_query($conn, $user_query) ) :
   
    
    while ($user_row = mysqli_fetch_array($user_request)) :
        
        
        
        // echo "<pre>";
        // print_r($user_row)
        
        
        

?>


<html>
    <head>
    
        <title></title>

        
        <link rel="stylesheet" href="/styles.css">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">

        <script src="https://kit.fontawesome.com/ea81b73834.js" crossorigin="anonymous"></script>


    </head>
    <body>
    

    
    
        <nav class="navbar header navbar-expand-lg border-bottom">

        <div class="container">
            <a class="navbar-brand col-4" href="/index.php"><img class="logo" src="/images/push-logo-black.png" alt=""></a>


            <div class="collapse navbar-collapse justify-content-center">
                <form class="form-inline col-4 d-flex justify-content-center" method="GET" action="/search_users.php">

                    <div class="form-group mt-3">
                        <div class="input-icons">

                            <i class="fas fa-search"></i>

                            <input class="form-control mr-sm-2 rounded-pill in_index" name="search" value="<?= (isset($_GET["search"]) ? $_GET["search"] : "" ) ?>" type="search" placeholder="Search Users" aria-label="Search">

                        </div>
                        
                    </div>
    
                </form>
            </div>

            
            <div class="navbar col-4" id="navbarSupportedContent">
                
                <ul class="navbar-nav ml-auto mr-2">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php

                        if (isset($user_row["profile_pic"])) {
                            ?>
                            <div class="header_pic mt-1">

                                <img src="<?= $user_row["profile_pic"] ?>" alt="">

                            </div>
                            <?php
                        } else {
                            ?>
                            <i class="fas fa-user fa-2x"></i>
                            <?php
                        }

                        ?>
                    
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/index.php">Home</a>
                        <a class="dropdown-item" href="/new_post.php">New Post</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/user_posts.php">View Profile</a>
                        <a class="dropdown-item" href="/edit_profile.php?user_id=<?=$user_row["id"];?>">Edit Profile</a>
                        <a class="dropdown-item" href="/login.php?action=logout">Logout</a>
                        </div>
                    </li>  
                </ul>
                
            </div>
        </div>

        </nav>

<?php

endwhile;

else :
    echo mysqli_error($conn);
endif; 


?>