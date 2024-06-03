<?php

namespace App\Models;

use DateTime;
use DateInterval;

class ReservationModel extends Model
{
    protected string $table = 'reservation';

    public function getReservationById($id)
    {
        return $this->db->getReservationById($id);
    }

    public function getReservations($date) {
        return $this->db->getReservationsByDate($date);
    }

    public function addNewReservation(array $data) {
        $data["user_id"] = $_SESSION["user"];
    
        $this->db->addReservation($data);
    }

    public function updateReservation(array $data) {
        $current = $_SESSION["reservation_edit"];
        $new = $data;

        foreach ($current as $key => $old) {
            if ($key == "id") continue;
            if ($old != $new[$key]) {
                $columnsToUpdate[$key] = $new[$key];
            }
        }

        $this->db->updateReservation($columnsToUpdate, $current["id"]);
        // echo "<pre>";
        // var_dump($columnsToUpdate);
        // echo "</pre>";
    }

    public function deleteReservation($id) {
        $this->db->deleteReservation($id);
    }

}