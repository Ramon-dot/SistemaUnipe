<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo ?? 'Portal Acadêmico UNIPÊ'); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="<?php echo BASE_URL; ?>/css/main.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>/css/sidebar/style.css" rel="stylesheet">

    <?php if (!empty($styles)): ?>
        <?php foreach ($styles as $style): ?>
            <link href="<?php echo BASE_URL; ?>/css/<?php echo $style; ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <div class="wrapper">
        <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

        <div id="main-content">
            <?php require_once __DIR__ . '/partials/topbar.php'; ?>
            
            <div class="content-area">
                <?php echo $conteudo;?>
            </div>
        </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/js/sidebar/script.js"></script>
    <?php if (!empty($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?php echo BASE_URL; ?>/js/<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>