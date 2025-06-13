<?php
require_once APP_PATH . '/core/model.php';

class Comment extends Model {
    protected $table = 'comments';
    
    // Tambah komentar
    public function addComment($user_id, $news_id, $comment_text) {
        if (empty(trim($comment_text))) {
            return false;
        }
        
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (user_id, news_id, comment_text) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$user_id, $news_id, trim($comment_text)]);
    }
    
    // Hapus komentar berdasarkan ID
    public function deleteComment($comment_id, $user_id) {
        $stmt = $this->db->prepare("
            DELETE FROM {$this->table} 
            WHERE id = ? AND user_id = ?
        ");
        return $stmt->execute([$comment_id, $user_id]);
    }
    
    // Get total comments untuk berita
    public function getCommentsCount($news_id) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM {$this->table} 
            WHERE news_id = ?
        ");
        $stmt->execute([$news_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
    
    // Get comments untuk berita dengan user info
    public function getComments($news_id) {
        $stmt = $this->db->prepare("
            SELECT comments.*, users.name as user_name 
            FROM {$this->table} comments
            INNER JOIN users ON comments.user_id = users.id 
            WHERE comments.news_id = ? 
            ORDER BY comments.created_at DESC
        ");
        $stmt->execute([$news_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get all comment counts untuk multiple news (untuk homepage)
    public function getNewsCommentCounts($news_ids) {
        if (empty($news_ids)) {
            return [];
        }
        
        $placeholders = str_repeat('?,', count($news_ids) - 1) . '?';
        $stmt = $this->db->prepare("
            SELECT news_id, COUNT(*) as count 
            FROM {$this->table} 
            WHERE news_id IN ($placeholders) 
            GROUP BY news_id
        ");
        $stmt->execute($news_ids);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Format hasil
        $counts = [];
        foreach ($results as $row) {
            $counts[$row['news_id']] = $row['count'];
        }
        
        return $counts;
    }
}