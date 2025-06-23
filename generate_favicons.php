<?php

// Script pour générer les favicons à partir du logo
// Nécessite l'extension GD de PHP

if (!extension_loaded('gd')) {
    die("L'extension GD de PHP n'est pas installée. Impossible de générer les favicons.\n");
}

echo "Génération des favicons à partir du logo...\n";

// Chemin du logo source
$logoPath = 'public/images/logo.png';

if (!file_exists($logoPath)) {
    die("Le fichier logo.png n'existe pas dans public/images/\n");
}

// Créer le dossier images s'il n'existe pas
$imagesDir = 'public/images';
if (!is_dir($imagesDir)) {
    mkdir($imagesDir, 0755, true);
}

// Fonction pour redimensionner et sauvegarder une image
function createFavicon($sourcePath, $outputPath, $size) {
    $source = imagecreatefrompng($sourcePath);
    if (!$source) {
        echo "Erreur: Impossible de charger l'image source\n";
        return false;
    }
    
    $dest = imagecreatetruecolor($size, $size);
    
    // Rendre le fond transparent
    imagealphablending($dest, false);
    imagesavealpha($dest, true);
    $transparent = imagecolorallocatealpha($dest, 255, 255, 255, 127);
    imagefill($dest, 0, 0, $transparent);
    
    // Redimensionner
    imagecopyresampled($dest, $source, 0, 0, 0, 0, $size, $size, imagesx($source), imagesy($source));
    
    // Sauvegarder
    $result = imagepng($dest, $outputPath);
    
    imagedestroy($source);
    imagedestroy($dest);
    
    return $result;
}

// Générer les différents formats
$sizes = [
    'favicon-16x16.png' => 16,
    'favicon-32x32.png' => 32,
    'apple-touch-icon.png' => 180
];

foreach ($sizes as $filename => $size) {
    $outputPath = $imagesDir . '/' . $filename;
    if (createFavicon($logoPath, $outputPath, $size)) {
        echo "✓ $filename généré ($size x $size)\n";
    } else {
        echo "✗ Erreur lors de la génération de $filename\n";
    }
}

// Créer un favicon.ico simple (copie du 16x16)
if (file_exists($imagesDir . '/favicon-16x16.png')) {
    copy($imagesDir . '/favicon-16x16.png', $imagesDir . '/favicon.ico');
    echo "✓ favicon.ico créé\n";
}

// Créer le fichier site.webmanifest
$manifest = [
    'name' => 'MUDEZI - Association du Village',
    'short_name' => 'MUDEZI',
    'description' => 'Site officiel de l\'association MUDEZI pour le développement communautaire',
    'start_url' => '/',
    'display' => 'standalone',
    'background_color' => '#003399',
    'theme_color' => '#003399',
    'icons' => [
        [
            'src' => '/images/favicon-16x16.png',
            'sizes' => '16x16',
            'type' => 'image/png'
        ],
        [
            'src' => '/images/favicon-32x32.png',
            'sizes' => '32x32',
            'type' => 'image/png'
        ],
        [
            'src' => '/images/apple-touch-icon.png',
            'sizes' => '180x180',
            'type' => 'image/png'
        ]
    ]
];

$manifestPath = $imagesDir . '/site.webmanifest';
file_put_contents($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "✓ site.webmanifest créé\n";

echo "\nGénération terminée ! Les favicons sont maintenant disponibles dans public/images/\n";
echo "Rafraîchis ton navigateur pour voir le favicon dans l'onglet.\n";

?> 