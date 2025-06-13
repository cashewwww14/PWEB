<?php
require_once APP_PATH . '/core/model.php';

class Category extends Model {
    protected $table = 'categories';
    
    // Get all categories
    public function findAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Find category by ID
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Create new category
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (name) 
            VALUES (?)
        ");
        return $stmt->execute([$data['name']]);
    }
    
    // Update category
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET name = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        return $stmt->execute([$data['name'], $id]);
    }
    
    // Delete category
    public function delete($id) {
        // Check if category is being used by any news
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM news WHERE category_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            return ['success' => false, 'message' => 'Cannot delete category. It is being used by ' . $result['count'] . ' news articles.'];
        }
        
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $success = $stmt->execute([$id]);
        
        return ['success' => $success, 'message' => $success ? 'Category deleted successfully.' : 'Failed to delete category.'];
    }
    
    // Check if category name exists (for validation)
    public function nameExists($name, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM {$this->table} WHERE name = ? AND id != ?");
            $stmt->execute([$name, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM {$this->table} WHERE name = ?");
            $stmt->execute([$name]);
        }
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}