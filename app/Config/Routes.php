<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$routes->get('rekencontroller', 'RekenController::index'); // Startpagina van de rekenapplicatie
$routes->get('/rekencontroller/kiesAantalSommen', 'RekenController::kiesAantalSommen'); // Pagina voor het kiezen van het aantal sommen
$routes->get('/rekencontroller/kiesSoortSommen', 'RekenController::kiesSoortSommen'); // Pagina voor het kiezen van het soort sommen
$routes->get('/rekencontroller/oefenSommen', 'RekenController::oefenSommen'); // Pagina voor het oefenen van sommen
$routes->post('rekencontroller/kiesSoortSommen', 'RekenController::kiesSoortSommen'); // Verwerkt het formulier voor het kiezen van het soort sommen
$routes->get('rekencontroller/beantwoordSommen/(:num)', 'RekenController::beantwoordSommen/$1'); // Pagina voor het beantwoorden van individuele sommen
$routes->get('rekencontroller/controleerAntwoorden', 'RekenController::controleerAntwoorden'); // Verwerkt het formulier voor het controleren van de antwoorden
$routes->get('rekencontroller/oefenen', 'RekenController::oefenen'); // Pagina voor het oefenen van sommen 
$routes->post('rekencontroller/kiesAantalSommen', 'RekenController::kiesAantalSommen'); // Verwerkt het formulier voor het kiezen van het aantal sommen
$routes->get('/', 'RekenController::index'); // Startpagina van de rekenapplicatie 
$routes->post('rekencontroller/instellenMaxGetal', 'RekenController::instellenMaxGetal'); // Verwerkt het formulier voor het instellen van het maximale getal
$routes->post('rekencontroller/controleerAntwoorden', 'RekenController::controleerAntwoorden'); // Verwerkt het formulier voor het controleren van de antwoorden


// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
