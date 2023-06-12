<?php
// Fonction de routage
function route($url)
{
    // Définir les routes disponibles
    $routes = array(
        '/' => '../coktail/src/page/index',
        '/about' => 'about',
        '/contact' => 'contact'
    );

    // Vérifier si l'URL demandée correspond à une route existante
    if (array_key_exists($url, $routes)) {
        // Inclure le fichier correspondant à la route
        include $routes[$url] . '.php';
    } else {
        // Afficher une erreur 404 si la route n'est pas trouvée
        include '404.php';
    }
}

// Obtenir l'URL courante
$url = $_SERVER['REQUEST_URI'];

// Appeler la fonction de routage avec l'URL courante
route($url);
?>