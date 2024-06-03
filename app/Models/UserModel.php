<?php

namespace App\Models;

class UserModel extends Model
{
    protected string $table = 'users';
    
    public function createUser(array $data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $this->db->addUser($data);
    }

    public function findByEmail(string $email): array|bool {
        return $this->db->getUserByEmail($email);
    }
}