<?php require 'layout.php' ?>
<link rel="stylesheet" href="css/aboutUs.css" type="text/css">
<div class="row">
    <img src="img/aboutUs/salt.png">
    <h1>About Us</h1>
    <p>
        Picnics R Us is a local business that specializes in catering delightful picnics anytime and anywhere.
        With the best prices in the market. Picnics R Us intend to make and organize great picnics which everyone
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
    <form>
        <label id="nameLabel"></label>
        <input placeholder="Name" id="nameField">
        <label id="emailLabel"></label>
        <input placeholder="Email" id="emailField">
        <label id="messageLabel"></label>
        <textarea placeholder="Message..." id="messageField"></textarea>
        <button type="submit">Send Message</button>
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

    function emailFocus(){
        document.getElementById("emailField").placeholder = "";
        document.getElementById("emailLabel").innerText = "Email";
    }

    function emailOutOfFocus() {
        document.getElementById("emailField").placeholder = "Email";
        document.getElementById("emailLabel").innerText = "";
    }

    function messageFocus (){
        document.getElementById("messageField").placeholder = "";
        document.getElementById("messageLabel").innerHTML = "Message";
    }


    function messageOutOfFocus() {
        document.getElementById("messageField").placeholder = "Message...";
        document.getElementById("messageLabel").innerText = "";
    }

</script>
<?php require 'footer.php' ?>
