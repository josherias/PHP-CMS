<div class="col-sm-4">
    <!-- -------card one ------- -->
    <div class="card mt-4">
        <div class="card-body">
            <img src="Images/tik-tok-0827.jpg" class="d-block img-fluid mb-3" alt="">
            <div class="text-center">
                <h3>Tik Tok</h3>
                <h4 class="lead">Sign Up for free</h4>
                <p>Lorem ipsum dolor, sit amet consectetur
                    adipisicing elit. Dolorum consequuntur autem iste
                    voluptatem temporibus inventore similique repellat omnis, quo ullam
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad, nam.</p>
            </div>
        </div>
    </div>
    <br>
    <!-- -------card two ------- -->
    <div class="card mt-5">
        <div class="card-header bg-dark text-light">
            <h2 class="lead"> Sign Up !</h2>
        </div>
        <div class="card-body">
            <button class="btn btn-primary btn-block text-center text-white mb-4">Join the Forum</button>
            <button class="btn btn-danger btn-block text-center text-white mb-4">Login</button>

            <div class="input-group mb-3">
                <input type="text" name="" id="" class="form-control" placeholder="Enter You Email">
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm text-center text-white">Subscribe Now !</button>
                </div>
            </div>

        </div>
    </div>
    <!-- -------card three ------- -->
    <div class="card mt-5">
        <div class="card-body">
            <img src="Images/Whopper.jpg" class="d-block img-fluid mb-3" alt="">
            <div class="text-center">
                <h3>Order From Whopper</h3>
                <h4 class="lead">Anywhere AnyPlace AnyTime</h4>
                <p>Lorem ipsum dolor, sit amet consectetur
                    adipisicing elit. Dolorum consequuntur autem iste
                    voluptatem temporibus inventore similique repellat omnis, quo ullam
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad, nam.</p>
            </div>
        </div>
    </div>
    <!-- -------card four ------- -->
    <div class="card mt-5">
        <div class="card-header bg-primary text-light">
            <h2 class="lead">Categories</h2>
        </div>
        <div class="card-body">
            <?php
            $connectingDB;

            $sql  = "SELECT * FROM category ORDER BY id desc";
            $stmt = $connectingDB->query($sql);
            while ($DataRows = $stmt->fetch()) {
                $CategoryId = $DataRows['id'];
                $CategoryName = $DataRows['title'];
            ?>
                <a href="Blog.php?category=<?php echo $CategoryName ?>" class="btn btn-light btn-block"><?php echo htmlentities($CategoryName); ?></a> <br>
            <?php } ?>
        </div>

    </div>
    <br>
    <!-- -------card three ------- -->
    <div class="card mt-5">
        <div class="card-body">
            <div class="text-center">
                <h3>Huawei Technologies</h3>
                <h4 class="lead">Get the latest Technology</h4>
                <p>Lorem ipsum dolor, sit amet consectetur
                    adipisicing elit.</p>
            </div>
            <img src="Images/huawei.jpeg" class="d-block img-fluid mb-3" alt="">
        </div>
    </div>
    <br>
    <!-- -------card six ------- -->
    <div class="card mt-5">
        <div class="card-header bg-info text-white">
            <h2 class="lead">Recent Posts</h2>
        </div>
        <div class="card-body">
            <?php
            $connectingDB;
            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
            $stmt = $connectingDB->query($sql);

            while ($DataRows = $stmt->fetch()) {
                $Id = $DataRows['id'];
                $Title = $DataRows['title'];
                $DateTime = $DataRows['datetime'];
                $Image = $DataRows['image'];

            ?>
                <div class="media">
                    <img src="Uploads/<?php echo  htmlentities($Image); ?>" alt="" class="d-block img-fluid align-self-start" width="90" height="94">
                    <div class="media-body ml-2">
                        <a href="FullPost.php?id=<?php echo  htmlentities($Id); ?>" target="_blank">
                            <h6 class="lead"><?php echo  htmlentities($Title); ?></h6>
                        </a>
                        <p class="small"><?php echo  htmlentities($DateTime); ?></p>
                    </div>
                </div>
                <hr>
            <?php } ?>
        </div>
    </div>
</div>
</div>
</div>
<!-- ---------X------------HEADER-------------X--------- -->

<!-- --------------MAIN--------------------------------- -->
<br>
<!-- --------x------MAIN---------------------x------------ -->
<!-- ----------------FOOTER-------------------------------- -->

<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead text-center">
                    Theme | By Josh |<span id="year"></span> &copy; ---All Rights
                    Reserved.
                </p>
                <p class="text-center small">
                    <a href="#" style="color: white; text-decoration: none; cursor: pointer;">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero,
                        ea deserunt veritatis atque numquam mollitia evenie t incidunt,

                        <br />
                        &trade; wwww.josherias.com &trade; Foreign Josh
                    </a>
                </p>
            </div>
        </div>
    </div>
</footer>
<div class="" style="height: 5px; background: #27aae1;"></div>

<!-- --------x--------FOOTER---------------x----------------- -->

<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script>
    $("#year").text(new Date().getFullYear());
</script>
</body>

</html>