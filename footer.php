<?php
$footer_logo = "CTF-Logo.png";
if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == 1) {
  $footer_logo = "Dark-CTF-Logo.png";
}
?>

<section class="footer">
    <div class="footer-container">
        <div class="footer-box">
            <?php echo "<img src='../img/" . $footer_logo .  "' alt='W0rm'>";?>
            <p class="footer-text"> &copy Copyright <?= date('Y'); ?> CTF. All rights reserved.</p>
        </div>
        <div class="footer-box">
            <h4>Help</h4>
            <li><a href="#">Privacy</a></li>
            <li><a href="#">Term of Services</a></li>
            <li><a href="#">FAQs</a></li>
            <li><a href="#">Support Us</a></li>
        </div>
        <div class="footer-box">
            <h4>Our Services</h4>
            <li><a href="#">Lectures</a></li>
            <li><a href="#">CTF Challenges</a></li>
            <li><a href="#">Hacking Labs</a></li>
            <li><a href="#">Events</a></li>
        </div>
        <div class="footer-box">
            <h4>Others</h4>
            <li><a href="#">Blogs</a></li>
            <li><a href="#">Forums (upcoming)</a></li>
        </div>
    </div>
</section>