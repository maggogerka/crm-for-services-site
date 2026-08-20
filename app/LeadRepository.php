<?php
declare(strict_types=1);

final class LeadRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function recentCountByIp(string $ipHash, int $minutes = 15): int
    {
        $minutes = max(1, min(1440, $minutes));
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) FROM leads WHERE ip_hash = :ip_hash AND created_at >= (NOW() - INTERVAL ' . $minutes . ' MINUTE)'
        );
        $stmt->bindValue(':ip_hash', $ipHash);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO leads (name, direction, contact, work_format, preferred_contact, client_comment, consented_at, ip_hash, user_agent) VALUES (:name, :direction, :contact, :work_format, :preferred_contact, :client_comment, NOW(), :ip_hash, :user_agent)'
        );
        $stmt->execute([
            ':name' => $data['name'],
            ':direction' => $data['direction'],
            ':contact' => $data['contact'],
            ':work_format' => $data['work_format'],
            ':preferred_contact' => $data['preferred_contact'],
            ':client_comment' => $data['comment'] ?: null,
            ':ip_hash' => $data['ip_hash'],
            ':user_agent' => mb_substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function paginate(string $search, string $status, int $page, int $perPage = 20): array
    {
        $where = [];
        $params = [];
        if ($search !== '') {
            $where[] = '(name LIKE :search OR direction LIKE :search OR contact LIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }
        if ($status !== '') {
            $where[] = 'status = :status';
            $params[':status'] = $status;
        }
        $whereSql = $where ? ' WHERE ' . implode(' AND ', $where) : '';

        $count = $this->pdo->prepare('SELECT COUNT(*) FROM leads' . $whereSql);
        $count->execute($params);
        $total = (int) $count->fetchColumn();

        $offset = max(0, ($page - 1) * $perPage);
        $stmt = $this->pdo->prepare('SELECT * FROM leads' . $whereSql . ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset');
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return ['items' => $stmt->fetchAll(), 'total' => $total, 'pages' => max(1, (int) ceil($total / $perPage))];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM leads WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $lead = $stmt->fetch();
        return $lead ?: null;
    }

    public function update(int $id, string $status, string $adminComment): void
    {
        $stmt = $this->pdo->prepare('UPDATE leads SET status = :status, admin_comment = :admin_comment, updated_at = NOW() WHERE id = :id');
        $stmt->execute([':status' => $status, ':admin_comment' => $adminComment ?: null, ':id' => $id]);
    }

    public function all(): array
    {
        return $this->pdo->query('SELECT * FROM leads ORDER BY created_at DESC')->fetchAll();
    }
}
