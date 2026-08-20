<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php#request');
}

if (!verify_csrf($_POST['csrf_token'] ?? null)) {
    flash('form_errors', ['form' => 'Сессия формы истекла. Обновите страницу и попробуйте снова.']);
    redirect('index.php#request');
}

if (trim((string) ($_POST['website'] ?? '')) !== '') {
    flash('form_success', 'Спасибо! Заявка принята.');
    redirect('index.php#request');
}

$data = [
    'name' => trim((string) ($_POST['name'] ?? '')),
    'direction' => trim((string) ($_POST['direction'] ?? '')),
    'contact' => trim((string) ($_POST['contact'] ?? '')),
    'work_format' => (string) ($_POST['work_format'] ?? ''),
    'preferred_contact' => (string) ($_POST['preferred_contact'] ?? ''),
    'comment' => trim((string) ($_POST['comment'] ?? '')),
    'consent' => (string) ($_POST['consent'] ?? ''),
];

$_SESSION['_old_input'] = $data;
$errors = [];

if (mb_strlen($data['name']) < 2 || mb_strlen($data['name']) > 80) {
    $errors['name'] = 'Укажите имя от 2 до 80 символов.';
}
if (mb_strlen($data['direction']) < 2 || mb_strlen($data['direction']) > 120) {
    $errors['direction'] = 'Расскажите о направлении работы.';
}
if (mb_strlen($data['contact']) < 5 || mb_strlen($data['contact']) > 120) {
    $errors['contact'] = 'Укажите Telegram или номер телефона.';
}
if (!in_array($data['work_format'], ['solo', 'team'], true)) {
    $errors['work_format'] = 'Выберите формат работы.';
}
if (!in_array($data['preferred_contact'], ['telegram', 'phone'], true)) {
    $errors['preferred_contact'] = 'Выберите способ связи.';
}
if (mb_strlen($data['comment']) > 1000) {
    $errors['comment'] = 'Комментарий не должен превышать 1000 символов.';
}
if ($data['consent'] !== '1') {
    $errors['consent'] = 'Необходимо согласие на обработку данных.';
}

if ($errors) {
    flash('form_errors', $errors);
    redirect('index.php#request');
}

try {
    $repository = new LeadRepository(Database::connection());
    $data['ip_hash'] = client_ip_hash();
    if ($repository->recentCountByIp($data['ip_hash']) >= 3) {
        flash('form_errors', ['form' => 'Слишком много отправок. Попробуйте через 15 минут.']);
        redirect('index.php#request');
    }

    $leadId = $repository->create($data);
    unset($_SESSION['_old_input']);

    $webhook = trim((string) ($config['LEAD_NOTIFY_WEBHOOK_URL'] ?? ''));
    if ($webhook !== '' && filter_var($webhook, FILTER_VALIDATE_URL)) {
        $payload = json_encode([
            'event' => 'lead.created',
            'lead' => [
                'id' => $leadId,
                'name' => $data['name'],
                'direction' => $data['direction'],
                'contact' => $data['contact'],
                'work_format' => $data['work_format'],
                'preferred_contact' => $data['preferred_contact'],
                'comment' => $data['comment'],
                'created_at' => date(DATE_ATOM),
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $context = stream_context_create(['http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\nAccept: application/json\r\n",
            'content' => $payload,
            'timeout' => 3,
            'ignore_errors' => true,
        ]]);
        @file_get_contents($webhook, false, $context);
    }

    flash('form_success', 'Заявка отправлена. Скоро свяжемся с вами удобным способом.');
} catch (Throwable $exception) {
    error_log('Lead submission failed: ' . $exception->getMessage());
    flash('form_errors', ['form' => 'Не удалось сохранить заявку. Попробуйте позже или напишите нам в Telegram.']);
}

redirect('index.php#request');
