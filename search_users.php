<?php

require "header.php";


if(!isset($_SESSION["user_id"])){
    header("Location: http://" . $_SERVER["SERVER_NAME"] . "/login.php");
} 


?>

<div class="container">
<div class="col-12">

<?php



$search_query = (isset($_GET["search"])) ? $_GET["search"] : false;

if($search_query) {
    // this is just the title with its col-12 from below on 1 line
    echo "<div class='col-12 mt-4'><div class='row'><h1>User Results for: $search_query</h1></div>";
} else {
    
}

    
    $article_query = "  SELECT users.*, users.id AS userid, photos.*
                        FROM users
                        LEFT JOIN photos
                        ON photos.id = users.profile_photo_id";
                        
    
    $art_where_search = "";
                        
    if($search_query){

        $art_where_search = "   WHERE users.display_name LIKE '%$search_query%'
                                OR users.first_name LIKE '%$search_query%'";

        
        $article_query .= $art_where_search;

    }

    $current_page = (isset($_GET["page"])) ? $_GET["page"] : 1;
    $limit = 10;
    $offset = ($current_page - 1) * $limit;

    $article_query .= " ORDER BY users.date_created DESC
                        LIMIT $limit
                        OFFSET $offset";
    
    if($article_result = mysqli_query($conn, $article_query)) {

        // $num_posts = mysqli_num_rows($article_result);

        
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



        while($article_row = mysqli_fetch_array($article_result)) {

           

            
            // echo "<pre>";
            // print_r($article_row); // this will tell me the data i have in article row

            ?>

            <div class="card mt-4">
                <div class="card-body">
                    <a class="decor-none" href="/user_posts.php?id=<?= $article_row["userid"] ?>">

                        <div class="row">
                            <img src="" alt="">
                        </div>



                        <div class="row">


                        <!-- Display profile photo or default photo -->
                            <?php
                            if(isset($article_row["url"])) {

                                ?>
                                <div class="search_image ml-3">
                                    <img src="<?= $article_row["url"] ?>" alt="">
                                </div>
                                <?php

                            } else {

                                ?>
                                <div class="search_image ml-3">
                                    <img src="/images/NoProfilePhoto.jpg" alt="">
                                </div>
                                <?php

                            }
                            ?>

                            <h3 class="card-title ml-4 my-auto">
                                <?php
                                // echo "<pre>";
                                // print_r($article_row);
                                    if(isset($article_row["display_name"])){
                                        echo $article_row['display_name'];
                                    } else if (isset($article_row["first_name"])){
                                        echo $article_row['first_name'];
                                        echo $article_row["last_name"];
                                    }

                                ?>
                            
                            </h3>


                            <p class="card-text my-auto ml-5 mt-1"><?= $article_row["bio"] ?></p>

                        </div>

                    </a>
                </div>
            </div>




            <?php
        
        } // end while
    } else {
        echo mysqli_error($conn);
    } // end if $article_result


    echo "<nav aria-label='Page navigation'><ul class='pagination'>";

    $get_search = ($search_query) ? "&search=" . $search_query : "";

    if($current_page > 1) {
        echo "<li class='page-item'><a class='page-link' href='/search_users.php?page=" . ($current_page - 1) . "$get_search'>Show Newer</a></li>";
    }


    for ($i = 1; $i <= $page_count; $i++) {
        
        echo "<li class='page-item";

        if($current_page == $i) echo " active";
        echo "'><a class='page-link' href='/search_users.php?page=$i" . $get_search . "'>$i</a></li>";

    }
    if ( $current_page < $page_count ) {
        echo "<li class='page-item mb-4'><a class='page-link' href='/index.php?page=" . ($current_page + 1) . "$get_search'>Show Older</a></li>";
    }

    echo "</ul></nav>";

    
?>
</div>  <!-- col-12 -->
</div>  <!-- container -->

<?php





require "footer.php";

?>