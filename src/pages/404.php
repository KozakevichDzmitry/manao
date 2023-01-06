<?php
require_once('./app/view/Page.php');
use App\view\Page;

Page::header();
Page::header_menu();
?>
<main>
    <div class="container">
        <h1>404</h1>
        <p>Page not found</p>
        <?php if($message):?>
            <p><?php echo $message; ?></p>
        <?php endif ?>
        <a href="/">go to Home page</a>
    </div>
</main>
<?php Page::footer(); ?>