<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'layout.php' ?>
    <link rel="stylesheet" href="css/aboutUs.css" type="text/css">
    <div id="container">

        <div class="left-sidebar" id="left-sidebar">

            <a href="#" id="close-sidebar" class="fas fa-arrow-left"></a>
            <a href="#" class="fas fa-thumbtack"> Latest Picnics</a>
            <a href="#" class="fas fa-newspaper"> News</a>
            <?php if ($_SESSION['userType'] == 2) { ?>
                <a href="#" class="fas fa-shopping-cart"> Cart</a>
            <?php } ?>
        </div>
        <div class="row">
            <img src="img/aboutUs/salt.png">
            <h1>About Us</h1>
            <p>
                Picnics R Us is a local business that specializes in catering delightful picnics anytime and anywhere.
                With the best prices in the market. Picnics R Us intend to make and organize great picnics which
                everyone
                attends would be happy.
            </p>
        </div>

        <div class="row">
            <img src="img/aboutUs/basket.png">
            <h1>Our Mission Statement</h1>
            <p>Here at Picnics R Us we promise to bring to your picnic only the most top quality foods and set ups.</p>
        </div>

        <div class="row">
            <img src="img/aboutUs/contactUs.png">
            <h1>Contact Us</h1>
            <form method="post" id="contactUs">
                <label id="nameLabel"></label>
                <input name="name" placeholder="Name" id="nameField">
                <label id="emailLabel"></label>
                <input name="email" placeholder="Email" id="emailField" type="email">
                <label id="messageLabel"></label>
                <textarea name="message" placeholder="Message..." id="messageField"></textarea>
                <button type="submit" onclick="btFade()" class="bt" id="sendMessageBT">Send Message</button>
            </form>
        </div>

        <script>
            document.getElementById("nameField").addEventListener("focus", nameFocus);
            document.getElementById("nameField").addEventListener("focusout", nameOutOfFocus);

            document.getElementById("emailField").addEventListener("focus", emailFocus);
            document.getElementById("emailField").addEventListener("focusout", emailOutOfFocus);

            document.getElementById("messageField").addEventListener("focus", messageFocus);
            document.getElementById("messageField").addEventListener("focusout", messageOutOfFocus);

            function nameFocus() {
                document.getElementById("nameField").placeholder = "";
                document.getElementById("nameLabel").innerText = "Name";
            }

            function nameOutOfFocus() {
                document.getElementById("nameField").placeholder = "Name";
                document.getElementById("nameLabel").innerText = "";
            }

            function emailFocus() {
                document.getElementById("emailField").placeholder = "";
                document.getElementById("emailLabel").innerText = "Email";
            }

            function emailOutOfFocus() {
                document.getElementById("emailField").placeholder = "Email";
                document.getElementById("emailLabel").innerText = "";
            }

            function messageFocus() {
                document.getElementById("messageField").placeholder = "";
                document.getElementById("messageLabel").innerHTML = "Message";
            }


            function messageOutOfFocus() {
                document.getElementById("messageField").placeholder = "Message...";
                document.getElementById("messageLabel").innerText = "";
            }

            function btFade() {
                var name = document.getElementById("nameField").value;
                var email = document.getElementById("emailField").value;
                var message = document.getElementById("messageField").value;
                if (name == "") {
                    event.preventDefault();
                    alert("Name Field Cannot Be Empty!");
                } else if (email == "") {
                    event.preventDefault();
                    alert("Email Field Cannot Be Empty!");
                } else if (message == "") {
                    event.preventDefault();
                    alert("Message Field Cannot Be Empty!");
                } else {
                    //event.preventDefault();
                    document.getElementById("sendMessageBT").className += " clicked";
                    window.setTimeout('this.disabled=true', 0);
                    document.getElementById("contactUs").submit();
                }

            }

        </script>

    </div>
<?php require 'footer.php' ?>

<?php
require 'model.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message']) )
    insertMessage($_POST['name'], $_POST['email'], $_POST['message']);
}
?>