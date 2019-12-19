<?php

require "header.php";

// $article_row and stuff is a post row if its matched the database names

if(!isset($_SESSION["user_id"])){
    header("Location: http://" . $_SERVER["SERVER_NAME"] . "/login.php"); //. "login.php" to get to a diffrent page and remove the ) after SERVER_NAME]
} 

?>


<div class="container">

    <div class="row">







    <!-- SPECIFIC USER -->





        <?php

        if(isset($_GET["id"])){

             // if no ID set, show ALL articles
            // if query includes search

            $search_query = (isset($_GET["search"])) ? $_GET["search"] : false;

            if($search_query) {
                // this is just the title with its col-12 from below on 1 line
                echo "<div class='col-12'><div class='row'><h1>Search Results for : $search_query</h1></div>";
            } else {
               
            }



            ?>
            <div class="col-12">
                <div class="row">
                    <h1></h1>   
                </div>

                <?php

                $this_user = $_GET["id"];
                
                $article_query = "  SELECT posts.place, posts.author_id, posts.date_created, posts.id,
                                            photos.url AS featured_image,
                                            users.first_name, users.last_name, users.display_name AS username, posts.caption, posts.views
                                    FROM posts
                                    LEFT JOIN photos
                                    ON posts.image_id = photos.id
                                    LEFT JOIN users
                                    ON posts.author_id = users.id";
                
                $art_where_search = "";
                                    
                

                $current_page = (isset($_GET["page"])) ? $_GET["page"] : 1;
                $limit = 10;
                $offset = ($current_page - 1) * $limit;

                $article_query .= " WHERE posts.author_id = " . $this_user . "
                                    ORDER BY posts.date_created DESC
                                    LIMIT $limit
                                    OFFSET $offset";
                
                if($article_result = mysqli_query($conn, $article_query)) {

                    $user_query = " SELECT users.*, photos.url AS profile_photo
                                    FROM users 
                                    LEFT JOIN photos
                                    ON users.profile_photo_id = photos.id
                                    WHERE users.id = " . $this_user; 


                    if ( $user_request = mysqli_query($conn, $user_query) ) :

                        while ($user_row = mysqli_fetch_array($user_request)) :

                        // users profile picture and bio
                        ?> 
                        <div class="mt-5 row">

                            <div class="col-3">
                                <?php

                                // echo "<pre>";
                                // print_r($user_row);
                                
            
                                if ( !isset($user_row["profile_photo_id"]) ) {
                                    
                                    ?>
            
                                    <div class="circular-landscape mx-auto mb-5">
                                        <img class="mx-auto mb-5" src="/images/NoProfilePhoto.jpg" alt="">
                                    </div>
                                    
                                    <?php
            
                                } else {
                                    
                                    ?>
            
                                    <div class="circular-landscape mx-auto mb-5">
                                        <img class="mx-auto mb-5" src="<?= $user_row["profile_photo"]; ?>" alt="">
                                    </div>
                                    
                                    <?php
                                }
                                ?> 
                            </div> <!-- end col-4 -->

                            <div class="col-4">
                            <h3 class="mt-3">
                                <?php
                                // echo "<pre>";
                                // print_r($article_row);
                                    if(isset($user_row["display_name"])){
                                        echo $user_row['display_name'];
                                    } else if (isset($user_row["first_name"])){
                                        echo $user_row['first_name'];
                                        echo $user_row["last_name"];
                                    }

                                ?>
                            
                            </h3>
                                <p><?= $user_row["bio"]; ?></p>
                            </div>
                            

                        </div>
                        
                        <?php


                    endwhile;
                    endif;


                    // pagination

                    $num_posts = mysqli_num_rows($article_result);

                    $current_user = $_SESSION["user_id"];
                    
                    $pagi_query = "SELECT COUNT(*) AS total FROM posts WHERE posts.author_id = $current_user";

                    if($search_query) {
                        $pagi_query .= $art_where_search;
                    }

                    $pagi_result = mysqli_query($conn, $pagi_query);
                    $pagi_row = mysqli_fetch_array($pagi_result);
                    $total_articles = $pagi_row["total"];

                    $page_count = ceil($total_articles / $limit);
                    // floor = rounding numbers down
                    // ciel = "ceiling" will round numbers up
                    // round = rounds up if above .5 rounds down if below .5


                    
                    

                    while($article_row = mysqli_fetch_array($article_result)) {

                        $update_views_query = " UPDATE posts 
                                                SET views = " . ( $article_row["views"] += 1 ) . "
                                                WHERE id = " . $article_row["id"];
                        mysqli_query($conn, $update_views_query);


                        // print_r($article_row); // this will tell me the data i have in article row
                        ?>
  
                        <div class="clickContainer"> 

                            <hr class="mt-3">

                                                                        <!-- Sart of each post -->
                            <div class="nameLocation row top-click" style="display: none;">
                                <!-- REMOVE THE d-none CLASS FROM THE PIECES I WANT TO SEE IN JAVA SCRIPT -->
            
                                <i class="fas fa-user-circle fa-3x ml-5 mb-4"></i>
                                <h4 class="mt-2 ml-4"><?= isset($article_row["username"]) ? $article_row["username"] : $article_row["first_name"]; ?></h4>

                                <div class="ml-auto">
                                    <div class="row mr-1">

                                        <i class="fas fa-map-marker-alt fa-3x mb-4 mr-3"></i>
                                        <h4 class="mt-2 ml-auto mr-5"><?= $article_row["place"]?></h4>


                                    </div> <!-- row -->
                                </div> <!-- ml-auto -->

                            </div> <!-- row -->


                                                                            <!-- photo or video post -->
                            <div class="row postPhoto">  
                                <div class="user_post col-12">
                        
                                    <img class="imageDisplay" src="<?= $article_row["featured_image"] ?>" alt="">
                        
                                </div>
                            </div>


                                                                            <!-- on click post details -->
                            <div class="commentSection" style="display: none;">
                            <div class="row click-post">
                            
                                <i class="far fa-eye fa-3x ml-5"></i>
                                <h5 class="mt-3 ml-4"><?= $article_row["views"]; ?> Views</h5>

                                <div class="ml-auto">
                                    <div class="row mr-1">

                                        <h5 class="mt-3 ml-auto mr-5"><?= date("l F d", strtotime($article_row["date_created"])); ?></h5>
                                        
                                    </div> <!-- row -->
                                </div> <!-- ml-auto -->

                            </div> <!-- row -->

                            <hr>

                            <h5 class="ml-4 mr-4"><?= $article_row["caption"] ?></h5>

                            
                                <ul id="comment_block<?=$article_row['id']?>"  class="allComments" style="display: none;">

                                
                                <?php


                                $comments_query = " SELECT *
                                                    FROM comments
                                                    WHERE post_id = " . $article_row["id"];

                                if ( $comments_result = mysqli_query($conn, $comments_query) ) {

                                    while ($comments_row = mysqli_fetch_array($comments_result)) {


                                        // echo "<pre>";
                                        // print_r($comments_row);
                                        
                                        echo "<li class='comment_list'>";
                                        echo  "<strong>" . $article_row["username"] . "</strong>" . " " . $comments_row["comment"];
                                        echo "</li>";

                                    }
                                
                                }

                                ?>

                                </ul>
                            
                        
                            <form action="/actions/new_comment.php" method="post">
                                <div class="row ml-2 mt-4 mr-2 mb-4">
                                    <div class="input-group mb-3 col-9">


                                            <input type="hidden" name="post_id" value="<?= $article_row["id"] ?>">

                                            <input type="text" name="comment" class="form-control comment-input in_index" placeholder="Leave a comment">
                                        
                                            <div class="input-group-append">
                                                <button class="btn btn-warning px-5 commentButton" type="submit" name="action" data-comments="" value="share_comment">Share</button>
                                            </div>

                                    </div>
                                        
                                        <div>
                                            <button data-comment_block="#comment_block<?=$article_row['id']?>" class="showComments btn btn-outline-dark rounded-pill ml-5 px-5">View comments</button>
                                        </div>
                                </div>
                            </form>

                        </div> <!-- d-none bottom container -->

                        </div> <!-- on click container -->


                        

                      

                        
                        <?php
                    }
                } else {
                    echo mysqli_error($conn);
                }

                ?>
                </div>
            </div>
            <?php
        



            // <!-- CURRENT USER -->

            
        } else {
            // if no ID set, show ALL articles from user based on SESSION
            // if query includes search

            $search_query = (isset($_GET["search"])) ? $_GET["search"] : false;




            ?>
            <div class="col-12">
                <div class="row">
                    <h1></h1>   
                </div>

                <?php
                
                $article_query = "  SELECT posts.place, posts.author_id, posts.date_created, posts.id,
                                            photos.url AS featured_image,
                                            users.first_name, users.last_name, users.display_name AS username, posts.caption, posts.views
                                    FROM posts
                                    LEFT JOIN photos
                                    ON posts.image_id = photos.id
                                    LEFT JOIN users
                                    ON posts.author_id = users.id";
                
                $art_where_search = "";
                                    
                

                $current_page = (isset($_GET["page"])) ? $_GET["page"] : 1;
                $limit = 10;
                $offset = ($current_page - 1) * $limit;

                $article_query .= " WHERE posts.author_id = " . $_SESSION["user_id"] . "
                                    ORDER BY posts.date_created DESC
                                    LIMIT $limit
                                    OFFSET $offset";
                
                if($article_result = mysqli_query($conn, $article_query)) {

                    $user_query = " SELECT users.*, photos.url AS profile_photo
                                    FROM users 
                                    LEFT JOIN photos
                                    ON users.profile_photo_id = photos.id
                                    WHERE users.id = " . $user_id; 


                    if ( $user_request = mysqli_query($conn, $user_query) ) :

                        while ($user_row = mysqli_fetch_array($user_request)) :

                        // users profile picture and bio
                        ?> 
                        <div class="mt-5 row">

                            <div class="col-3">
                                <?php

                                // echo "<pre>";
                                // print_r($user_row);
                                
            
                                if ( !isset($user_row["profile_photo_id"]) ) {
                                                                      
                                    ?>
            
                                    <div class="circular-landscape mx-auto mb-5">
                                        <img class="mx-auto mb-5" src="/images/NoProfilePhoto.jpg" alt="">
                                    </div>
                                    
                                    <?php
            
                                } else {
                                    
                                    ?>
            
                                    <div class="circular-landscape mx-auto mb-5">
                                        <img class="mx-auto mb-5" src="<?= $user_row["profile_photo"]; ?>" alt="">
                                    </div>
                                    
                                    <?php
                                }
                                ?> 
                            </div> <!-- end col-4 -->

                            <div class="col-4">
                                <h3 class="mb-4">
                                <?php
            
                                    if(isset($user_row["display_name"])){
                                        echo $user_row['display_name'];
                                    } else if (isset($user_row["first_name"])){
                                        echo $user_row['first_name'] . " " . $user_row['last_name'];
                                        
                                    }

                                ?>
                            
                            </h3>
                                <p><?= $user_row["bio"]; ?></p>
                            </div>
                            

                        </div>
                        
                        <?php


                    endwhile;
                    endif;


                    // pagination

                    $num_posts = mysqli_num_rows($article_result);

                    $current_user = $_SESSION["user_id"];
                    
                    $pagi_query = "SELECT COUNT(*) AS total FROM posts WHERE posts.author_id = $current_user";

                    if($search_query) {
                        $pagi_query .= $art_where_search;
                    }

                    $pagi_result = mysqli_query($conn, $pagi_query);
                    $pagi_row = mysqli_fetch_array($pagi_result);
                    $total_articles = $pagi_row["total"];

                    $page_count = ceil($total_articles / $limit);
                    // floor = rounding numbers down
                    // ciel = "ceiling" will round numbers up
                    // round = rounds up if above .5 rounds down if below .5


                   

                    
                    
                    

                    while($article_row = mysqli_fetch_array($article_result)) {

                        $update_views_query = " UPDATE posts 
                                                SET views = " . ( $article_row["views"] += 1 ) . "
                                                WHERE id = " . $article_row["id"];
                        mysqli_query($conn, $update_views_query);

                        // echo "<pre>";
                        // print_r($article_row); // this will tell me the data i have in article row
                        ?>
  
                        <div id="thisPost<?=$article_row["id"]?>" class="clickContainer"> 

                            <hr class="mt-3">

                                                                        <!-- Sart of each post -->
                            <div class="nameLocation row top-click" style="display: none;">
                                <!-- REMOVE THE d-none CLASS FROM THE PIECES I WANT TO SEE IN JAVA SCRIPT -->
            
                                <i class="fas fa-user-circle fa-3x ml-5 mb-4"></i>
                                <h4 class="mt-2 ml-4"><?= isset($article_row["username"]) ? $article_row["username"] : $article_row["first_name"]; ?></h4>

                                <div class="ml-auto">
                                    <div class="row mr-1">

                                        <i class="fas fa-map-marker-alt fa-3x mb-4 mr-3"></i>
                                        <h4 class="mt-2 ml-auto mr-5"><?= $article_row["place"]?></h4>


                                        
                                        
                                <div class="dropdown">
                                            
                                    <i class="fas fa-ellipsis-v fa-2x mt-2 mr-4" data-toggle="dropdown" aria-haspopup="true"></i>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

                                        <a class="dropdown-item" href="/edit_post.php?featured_image=<?= $article_row["featured_image"] . "&place=" . $article_row["place"] . "&caption=" . $article_row["caption"] . "&post_id=" . $article_row["id"] ?>">Edit Post</a>

                                        <a class="dropdown-item" id="deletePost" href="/actions/update_post_action.php?post_id=<?= $article_row["id"] ?>">Delete Post</a>

                                    </div>
                                </div>







                                    </div> <!-- row -->
                                </div> <!-- ml-auto -->

                            </div> <!-- row -->


                                                                            <!-- photo or video post -->
                            <div class="row postPhoto">  
                                <div class="user_post col-12">
                        
                                    <img class="imageDisplay" src="<?= $article_row["featured_image"] ?>" alt="">
                        
                                </div>
                            </div>


                                                                            <!-- on click post details -->
                            <div class="commentSection" style="display: none;">
                            <div class="row click-post">
                            
                                <i class="far fa-eye fa-3x ml-5"></i>
                                <h5 class="mt-3 ml-4"><?= $article_row["views"]; ?> Views</h5>

                                <div class="ml-auto">
                                    <div class="row mr-1">

                                        <h5 class="mt-3 ml-auto mr-5"><?= date("l F d", strtotime($article_row["date_created"])); ?></h5>
                                        
                                    </div> <!-- row -->
                                </div> <!-- ml-auto -->

                            </div> <!-- row -->

                            <hr>

                            <h5 class="ml-4 mr-4"><?= $article_row["caption"] ?></h5>

                            
                                <ul id="comment_block<?=$article_row['id']?>"  class="allComments" style="display: none;">

                                
                                <?php


                                $comments_query = " SELECT *
                                                    FROM comments
                                                    WHERE post_id = " . $article_row["id"];

                                if ( $comments_result = mysqli_query($conn, $comments_query) ) {

                                    while ($comments_row = mysqli_fetch_array($comments_result)) {


                                        // echo "<pre>";
                                        // print_r($comments_row);
                                        
                                        echo "<li class='comment_list'>";
                                        echo  "<strong>" . $article_row["username"] . "</strong>" . " " . $comments_row["comment"];
                                        echo "</li>";

                                    }
                                
                                }

                                ?>

                                </ul>
                            
                        
                            <form action="/actions/new_comment.php" method="post">
                                <div class="row ml-2 mt-4 mr-2 mb-4">
                                    <div class="input-group mb-3 col-9">


                                            <input type="hidden" name="post_id" value="<?= $article_row["id"] ?>">

                                            <input type="text" name="comment" class="form-control comment-input in_index" placeholder="Leave a comment">
                                        
                                            <div class="input-group-append">
                                                <button class="btn btn-warning px-5 commentButton" type="submit" name="action" data-comments="" value="share_comment">Share</button>
                                            </div>

                                    </div>
                                        
                                        <div>
                                            <button data-comment_block="#comment_block<?=$article_row['id']?>" class="showComments btn btn-outline-dark rounded-pill ml-5 px-5">View comments</button>
                                        </div>
                                </div>
                            </form>

                        </div> <!-- d-none bottom container -->

                        </div> <!-- on click container -->


                        

                      

                        
                        <?php
                    }
                } else {
                    echo mysqli_error($conn);
                }

                ?>
                </div>
            </div>
            <?php
        }

        echo "<nav aria-label='Page navigation'><ul class='pagination'>";

                $get_search = ($search_query) ? "&search=" . $search_query : "";

                if($current_page > 1) {
                    echo "<li class='page-item'><a class='page-link' href='/index.php?page=" . ($current_page - 1) . "$get_search'>Show Newer</a></li>";
                }


                for ($i = 1; $i <= $page_count; $i++) {
                    
                    echo "<li class='page-item";

                    if($current_page == $i) echo " active";
                    echo "'><a class='page-link' href='/index.php?page=$i" . $get_search . "'>$i</a></li>";

                }
                if ( $current_page < $page_count ) {
                    echo "<li class='page-item mb-4'><a class='page-link' href='/index.php?page=" . ($current_page + 1) . "$get_search'>Show Older</a></li>";
                }

                echo "</ul></nav>";
        ?>
        
    
    
    
    </div>
</div>



<?php

require "footer.php";

?>