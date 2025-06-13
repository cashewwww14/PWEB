<?php
require_once APP_PATH . '/core/model.php';

class User extends Model {
    protected $table = 'users';
    
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        if ($user && hash('sha256', $password) === $user['password']) {
            return $user;
        }
        return false;
    }
    
    public function register($data) {
        // Check if email already exists
        if ($this->findByEmail($data['email'])) {
            return false;
        }
        
        $data['password'] = hash('sha256', $data['password']);
        
        // Set default role only if role is not already set
        if (!isset($data['role']) || empty($data['role'])) {
            $data['role'] = 'user';
        }
        
        return $this->create($data);
    }
    
    public function updateProfile($id, $data) {
        // Remove password from update if not provided
        unset($data['password']);
        return $this->update($id, $data);
    }
}