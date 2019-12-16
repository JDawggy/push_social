<?php
session_start();



if( !isset($_SESSION["user_id"]) && ($_SESSION["role"] > 2) ):
    header("Location: http://" . $_SERVER["SERVER_NAME"] . "/login.php");
endif;

require_once("header.php");


?>
    

    

    <section id="">

      <div class="container">



        <div class="user_post">

          <img src="/images/post1.png" alt="">

        </div>

        <div class="user_post">

          <img src="/images/post2.png" alt="">

        </div>

        <div class="user_post">

          <img src="/images/post3.png" alt="">

        </div>








        <!-- on click header for post -->
        <div class="row top-click">
          
            <i class="fas fa-user-circle fa-3x ml-5 mb-4"></i>
            <h4 class="mt-2 ml-4">Username</h4>

            <div class="ml-auto">
              <div class="row mr-1">

                <i class="fas fa-map-marker-alt fa-3x mb-4 mr-3"></i>
                <h4 class="mt-2 ml-auto mr-5">Location, Province</h4>

              </div> <!-- row -->
            </div> <!-- ml-auto -->

        </div> <!-- row -->




        <!-- photo or video post -->
        <div class="row">  
          <div class="user_post col-12">
  
            <img src="/images/post4.png" alt="">
  
          </div>
        </div>





        <!-- on click post details -->
        <div class="row click-post">
          
            <i class="far fa-eye fa-3x ml-5"></i>
            <h5 class="mt-3 ml-4">Views</h5>

            <div class="ml-auto">
              <div class="row mr-1">

                <h5 class="mt-3 ml-auto mr-5">Date time posted</h5>
                
              </div> <!-- row -->
            </div> <!-- ml-auto -->

        </div> <!-- row -->

        <hr>

        <h5 class="ml-4 mr-4">User created caption</h5>

        <div class="row ml-2 mt-4 mr-2 mb-4">
            <div class="input-group mb-3 col-9">
                <input type="text" class="form-control comment-input" placeholder="Leave a comment">

                <div class="input-group-append">
                  <button class="btn btn-warning px-5 comment-button" type="button">Share</button>
                </div>
            </div>

            <div>
              <button class="btn btn-outline-dark rounded-pill ml-5 px-5">View comments</button>
            </div>
        </div>









      </div>


    </section>







    


<?php

require_once("footer.php");


?>