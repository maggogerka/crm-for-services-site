<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
require_admin();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
$repository = new LeadRepository(Database::connection());
$lead = $repository->find((int) $id);
if (!$lead) {
    http_response_code(404);
    exit('Заявка не найдена.');
}
$statuses = status_labels();
$adminTitle = 'Заявка #' . $lead['id'];
require __DIR__ . '/_header.php';
?>
<main class="admin-shell">
    <header class="admin-header"><div><a class="legal-back" href="index.php">← Все заявки</a><h1>Заявка #<?= (int) $lead['id'] ?></h1></div><span class="status"><?= e($statuses[$lead['status']] ?? $lead['status']) ?></span></header>
    <?php if ($message = flash('admin_success')): ?><div class="form-alert form-alert--success" role="status"><?= e($message) ?></div><?php endif; ?>
    <section class="admin-detail">
        <article class="admin-panel">
            <h2>Контакт и запрос</h2>
            <dl class="detail-list">
                <dt>Создана</dt><dd><?= e(date('d.m.Y H:i', strtotime($lead['created_at']))) ?></dd>
                <dt>Имя</dt><dd><?= e($lead['name']) ?></dd>
                <dt>Направление</dt><dd><?= e($lead['direction']) ?></dd>
                <dt>Контакт</dt><dd><?= e($lead['contact']) ?></dd>
                <dt>Формат</dt><dd><?= $lead['work_format'] === 'team' ? 'Команда' : 'Один мастер' ?></dd>
                <dt>Связаться через</dt><dd><?= $lead['preferred_contact'] === 'phone' ? 'Телефон' : 'Telegram' ?></dd>
                <dt>Комментарий</dt><dd><?= $lead['client_comment'] ? nl2br(e($lead['client_comment'])) : '—' ?></dd>
                <dt>Согласие</dt><dd><?= e(date('d.m.Y H:i', strtotime($lead['consented_at']))) ?></dd>
            </dl>
        </article>
        <form class="admin-panel admin-form" action="update.php" method="post">
            <h2>Работа с заявкой</h2>
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int) $lead['id'] ?>">
            <label>Статус<select name="status"><?php foreach ($statuses as $key => $label): ?><option value="<?= e($key) ?>"<?= $lead['status'] === $key ? ' selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?></select></label>
            <label>Внутренний комментарий<textarea name="admin_comment" maxlength="5000"><?= e($lead['admin_comment'] ?? '') ?></textarea></label>
            <button class="button" type="submit">Сохранить изменения</button>
        </form>
    </section>
</main>
<?php require __DIR__ . '/_footer.php'; ?>
