<?php
require_once APP_PATH . '/core/model.php';

class Interaction extends Model {
    protected $table = 'interactions';
    
    // Like/unlike berita
    public function toggleLike($user_id, $news_id) {
        // Cek apakah user sudah like
        $existing = $this->findUserInteraction($user_id, $news_id, 'like');
        
        if ($existing) {
            // Hapus like
            return $this->removeLike($user_id, $news_id);
        } else {
            // Tambah like
            return $this->addLike($user_id, $news_id);
        }
    }
    
    // Bookmark/unbookmark berita
    public function toggleBookmark($user_id, $news_id) {
        $existing = $this->findUserInteraction($user_id, $news_id, 'bookmark');
        
        if ($existing) {
            return $this->removeBookmarkPrivate($user_id, $news_id);
        } else {
            return $this->addBookmark($user_id, $news_id);
        }
    }
    
    // Get total likes untuk berita
    public function getLikesCount($news_id) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM {$this->table} 
            WHERE news_id = ? AND type = 'like'
        ");
        $stmt->execute([$news_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
    
    // Get total bookmarks untuk berita
    public function getBookmarksCount($news_id) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM {$this->table} 
            WHERE news_id = ? AND type = 'bookmark'
        ");
        $stmt->execute([$news_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
    
    // Cek apakah user sudah like/bookmark
    public function getUserInteractionStatus($user_id, $news_id) {
        if (!$user_id) {
            return ['liked' => false, 'bookmarked' => false];
        }
        
        $stmt = $this->db->prepare("
            SELECT type 
            FROM {$this->table} 
            WHERE user_id = ? AND news_id = ?
        ");
        $stmt->execute([$user_id, $news_id]);
        $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        return [
            'liked' => in_array('like', $results),
            'bookmarked' => in_array('bookmark', $results)
        ];
    }
    
    // Get bookmarked news untuk user dashboard
    public function getUserBookmarks($user_id) {
        $stmt = $this->db->prepare("
            SELECT news.*, interactions.created_at as bookmarked_at,
                   categories.name as categoryName
            FROM interactions
            INNER JOIN news ON interactions.news_id = news.id 
            INNER JOIN categories ON news.category_id = categories.id
            WHERE interactions.user_id = ? AND interactions.type = 'bookmark' 
            ORDER BY interactions.created_at DESC
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get all interaction counts untuk multiple news (untuk homepage)
    public function getNewsInteractionCounts($news_ids) {
        if (empty($news_ids)) {
            return [];
        }
        
        $placeholders = str_repeat('?,', count($news_ids) - 1) . '?';
        $stmt = $this->db->prepare("
            SELECT news_id, type, COUNT(*) as count 
            FROM {$this->table} 
            WHERE news_id IN ($placeholders) 
            GROUP BY news_id, type
        ");
        $stmt->execute($news_ids);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Format hasil
        $counts = [];
        foreach ($results as $row) {
            $counts[$row['news_id']][$row['type']] = $row['count'];
        }
        
        return $counts;
    }
    
    // Public method untuk remove bookmark (untuk dashboard)
    public function removeBookmark($user_id, $news_id) {
        $stmt = $this->db->prepare("
            DELETE FROM {$this->table} 
            WHERE user_id = ? AND news_id = ? AND type = 'bookmark'
        ");
        $result = $stmt->execute([$user_id, $news_id]);
        
        // Return true if at least one row was affected (bookmark was deleted)
        return $result && $stmt->rowCount() > 0;
    }
    
    // Private helper methods
    private function findUserInteraction($user_id, $news_id, $type) {
        $stmt = $this->db->prepare("
            SELECT id FROM {$this->table} 
            WHERE user_id = ? AND news_id = ? AND type = ?
        ");
        $stmt->execute([$user_id, $news_id, $type]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    private function addLike($user_id, $news_id) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (user_id, news_id, type) 
            VALUES (?, ?, 'like')
        ");
        return $stmt->execute([$user_id, $news_id]);
    }
    
    private function removeLike($user_id, $news_id) {
        $stmt = $this->db->prepare("
            DELETE FROM {$this->table} 
            WHERE user_id = ? AND news_id = ? AND type = 'like'
        ");
        return $stmt->execute([$user_id, $news_id]);
    }
    
    private function addBookmark($user_id, $news_id) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (user_id, news_id, type) 
            VALUES (?, ?, 'bookmark')
        ");
        return $stmt->execute([$user_id, $news_id]);
    }
    
    // Private method untuk toggle bookmark (beda nama dari public removeBookmark)
    private function removeBookmarkPrivate($user_id, $news_id) {
        $stmt = $this->db->prepare("
            DELETE FROM {$this->table} 
            WHERE user_id = ? AND news_id = ? AND type = 'bookmark'
        ");
        return $stmt->execute([$user_id, $news_id]);
    }
}