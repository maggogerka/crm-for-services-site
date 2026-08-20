<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['csrf_token'] ?? null)) {
    http_response_code(403);
    exit('Недопустимый запрос.');
}
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT) ?: 0;
$status = (string) ($_POST['status'] ?? '');
$comment = trim((string) ($_POST['admin_comment'] ?? ''));
if ($id < 1 || !isset(status_labels()[$status]) || mb_strlen($comment) > 5000) {
    http_response_code(422);
    exit('Проверьте данные формы.');
}
(new LeadRepository(Database::connection()))->update((int) $id, $status, $comment);
flash('admin_success', 'Изменения сохранены.');
redirect('lead.php?id=' . $id);

