<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';

if (is_admin()) {
    redirect('index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $error = 'Сессия истекла. Обновите страницу.';
    } elseif (($_SESSION['login_locked_until'] ?? 0) > time()) {
        $error = 'Слишком много попыток. Повторите вход через несколько минут.';
    } else {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $expectedUser = (string) ($config['admin']['username'] ?? 'admin');
        $hash = (string) ($config['admin']['password_hash'] ?? '');
        $validHash = str_starts_with($hash, '$2y$') || str_starts_with($hash, '$argon2');
        $valid = $validHash && hash_equals($expectedUser, $username) && password_verify($password, $hash);

        if ($valid) {
            session_regenerate_id(true);
            $_SESSION['admin_authenticated'] = true;
            $_SESSION['admin_logged_at'] = time();
            unset($_SESSION['login_attempts'], $_SESSION['login_locked_until']);
            redirect('index.php');
        }

        $attempts = (int) ($_SESSION['login_attempts'] ?? 0) + 1;
        $_SESSION['login_attempts'] = $attempts;
        if ($attempts >= 5) {
            $_SESSION['login_locked_until'] = time() + 300;
            $_SESSION['login_attempts'] = 0;
        }
        $error = 'Неверный логин или пароль.';
    }
}

$adminTitle = 'Вход';
require __DIR__ . '/_header.php';
?>
<main class="login-wrap">
    <form class="login-card admin-form" method="post" autocomplete="on">
        <a class="brand" href="../index.php"><img src="../assets/images/logo-96.webp" width="44" height="44" alt=""><span>CRM <i>for services</i></span></a>
        <h1>Вход в CRM</h1>
        <?php if ($error !== ''): ?><div class="form-alert form-alert--error" role="alert"><?= e($error) ?></div><?php endif; ?>
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <label>Логин<input type="text" name="username" autocomplete="username" required autofocus></label>
        <label>Пароль<input type="password" name="password" autocomplete="current-password" required></label>
        <button class="button button--wide" type="submit">Войти</button>
    </form>
</main>
<?php require __DIR__ . '/_footer.php'; ?>

