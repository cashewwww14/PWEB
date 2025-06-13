<header class="bg-blue-600 text-white p-4 flex justify-between items-center">
    <div class="flex items-center">
        <a href="/" class="hover:opacity-90 transition-opacity">
            <img src="/assets/NexTC.png" 
                 alt="News Portal" 
                 class="h-10 w-auto object-contain">
        </a>
    </div>
    <div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="mr-4">Hello, <?= $_SESSION['role'] === 'admin' ? 'Admin' : htmlspecialchars($user_name ?? 'User') ?></span>
            <div class="relative inline-block">
                <button id="dropdownButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">
                    Dashboard
                </button>
                <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden" style="z-index: 9999;">
                    <div class="py-1">
                        <a href="<?= $_SESSION['role'] === 'admin' ? '/admin/dashboard' : '/user/dashboard' ?>" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            Go to Dashboard
                        </a>
                        <a href="/auth/logout" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700">
                            Sign Out
                        </a>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('dropdownButton').addEventListener('click', function() {
                    var menu = document.getElementById('dropdownMenu');
                    menu.classList.toggle('hidden');
                });
            </script>
        <?php else: ?>
            <a href="/auth/login" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</a>
            <a href="/auth/register" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 ml-2">Register</a>
        <?php endif; ?>
    </div>
</header>