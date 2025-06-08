<?php
namespace Models;

use PDO;
use PDOException;

class Task {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Δημιουργεί νέα εργασία (task) και επιστρέφει το ID της.
     * Αναμένει στο $data:
     *   - appointment_id (int)
     *   - description (string)
     *   - materials (string)
     *   - completion_time (string, μορφή 'YYYY-MM-DD HH:MM:SS')
     *   - cost (float ή decimal)
     */
    public function create(array $data): int {
        $sql = "
            INSERT INTO `task`
              (appointment_id, description, materials, completion_time, cost)
            VALUES
              (:appointment_id, :description, :materials, :completion_time, :cost)
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':appointment_id'  => $data['appointment_id'],
            ':description'     => $data['description'],
            ':materials'       => $data['materials'],
            ':completion_time' => $data['completion_time'],
            ':cost'            => $data['cost'],
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Επιστρέφει όλες τις εργασίες που αντιστοιχούν σε ένα συγκεκριμένο appointment_id, 
     * ταξινομημένες κατά completion_time.
     * Επιστρέφει πίνακα από associative arrays.
     */
    public function findByAppointment(int $appointmentId): array {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM `task`
            WHERE appointment_id = :aid
            ORDER BY completion_time ASC
        ");
        $stmt->execute([':aid' => $appointmentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Επιστρέφει όλα τα πεδία μιας task βάσει του ID της, ή null αν δεν βρεθεί.
     */
    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM `task`
            WHERE id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Ενημερώνει μία εργασία. Επιστρέφει true αν έγινε αλλαγή.
     * Αναμένει στο $data:
     *   - description
     *   - materials
     *   - completion_time
     *   - cost
     */
    public function update(int $id, array $data): bool {
        $sql = "
            UPDATE `task` SET
              description     = :description,
              materials       = :materials,
              completion_time = :completion_time,
              cost            = :cost
            WHERE id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':description'     => $data['description'],
            ':materials'       => $data['materials'],
            ':completion_time' => $data['completion_time'],
            ':cost'            => $data['cost'],
            ':id'              => $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Διαγράφει μία εργασία. Επιστρέφει true αν έγινε delete.
     */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM `task` WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Επιστρέφει ένα array με όλες τις εργασίες που αντιστοιχούν στα appointments 
     * του συγκεκριμένου μηχανικού (μέσω join).
     * Αν δοθεί $date, φιλτράρει μόνο τις εργασίες εκείνης της ημερομηνίας.
     */
    public function getByMechanic(int $mechanicId, ?string $date = null): array {
        // Θα κάνουμε JOIN task -> appointment, ώστε να πάρουμε μόνο όσα appointments ανήκουν στον μηχανικό
        $sql = "
            SELECT t.*, a.appointment_date, a.appointment_time, a.car_serial, a.customer_id
            FROM `task` t
            INNER JOIN `appointment` a ON t.appointment_id = a.id
            WHERE a.mechanic_id = :mid
        ";
        $params = [':mid' => $mechanicId];

        if ($date !== null) {
            // Έστω $date σε μορφή YYYY-MM-DD
            $sql .= " AND DATE(t.completion_time) = :d";
            $params[':d'] = $date;
        }

        $sql .= " ORDER BY t.completion_time ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * (Προαιρετικό) Αναζήτηση εργασιών με φίλτρα (π.χ. appointment_id, date range).
     * Αν δώσουμε $limit/$offset, λειτουργεί ως pagination.
     */
    public function search(array $criteria = [], ?int $limit = null, ?int $offset = null): array {
        $sql = "SELECT * FROM `task` WHERE 1";
        $params = [];

        if (!empty($criteria['appointment_id'])) {
            $sql .= " AND appointment_id = :appointment_id";
            $params[':appointment_id'] = $criteria['appointment_id'];
        }
        if (!empty($criteria['from'])) {
            $sql .= " AND completion_time >= :from";
            $params[':from'] = $criteria['from'];
        }
        if (!empty($criteria['to'])) {
            $sql .= " AND completion_time <= :to";
            $params[':to'] = $criteria['to'];
        }

        // ORDER BY
        $sql .= " ORDER BY completion_time ASC";

        // Pagination
        if ($limit !== null && $offset !== null) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Μετράει πόσες εργασίες έχει ο μηχανικός με τα δοσμένα φίλτρα.
 */
public function countByMechanicWithFilters(int $mechId, array $f): int
{
    $sql = "
        SELECT COUNT(*) 
        FROM `task` t
        JOIN `appointment` a ON t.appointment_id = a.id
        JOIN `car` c         ON a.car_serial = c.serial_number
        JOIN `user` u        ON a.customer_id = u.id
        WHERE a.mechanic_id = :mech
    ";
    $params = ['mech' => $mechId];

    if (!empty($f['from'])) {
        $sql .= " AND a.appointment_date >= :from_date";
        $params['from_date'] = $f['from'];
    }
    if (!empty($f['to'])) {
        $sql .= " AND a.appointment_date <= :to_date";
        $params['to_date'] = $f['to'];
    }
    if (!empty($f['serial'])) {
        $sql .= " AND c.serial_number LIKE :serial";
        $params['serial'] = '%' . $f['serial'] . '%';
    }
    if (!empty($f['model'])) {
        $sql .= " AND c.model LIKE :model";
        $params['model'] = '%' . $f['model'] . '%';
    }
    if (!empty($f['brand'])) {
        $sql .= " AND c.brand LIKE :brand";
        $params['brand'] = '%' . $f['brand'] . '%';
    }
    if (!empty($f['customer_last'])) {
        $sql .= " AND u.last_name LIKE :cust_last";
        $params['cust_last'] = '%' . $f['customer_last'] . '%';
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return (int) $stmt->fetchColumn();
}

/**
 * Φέρνει τις εργασίες του μηχανικού με τα φίλτρα, pagination.
 */
public function getByMechanicWithFilters(int $mechId, array $f, int $limit, int $offset): array
{
    $sql = "
        SELECT
            t.*,
            a.appointment_date   AS appt_date,
            a.appointment_time,
            c.serial_number      AS serial,
            c.brand,
            c.model,
            u.last_name          AS cust_last,
            u.first_name         AS cust_first
        FROM `task` t
        JOIN `appointment` a ON t.appointment_id = a.id
        JOIN `car` c         ON a.car_serial = c.serial_number
        JOIN `user` u        ON a.customer_id = u.id
        WHERE a.mechanic_id = :mech
    ";
    $params = ['mech' => $mechId];

    if (!empty($f['from'])) {
        $sql .= " AND a.appointment_date >= :from_date";
        $params['from_date'] = $f['from'];
    }
    if (!empty($f['to'])) {
        $sql .= " AND a.appointment_date <= :to_date";
        $params['to_date'] = $f['to'];
    }
    if (!empty($f['serial'])) {
        $sql .= " AND c.serial_number LIKE :serial";
        $params['serial'] = '%' . $f['serial'] . '%';
    }
    if (!empty($f['model'])) {
        $sql .= " AND c.model LIKE :model";
        $params['model'] = '%' . $f['model'] . '%';
    }
    if (!empty($f['brand'])) {
        $sql .= " AND c.brand LIKE :brand";
        $params['brand'] = '%' . $f['brand'] . '%';
    }
    if (!empty($f['customer_last'])) {
        $sql .= " AND u.last_name LIKE :cust_last";
        $params['cust_last'] = '%' . $f['customer_last'] . '%';
    }

    $sql .= " ORDER BY a.appointment_date DESC, a.appointment_time DESC
              LIMIT :lim OFFSET :off";

    $stmt = $this->pdo->prepare($sql);
    // bind filters
    foreach ($params as $k => $v) {
        $stmt->bindValue(':' . $k, $v);
    }
    // bind pagination as integers
    $stmt->bindValue(':lim', $limit,  PDO::PARAM_INT);
    $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}

