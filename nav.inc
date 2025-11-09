<?php
$current_page = basename($_SERVER['PHP_SELF']);
$pages = [
  'index.php' => 'Home Page',
  'jobs.php' => 'Jobs Positions',
  'apply.php' => 'Applications',
  'about.php' => 'About Us'
];
?>
<nav id="nav-menu">
  <input type="checkbox" id="nav-menu-toggle">
  <label for="nav-menu-toggle">Menu</label>
  <ul>
  <?php foreach ($pages as $file => $name) : ?>
      <li>
          <?php
          if ($file == $current_page) {
              // Current page: link goes nowhere
              echo '<a id="current-page" href="#">' . htmlspecialchars($name) . '</a>';
          } else {
              // Other pages: normal link
              echo '<a href="' . htmlspecialchars($file) . '">' . htmlspecialchars($name) . '</a>';
          }
          ?>
      </li>
  <?php endforeach; ?>
    <li><a href="mailto:info@speedx.com.au"><strong>Contact us:</strong> info@speedx.com.au</a></li>
  </ul>
</nav>
