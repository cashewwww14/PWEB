<?php 
$title = 'Add News - Admin Panel';
require_once APP_PATH . '/views/layouts/header.php'; 
?>

<style>
    .custom-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .back-link {
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        backdrop-filter: blur(10px);
        display: inline-flex;
        align-items: center;
    }
    .back-link:hover {
    background: rgba(255, 255, 255, 0.3);
    }

</style>

<header class="custom-gradient text-white p-6 flex justify-between items-center">
    <div class="flex items-center">
        <a href="/admin/dashboard" class="back-link flex items-center mr-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Dashboard
        </a>
        <h1 class="text-xl font-semibold">Add News Article</h1>
    </div>
</header>


<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8">
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <strong>Error:</strong> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="/admin/add-news" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Article Title</label>
                    <input type="text" name="title" id="title" required 
                           value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter article title">
                </div>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <div class="flex space-x-2">
                        <select name="category_id" id="category_id" required 
                                class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value=""disabled selected style="color: gray;">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" 
                                        <?= (isset($_POST['category_id']) && $_POST['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" onclick="openCategoryModal()" 
                                class="px-4 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:ring-2 focus:ring-green-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div>
                    <label for="release_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Release Date & Time
                    </label>
                    <input type="datetime-local" name="release_date" id="release_date" required 
                        value="<?= $_POST['release_date'] ?? '' ?>"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Set when this article should be published</p>
                </div>
                
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                    <input type="file" name="image" id="image" required accept="image/*"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-sm text-gray-500 mt-1">Supported formats: JPG, JPEG, PNG, GIF (max 5MB)</p>
                </div>
                
                <div class="md:col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Article Content</label>
                    <textarea name="content" id="content" rows="12" required 
                              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Write your article content here..."><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
                </div>
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="/admin/dashboard" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                    Publish Article
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Category Management Modal -->
<div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Manage Categories</h3>
                <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Add New Category -->
            <div class="mb-4">
                <div class="flex space-x-2">
                    <input type="text" id="newCategoryName" placeholder="New category name" 
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <button onclick="addCategory()" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Add
                    </button>
                </div>
            </div>
            
            <!-- Categories List -->
            <div class="max-h-64 overflow-y-auto">
                <div id="categoriesList" class="space-y-2">
                    <?php foreach ($categories as $category): ?>
                        <div class="flex items-center justify-between bg-gray-50 p-2 rounded" id="category-<?= $category['id'] ?>">
                            <span class="category-name"><?= htmlspecialchars($category['name']) ?></span>
                            <div class="flex space-x-1">
                                <button onclick="editCategory(<?= $category['id'] ?>, '<?= addslashes($category['name']) ?>')" 
                                        class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteCategory(<?= $category['id'] ?>, '<?= addslashes($category['name']) ?>')" 
                                        class="text-red-600 hover:text-red-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openCategoryModal() {
    document.getElementById('categoryModal').classList.remove('hidden');
}

function closeCategoryModal() {
    document.getElementById('categoryModal').classList.add('hidden');
}

function addCategory() {
    const nameInput = document.getElementById('newCategoryName');
    const name = nameInput.value.trim();
    
    if (!name) {
        alert('Please enter a category name');
        return;
    }
    
    fetch('/admin/category/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `name=${encodeURIComponent(name)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            nameInput.value = '';
            refreshCategories();
        } else {
            alert(data.message || 'Failed to add category');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}

function editCategory(id, currentName) {
    const newName = prompt('Edit category name:', currentName);
    if (newName && newName !== currentName) {
        fetch('/admin/category/edit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&name=${encodeURIComponent(newName)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                refreshCategories();
            } else {
                alert(data.message || 'Failed to update category');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
        });
    }
}

function deleteCategory(id, name) {
    if (confirm(`Are you sure you want to delete "${name}"?`)) {
        fetch('/admin/category/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                refreshCategories();
            } else {
                alert(data.message || 'Failed to delete category');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred');
        });
    }
}

function refreshCategories() {
    fetch('/admin/category/list')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update categories list in modal
            const categoriesList = document.getElementById('categoriesList');
            categoriesList.innerHTML = '';
            
            data.categories.forEach(category => {
                const categoryEl = document.createElement('div');
                categoryEl.className = 'flex items-center justify-between bg-gray-50 p-2 rounded';
                categoryEl.id = `category-${category.id}`;
                categoryEl.innerHTML = `
                    <span class="category-name">${category.name}</span>
                    <div class="flex space-x-1">
                        <button onclick="editCategory(${category.id}, '${category.name.replace(/'/g, "\\\'")}')" 
                                class="text-blue-600 hover:text-blue-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        <button onclick="deleteCategory(${category.id}, '${category.name.replace(/'/g, "\\\'")}')" 
                                class="text-red-600 hover:text-red-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                `;
                categoriesList.appendChild(categoryEl);
            });
            
            // Update main category dropdown
            const categorySelect = document.getElementById('category_id');
            const selectedValue = categorySelect.value;
            categorySelect.innerHTML = '<option value="">Select Category</option>';
            
            data.categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                if (category.id == selectedValue) {
                    option.selected = true;
                }
                categorySelect.appendChild(option);
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Close modal when clicking outside
document.getElementById('categoryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCategoryModal();
    }
});
</script>