<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
require_admin();

$statuses = status_labels();
$search = mb_substr(trim((string) ($_GET['q'] ?? '')), 0, 120);
$status = (string) ($_GET['status'] ?? '');
if ($status !== '' && !isset($statuses[$status])) {
    $status = '';
}
$page = max(1, (int) ($_GET['page'] ?? 1));
$repository = new LeadRepository(Database::connection());
$result = $repository->paginate($search, $status, $page);
$queryBase = ['q' => $search, 'status' => $status];

$adminTitle = 'Заявки';
require __DIR__ . '/_header.php';
?>
<main class="admin-shell">
    <header class="admin-header">
        <div><p class="eyebrow"><span></span>Мини-CRM</p><h1>Заявки <small>(<?= $result['total'] ?>)</small></h1></div>
        <nav><a href="export.php">Экспорт CSV</a><a href="../index.php" target="_blank">Открыть сайт ↗</a><form action="logout.php" method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><button type="submit" class="text-link">Выйти</button></form></nav>
    </header>
    <?php if ($message = flash('admin_success')): ?><div class="form-alert form-alert--success"><?= e($message) ?></div><?php endif; ?>
    <section class="admin-panel">
        <form class="admin-filters" method="get">
            <input type="search" name="q" value="<?= e($search) ?>" placeholder="Имя, направление или контакт">
            <select name="status"><option value="">Все статусы</option><?php foreach ($statuses as $key => $label): ?><option value="<?= e($key) ?>"<?= $status === $key ? ' selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?></select>
            <button class="button button--small" type="submit">Найти</button>
        </form>
        <div class="table-wrap">
            <table class="admin-table">
                <thead><tr><th>ID / дата</th><th>Клиент</th><th>Направление</th><th>Контакт</th><th>Формат</th><th>Статус</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($result['items'] as $lead): ?>
                    <tr>
                        <td><b>#<?= (int) $lead['id'] ?></b><br><small><?= e(date('d.m.Y H:i', strtotime($lead['created_at']))) ?></small></td>
                        <td><?= e($lead['name']) ?></td><td><?= e($lead['direction']) ?></td><td><?= e($lead['contact']) ?></td>
                        <td><?= $lead['work_format'] === 'team' ? 'Команда' : 'Один мастер' ?></td>
                        <td><span class="status"><?= e($statuses[$lead['status']] ?? $lead['status']) ?></span></td>
                        <td><a class="text-link" href="lead.php?id=<?= (int) $lead['id'] ?>">Открыть</a></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$result['items']): ?><tr><td colspan="7">Заявки не найдены.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if ($result['pages'] > 1): ?><nav class="pagination" aria-label="Страницы"><?php for ($i = 1; $i <= $result['pages']; $i++): ?><?php if ($i === $page): ?><span><?= $i ?></span><?php else: ?><a href="?<?= e(http_build_query($queryBase + ['page' => $i])) ?>"><?= $i ?></a><?php endif; ?><?php endfor; ?></nav><?php endif; ?>
    </section>
</main>
<?php require __DIR__ . '/_footer.php'; ?>

