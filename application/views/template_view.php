<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">
<head>
    <? if ( file_exists(APP_PATH.'views/layouts/head.php') ): ?>
        <?php include APP_PATH.'views/layouts/head.php'; ?>
    <? endif; ?>
</head>
<body>

<div class="main-wrapper d-flex flex-column min-vh-100">
    <? if ( file_exists(APP_PATH.'views/layouts/header.php') ): ?>
        <?php include APP_PATH.'views/layouts/header.php'; ?>
    <? endif; ?>

    <main class="content-wrapper flex-grow-1 container text-content bg-light p-4">
        <? if ( file_exists(APP_PATH.'views/' . $content_view) ): ?>
            <?php include APP_PATH.'views/'.$content_view; ?>
        <? endif; ?>
    </main>

    <? if ( file_exists(APP_PATH.'views/layouts/footer.php') ): ?>
        <?php include APP_PATH.'views/layouts/footer.php'; ?>
    <? endif; ?>
</div>

</body>
</html>