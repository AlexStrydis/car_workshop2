<?php
namespace Controllers;

use Models\Car;
use Models\Appointment;

class CustomerController {
    private Car         $carM;
    private Appointment $apptM;

    public function __construct(\PDO $pdo) {
        $this->carM  = new Car($pdo);
        $this->apptM = new Appointment($pdo);
    }

    /**
     *  Προβολή Dashboard Πελάτη: τα οχήματα του και τα επερχόμενα ραντεβού του.
     */
    public function dashboard(): void {
        requireLogin();
        requireRole('customer');

        $customerId = $_SESSION['user_id'];
        $today      = date('Y-m-d');

        // Φέρνουμε τα αυτοκίνητα που έχει ο πελάτης
        $cars = $this->carM->search(['owner_id' => $customerId]);

        // Φέρνουμε τα ραντεβού από σήμερα και μετά
        $appts = $this->apptM->search([
            'customer_id' => $customerId,
            'date_from'   => $today
        ]);

        $token = generateCsrfToken();
        include __DIR__ . '/../../views/customer_dashboard.php';
    }
}
