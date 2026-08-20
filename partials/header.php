<?php
declare(strict_types=1);

$pageTitle = $pageTitle ?? $content['meta']['title'];
$pageDescription = $pageDescription ?? $content['meta']['description'];
$canonicalPath = $canonicalPath ?? '';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <meta name="theme-color" content="#fff9f7">
    <link rel="canonical" href="<?= e(url($canonicalPath)) ?>">
    <link rel="icon" href="assets/images/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="assets/images/apple-touch-icon.png">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:site_name" content="<?= e($content['brand']) ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:url" content="<?= e(url($canonicalPath)) ?>">
    <meta property="og:image" content="<?= e(url('assets/images/og-cover.webp')) ?>">
    <link rel="stylesheet" href="assets/css/style.css?v=1.0.0">
</head>
<body>
<a class="skip-link" href="#main">К содержанию</a>

