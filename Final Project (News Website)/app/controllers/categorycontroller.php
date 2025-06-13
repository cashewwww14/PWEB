<?php
require_once APP_PATH . '/core/controller.php';
require_once APP_PATH . '/models/category.php';

class CategoryController extends Controller {
    private $categoryModel;
    
    public function __construct() {
        $this->categoryModel = new Category();
    }
    
    // List all categories (AJAX)
    public function listCategories() {
        $this->requireAuth();
        $this->requireAdmin();
        
        header('Content-Type: application/json');
        
        $categories = $this->categoryModel->findAll();
        
        echo json_encode([
            'success' => true,
            'categories' => $categories
        ]);
    }
    
    // Add new category (AJAX)
    public function addCategory() {
        $this->requireAuth();
        $this->requireAdmin();
        
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        $name = trim($_POST['name'] ?? '');
        
        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'Category name is required']);
            return;
        }
        
        // Check if name already exists
        if ($this->categoryModel->nameExists($name)) {
            echo json_encode(['success' => false, 'message' => 'Category name already exists']);
            return;
        }
        
        $result = $this->categoryModel->create(['name' => $name]);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Category added successfully'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add category']);
        }
    }
    
    // Edit category (AJAX)
    public function editCategory() {
        $this->requireAuth();
        $this->requireAdmin();
        
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        
        if (!$id || !is_numeric($id)) {
            echo json_encode(['success' => false, 'message' => 'Invalid category ID']);
            return;
        }
        
        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'Category name is required']);
            return;
        }
        
        // Check if category exists
        $category = $this->categoryModel->findById($id);
        if (!$category) {
            echo json_encode(['success' => false, 'message' => 'Category not found']);
            return;
        }
        
        // Check if name already exists (excluding current category)
        if ($this->categoryModel->nameExists($name, $id)) {
            echo json_encode(['success' => false, 'message' => 'Category name already exists']);
            return;
        }
        
        $result = $this->categoryModel->update($id, ['name' => $name]);
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Category updated successfully'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update category']);
        }
    }
    
    // Delete category (AJAX)
    public function deleteCategory() {
        $this->requireAuth();
        $this->requireAdmin();
        
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        $id = $_POST['id'] ?? null;
        
        if (!$id || !is_numeric($id)) {
            echo json_encode(['success' => false, 'message' => 'Invalid category ID']);
            return;
        }
        
        // Check if category exists
        $category = $this->categoryModel->findById($id);
        if (!$category) {
            echo json_encode(['success' => false, 'message' => 'Category not found']);
            return;
        }
        
        $result = $this->categoryModel->delete($id);
        
        echo json_encode($result);
    }
}