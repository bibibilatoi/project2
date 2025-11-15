<?php
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



?>

<nav id="nav-menu">
    <ul>
        <?php foreach ($pages as $file => $title): ?>
            <li>
                <?php if ($file === $current_page): ?>
                    <a id="current-page" href="#"><?= htmlspecialchars($title) ?></a>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($title) ?></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>

        <li>
            <a href="mailto:info@speedx.com.au"><strong>Contact us:</strong> info@speedx.com.au</a>
        </li>
    </ul>
</nav>

