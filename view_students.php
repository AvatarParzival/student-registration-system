<?php
session_start();
if (!isset($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
require_once 'db.php';

$students = $conn->query(
    "SELECT id, name, email, roll_number, department, completed
     FROM students
     ORDER BY id DESC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .toggle-checkbox:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #3b82f6;
        }
        .toggle-checkbox:focus + .toggle-label {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }
        @media (max-width: 768px) {
            .responsive-table thead {
                display: none;
            }
            .responsive-table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #e2e8f0;
                border-radius: 0.375rem;
            }
            .responsive-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem;
                border-bottom: 1px solid #e2e8f0;
            }
            .responsive-table td:before {
                content: attr(data-label);
                font-weight: 600;
                color: #4a5568;
                margin-right: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">Registered Students</h1>
                    <a href="index.html" class="flex items-center text-white hover:text-blue-200 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span class="hidden sm:inline">Back to Registration</span>
                    </a>
                </div>
            </div>

            <div class="p-6">
                <?php if ($students && $students->num_rows): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 responsive-table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roll No.</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dept</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php while ($s = $students->fetch_assoc()): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" data-label="Name"><?= htmlspecialchars($s['name']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-label="Email"><?= htmlspecialchars($s['email']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-label="Roll"><?= htmlspecialchars($s['roll_number']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-label="Department"><?= htmlspecialchars($s['department']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-label="Action">
                                            <form method="post" action="delete_student.php" onsubmit="return confirm('Delete this student?')">
                                                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                                                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-user-graduate text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900">No students registered yet</h3>
                        <p class="mt-2 text-sm text-gray-500">Get started by registering new students</p>
                        <div class="mt-6">
                            <a href="index.html" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Register Student
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-checkbox').forEach(cb => {
            cb.addEventListener('change', e => {
                fetch('toggle.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `id=${e.target.dataset.id}&csrf=<?= $_SESSION['csrf'] ?>`
                });
            });
        });
    </script>
</body>
</html>