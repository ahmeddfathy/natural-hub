<?php

// 1. Update Models to automatically assign sort_order
$models = [
    'Category' => 'category',
    'Field' => 'field',
    'VideoCategory' => 'category',
    'Video' => 'video',
    'PortfolioCategory' => 'category',
    'Portfolio' => 'portfolio',
];

foreach ($models as $class => $varName) {
    $path = __DIR__ . "/app/Models/{$class}.php";
    if (file_exists($path)) {
        $content = file_get_contents($path);
        $inject = "
            if (!isset(\${$varName}->sort_order)) {
                \${$varName}->sort_order = static::max('sort_order') + 1;
            }";
        
        // Find static::creating
        if (strpos($content, '{ $'.$varName.'->sort_order =') === false && strpos($content, "if (!isset(\${$varName}->sort_order))") === false) {
            $pattern = '/static::creating\(\s*function\s*\(\$.*?\)\s*\{/i';
            $content = preg_replace($pattern, "$0" . $inject, $content);
            file_put_contents($path, $content);
            echo "Updated Model: $class\n";
        }
    }
}

// 2. Update views `index.blade.php` to add `sort_order` editable field
$views = [
    'categories' => ['model' => 'Category', 'var' => 'category'],
    'fields' => ['model' => 'Field', 'var' => 'field'],
    'portfolio' => ['model' => 'Portfolio', 'var' => 'portfolio'],
    'portfolio-categories' => ['model' => 'PortfolioCategory', 'var' => 'category'],
    'video-categories' => ['model' => 'VideoCategory', 'var' => 'category'],
    'videos' => ['model' => 'Video', 'var' => 'video'],
];

foreach ($views as $dir => $meta) {
    $path = __DIR__ . "/resources/views/admin/{$dir}/index.blade.php";
    if (file_exists($path)) {
        $content = file_get_contents($path);
        
        if (strpos($content, 'quick-sort') === false) {
            // Find the Name column to insert the new column header
            $headerPattern = '/<th>[^<]*الاسم<\/th>/hu';
            $thInject = "<th style=\"width: 100px;\"><i class=\"fas fa-sort-numeric-down\"></i> الترتيب</th>\n                    $0";
            $content = preg_replace($headerPattern, $thInject, $content, 1);
            
            // For categories/fields they have Name column, let's just match the first <td> after the row start or specific class
            // Actually it's safer to target the <td> containing the name text. Let's find something specific.
            // Let's insert before <td>.*name.*</td> if possible. This regex might be hard.
            // For a simpler approach, replace `<tr>` in tbody with logic? Too complex.
            // Let's just find `<td>{{ $var->name` or similar
        }
    }
}
