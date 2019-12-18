<?php

require "header.php";

// $article_row and stuff is a post row if its matched the database names



?>


<div class="container">

    <div class="row">

    <!-- SINGLE ARTICLE -->

        <?php

        if(isset($_GET["id"])){

            $article_query = "  SELECT  posts.*, 
                                        users.first_name, users.last_name,
                                        photos.url AS featured_image, users.display_name AS username
                                FROM posts
                                LEFT JOIN users
                                ON posts.author_id = users.id
                                LEFT JOIN photos
                                ON posts.image_id = photos.id
                                WHERE posts.id = " . $_GET["id"];  

            if( $article_result = mysqli_query($conn, $article_query)){
                while($article_row = mysqli_fetch_array($article_result)){

                    // print_r($article_row);
                    
                    
                    // if logged in and the post belongs to you or if you are the super admin show edit button/menu

                    


                }
            } else {
                echo mysqli_error($conn);
            }

            // <!-- ALL ARTICLES -->
        } else {
            // if no ID set, show ALL articles
            // if query includes search


            print_r($_SESSION);

            ?>
            <div class="col-12">
                <div class="row">
                    <h1>Your Posts</h1>   
                </div>

                <?php
                
                $article_query = "  SELECT posts.place, posts.author_id, posts.date_created, posts.id,
                                            photos.url AS featured_image,
                                            users.first_name, users.last_name, users.display_name AS username, posts.caption
                                    FROM posts
                                    LEFT JOIN photos
                                    ON posts.image_id = photos.id
                                    LEFT JOIN users
                                    ON posts.author_id = users.id";
                
                $art_where_search = "";
                                    
                

                $current_page = (isset($_GET["page"])) ? $_GET["page"] : 1;
                $limit = 4;
                $offset = ($current_page - 1) * $limit;

                $article_query .= " WHERE posts.author_id = " . $_SESSION["user_id"] . "
                                    ORDER BY posts.date_created DESC
                                    LIMIT $limit
                                    OFFSET $offset";
                                    
                                    // This isnt working for some reason, I want it to show me only the posts that were created by the user $_SESSION["user_id"]
                
                if($article_result = mysqli_query($conn, $article_query)) {

                    $num_posts = mysqli_num_rows($article_result);

                    
                    $pagi_query = "SELECT COUNT(*) AS total FROM posts";

                    

                    $pagi_result = mysqli_query($conn, $pagi_query);
                    $pagi_row = mysqli_fetch_array($pagi_result);
                    $total_articles = $pagi_row["total"];

                    $page_count = ceil($total_articles / $limit);
                    // floor = rounding numbers down
                    // ciel = "ceiling" will round numbers up
                    // round = rounds up if above .5 rounds down if below .5


                    

                    
                    
                    

                    while($article_row = mysqli_fetch_array($article_result)) {

                        print_r($article_row);
                        ?>

<!--onclick="ShowPostInfo()"  this can go inside the div below to opn the thing one time on only one post--> 
  
                        <div id="clickContainer" class="clickToReveal"> open on click container

                                                                        <!-- Sart of each post -->
                            <div class="nameLocation row top-click d-none">
                                <!-- REMOVE THE d-none CLASS FROM THE PIECES I WANT TO SEE IN JAVA SCRIPT -->
            
                                <i class="fas fa-user-circle fa-3x ml-5 mb-4"></i>
                                <h4 class="mt-2 ml-4"><?= $article_row["username"]?></h4>

                                <div class="ml-auto">
                                    <div class="row mr-1">

                                        <i class="fas fa-map-marker-alt fa-3x mb-4 mr-3"></i>
                                        <h4 class="mt-2 ml-auto mr-5"><?= $article_row["place"]?></h4>

                                    </div> <!-- row -->
                                </div> <!-- ml-auto -->

                            </div> <!-- row -->


                                                                            <!-- photo or video post -->
                            <div class="row">  
                                <div class="user_post col-12">
                        
                                    <img src="<?= $article_row["featured_image"] ?>" alt="">
                        
                                </div>
                            </div>


                                                                            <!-- on click post details -->
                            <div class="commentSection d-none">
                            <div class="row click-post">
                            
                                <i class="far fa-eye fa-3x ml-5"></i>
                                <h5 class="mt-3 ml-4">Views</h5>

                                <div class="ml-auto">
                                    <div class="row mr-1">

                                        <h5 class="mt-3 ml-auto mr-5"><?= $article_row["date_created"] ?></h5>
                                        
                                    </div> <!-- row -->
                                </div> <!-- ml-auto -->

                            </div> <!-- row -->

                            <hr>

                            <h5 class="ml-4 mr-4"><?= $article_row["caption"] ?></h5>

                            <div class="row ml-2 mt-4 mr-2 mb-4">
                                <div class="input-group mb-3 col-9">
                                    <input type="text" class="form-control comment-input in_index" placeholder="Leave a comment">

                                    <div class="input-group-append">
                                    <button class="btn btn-warning px-5 comment-button" type="button">Share</button>
                                    </div>
                                </div>

                                <div>
                                <button class="btn btn-outline-dark rounded-pill ml-5 px-5">View comments</button>
                                </div>
                            </div>

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
        ?>
        
    
    
    
    </div>
</div>



<?php

require "footer.php";

?>