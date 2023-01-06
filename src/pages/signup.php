<?php
require_once('./app/view/Page.php');

use App\view\Page;

Page::header();
Page::header_menu();
?>
<main>
    <div class="container">
        <h1 class="main__title">Signup</h1>
        <?php if (empty($_SESSION['auth']) or $_SESSION['auth'] !== true): ?>
            <?php Page::form_signup();?>
        <?php else: ?>
            <p>Hello, <?php echo $_SESSION['login']?>!</p>
            <p>You are already registered.Do you want to log out of the account?</p>
            <a class="button button-animated" href="/auth/logout">Log out</a>
        <?php endif ?>
    </div>
</main>
<?php Page::footer(); ?>

