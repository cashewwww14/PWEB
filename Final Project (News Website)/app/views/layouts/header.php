<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'News Portal' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dropdown-content {
            display: none;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
    <?= $additional_css ?? '' ?>
</head>
<body class="bg-gray-100">