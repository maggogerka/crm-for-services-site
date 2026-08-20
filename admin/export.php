<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
require_admin();

$rows = (new LeadRepository(Database::connection()))->all();
$safeCell = static function (mixed $value): string {
    $text = (string) $value;
    return preg_match('/^[=+\-@]/u', $text) ? "'" . $text : $text;
};

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="leads-' . date('Y-m-d') . '.csv"');
header('X-Content-Type-Options: nosniff');

$output = fopen('php://output', 'wb');
fwrite($output, "\xEF\xBB\xBF");
fputcsv($output, ['ID', 'Дата', 'Имя', 'Направление', 'Контакт', 'Формат', 'Канал связи', 'Комментарий клиента', 'Статус', 'Комментарий администратора'], ';');
foreach ($rows as $row) {
    fputcsv($output, array_map($safeCell, [
        $row['id'], $row['created_at'], $row['name'], $row['direction'], $row['contact'], $row['work_format'], $row['preferred_contact'], $row['client_comment'], $row['status'], $row['admin_comment'],
    ]), ';');
}
fclose($output);
exit;

