<?php
require_once('./app/view/Page.php');

use App\view\Page;

Page::header();
Page::header_menu();
?>
<main>
    <div class="container">
        <h1 class="main__title">Home</h1>
        <?php if (empty($_SESSION['auth']) or $_SESSION['auth'] !== true): ?>
            <p>You need to log in!</p>
        <?php else: ?>
            <p>Hello, <?php echo $_SESSION['login'] ?>!</p>
            <a class="button button-animated" href="/auth/logout" target="_parent">Log out</a>
        <?php endif ?>
    </div>
</main>
<?php Page::footer(); ?>

