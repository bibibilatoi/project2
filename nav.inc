<?php
// Safety: make sure $pages exists
if (!isset($pages) || !is_array($pages)) {
    $pages = [
        'login.php' => 'Login',
        'index.php' => 'Home Page',
        'jobs.php' => 'Jobs Positions',
        'apply.php' => 'Applications',
        'about.php' => 'About Us'
    ];
}

// Current page detection
$current_page = basename($_SERVER['PHP_SELF']);

// Split menu into two groups
$left_pages = ['index.php','about.php','jobs.php','apply.php'];
$right_pages = ['login.php'];
?>

<nav id="nav-menu">
    <!-- Left menu -->
    <ul class="menu-left">
        <?php foreach ($left_pages as $file) : 
            if (isset($pages[$file])): ?>
            <li>
                <?php if ($file == $current_page): ?>
                    <a id="current-page" href="#"><?= htmlspecialchars($pages[$file]) ?></a>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($pages[$file]) ?></a>
                <?php endif; ?>
            </li>
        <?php endif; endforeach; ?>
    </ul>

    <!-- Right menu -->
    <ul class="menu-right">
        <?php foreach ($right_pages as $file) : 
            if (isset($pages[$file])): ?>
            <li>
                <?php if ($file == $current_page): ?>
                    <a id="current-page" href="#"><?= htmlspecialchars($pages[$file]) ?></a>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($pages[$file]) ?></a>
                <?php endif; ?>
            </li>
        <?php endif; endforeach; ?>
        <li>
            <a href="mailto:info@speedx.com.au"><strong>Contact us:</strong> info@speedx.com.au</a>
        </li>
    </ul>
</nav>
