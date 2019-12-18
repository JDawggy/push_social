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
                    
                    ?>
                    <div class="col-12">
                        <h1><?= $article_row["place"] ?></h1>
                        <p class="text-muted">Published on <?= date("M jS Y @ gA", strtotime($article_row["date_created"])); ?> by <?= $article_row["first_name"] . " " . $article_row["last_name"] ?></p>
                    </div>
                    <div class="col-5">
                        <figure>
                            <img src="<?= $article_row["featured_image"]; ?>" class="w-100">
                        </figure>
                    </div>
                    <div class="col-7">
                        <?php
                            echo $article_row["content"];
                        ?>
                    </div>
                    <?php

                    // if logged in and the post belongs to you or if you are the super admin show edit button/menu

                    if( isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $article_row["author_id"] ) {
                        $this_post = $article_row["id"] ;
                        echo "<hr>";
                        echo "<div class='col-12'>";
                            echo "<a href='edit_post.php?post_id=" . $this_post ."' class='btn btn-primary'>Edit Article</a>";
                        echo "</div>";

                    }


                }
            } else {
                echo mysqli_error($conn);
            }

            // <!-- ALL ARTICLES -->
        } else {
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
                
                if($article_result = mysqli_query($conn, $article_query)) {

                    $num_posts = mysqli_num_rows($article_result);

                    
                    $pagi_query = "SELECT COUNT(*) AS total FROM posts";

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

                    
                    
                    

                    while($article_row = mysqli_fetch_array($article_result)) {

                        // print_r($article_row); // this will tell me the data i have in article row
                        ?>

<!--onclick="ShowPostInfo()"  this can go inside the div below to opn the thing one time on only one post--> 
  
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
                                <h5 class="mt-3 ml-4">Views</h5>

                                <div class="ml-auto">
                                    <div class="row mr-1">

                                        <h5 class="mt-3 ml-auto mr-5"><?= $article_row["date_created"] ?></h5>
                                        
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
                                        
                                        echo "<li>";
                                        echo $comments_row["comment"];
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
                                            <button class="showComments btn btn-outline-dark rounded-pill ml-5 px-5">View comments</button>
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
        ?>
        
    
    
    
    </div>
</div>



<?php

require "footer.php";

?>