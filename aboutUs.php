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
    <img src="img/aboutUs/contact%20us.png">
    <h1>Contact Us</h1>
    <form>
        <label for="name">Name:</label>
        <input name="name" placeholder="NAME">
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="EMAIL">
        <label for="name">Message:</label>
        <textarea placeholder="Please Enter Your Message Here ..."></textarea>
        <button type="submit">SEND EMAIL</button>
    </form>
</div>

<?php require 'footer.php' ?>
