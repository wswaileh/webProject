<?php
include 'layout.php';
if (!isset($_SESSION['userType']))
    $_SESSION['userType'] = 1;
?>


    <!DOCTYPE html>
    <html>
    <head>
        <title>Laflef</title>
        <link rel="stylesheet" href="css/main.css" type="text/css">

    </head>
    <body>
    <div id="container">
        <div class="left-sidebar" id="left-sidebar">

            <a href="#" id="close-sidebar" class="fas fa-arrow-left"></a>
            <a href="#" class="fas fa-thumbtack"> Latest Picnics</a>
            <a href="#" class="fas fa-newspaper"> News</a>
            <?php if (isset($_SESSION['userType']) && $_SESSION['userType'] == 2) { ?>
                <a href="#" class="fas fa-shopping-cart"> Cart</a>
            <?php } ?>
        </div>


        <div class="slideshow-container">

            <div class="mySlides fade">
                <div class="numbertext">1/3</div>
                <img src="img/main/1.jpg" style="width:100%;height: 500px">
                <div class="text">واد القلط</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">2/3</div>
                <img src="img/main/2.jpg" style="width:100%;height: 500px">
                <div class="text">واد القلط</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">3/3</div>
                <img src="img/main/3.jpg" style="width:100%;height:500px;">
                <div class="text">واد القلط</div>
            </div>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

            <div style="text-align:center;">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
        </div>


        <div style="height: 150px;text-align: center;font-size: 20px;font-family: Times New Roman;background-color: rgb(51,51,50);">
            <br><b>L a f l e f</b><br><br>Our site Offer the best picnics Across the west bank area
        </div>


        <script>


            var slideIndex = 1;
            showSlides(slideIndex);

            function plusSlides(n) {
                showSlides(slideIndex += n);
            }

            function currentSlide(n) {
                showSlides(slideIndex = n);
            }

            function showSlides(n) {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("dot");
                if (n > slides.length) {
                    slideIndex = 1
                }
                if (n < 1) {
                    slideIndex = slides.length
                }
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex - 1].style.display = "block";
                dots[slideIndex - 1].className += " active";
            }


            document.getElementById('close-sidebar').addEventListener('click', function (event) {
                event.preventDefault();
                closeSlidMenu();
            });

        </script>

    </div>
    </body>
    </html>


<?php require 'footer.php' ?>