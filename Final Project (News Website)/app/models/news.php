<?php
require_once APP_PATH . '/core/model.php';

class News extends Model {
    protected $table = 'news';
    
    // Method untuk dashboard dengan kategori dan created_by
    public function getLatestWithCategory($limit = 10) {
        $limit = intval($limit);
        if ($limit <= 0) $limit = 10;
        if ($limit > 100) $limit = 100;
        
        $sql = "SELECT news.*, categories.name as categoryName, categories.id as categoryId,
                       users.name as createdByName, users.email as createdByEmail
                FROM {$this->table} news
                LEFT JOIN categories ON news.category_id = categories.id
                LEFT JOIN users ON news.created_by = users.id
                ORDER BY news.release_date DESC 
                LIMIT " . $limit;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Method untuk list semua news dengan kategori dan created_by
    public function findAllWithCategory() {
        $stmt = $this->db->prepare("
            SELECT news.*, categories.name as categoryName, categories.id as categoryId,
                   users.name as createdByName, users.email as createdByEmail
            FROM {$this->table} news
            LEFT JOIN categories ON news.category_id = categories.id
            LEFT JOIN users ON news.created_by = users.id
            ORDER BY news.release_date DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Method untuk edit news dengan kategori dan created_by
    public function findByIdWithCategory($id) {
        $stmt = $this->db->prepare("
            SELECT news.*, categories.name as categoryName, categories.id as categoryId,
                   users.name as createdByName, users.email as createdByEmail
            FROM {$this->table} news
            LEFT JOIN categories ON news.category_id = categories.id
            LEFT JOIN users ON news.created_by = users.id
            WHERE news.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Update method untuk kategori ID dengan created_by
    public function findByCategory($categoryId) {
        $stmt = $this->db->prepare("
            SELECT news.*, categories.name as categoryName, categories.id as categoryId,
                   users.name as createdByName, users.email as createdByEmail
            FROM {$this->table} news
            LEFT JOIN categories ON news.category_id = categories.id
            LEFT JOIN users ON news.created_by = users.id
            WHERE news.category_id = ? 
            ORDER BY news.release_date DESC
        ");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Enhanced search method - mencari dari judul DAN isi content dengan created_by
    public function search($query) {
        $stmt = $this->db->prepare("
            SELECT news.*, categories.name as categoryName, categories.id as categoryId,
                   users.name as createdByName, users.email as createdByEmail
            FROM {$this->table} news
            LEFT JOIN categories ON news.category_id = categories.id
            LEFT JOIN users ON news.created_by = users.id
            WHERE news.title LIKE ? OR news.content LIKE ?
            ORDER BY news.release_date DESC
        ");
        $stmt->execute(["%{$query}%", "%{$query}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Method asli (tetap ada untuk backward compatibility)
    public function getLatest($limit = 10) {
        $limit = intval($limit);
        if ($limit <= 0) $limit = 10;
        if ($limit > 100) $limit = 100;
        
        $sql = "SELECT * FROM {$this->table} ORDER BY release_date DESC LIMIT " . $limit;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Enhanced filterNews untuk kategori ID dengan search di judul DAN content dengan date filter
    public function filterNews($categoryId = null, $search = null, $dateFrom = null, $dateTo = null) {
        $sql = "SELECT news.*, categories.name as categoryName, categories.id as categoryId,
                       users.name as createdByName, users.email as createdByEmail
                FROM {$this->table} news
                LEFT JOIN categories ON news.category_id = categories.id
                LEFT JOIN users ON news.created_by = users.id";
        $params = [];
        $conditions = [];
        
        if ($categoryId) {
            $conditions[] = "news.category_id = ?";
            $params[] = $categoryId;
        }
        
        if ($search) {
            $conditions[] = "(news.title LIKE ? OR news.content LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
        
        // Date filters
        if ($dateFrom) {
            $conditions[] = "DATE(news.release_date) >= ?";
            $params[] = $dateFrom;
        }
        
        if ($dateTo) {
            $conditions[] = "DATE(news.release_date) <= ?";
            $params[] = $dateTo;
        }
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        
        $sql .= " ORDER BY news.release_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get categories dari tabel categories
    public function getCategories() {
        $stmt = $this->db->prepare("SELECT id, name FROM categories ORDER BY name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method untuk create dengan category_id dan created_by
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (title, content, category_id, release_date, image, created_by) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['title'],
            $data['content'],
            $data['category_id'],
            $data['release_date'],
            $data['image'],
            $data['created_by']
        ]);
    }
    
    // Method untuk update dengan category_id (created_by tidak diubah)
    public function update($id, $data) {
        if (isset($data['image'])) {
            $stmt = $this->db->prepare("
                UPDATE {$this->table} 
                SET title = ?, content = ?, category_id = ?, release_date = ?, image = ? 
                WHERE id = ?
            ");
            return $stmt->execute([
                $data['title'],
                $data['content'],
                $data['category_id'],
                $data['release_date'],
                $data['image'],
                $id
            ]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE {$this->table} 
                SET title = ?, content = ?, category_id = ?, release_date = ? 
                WHERE id = ?
            ");
            return $stmt->execute([
                $data['title'],
                $data['content'],
                $data['category_id'],
                $data['release_date'],
                $id
            ]);
        }
    }
    
    // Override findAll untuk mengurutkan berdasarkan tanggal terbaru
    public function findAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY release_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Method standard dari parent class
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}