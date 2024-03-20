import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';

// const $ = require('jquery');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// loads the jquery package from node_modules
import $ from 'jquery';

$(document).ready(function() {
    console.log("Hello World");
    $("#filter").change(function(){
        console.log("Change")
        // Fonction pour effectuer la requête asynchrone
async function fetchData(filter) { // fonction asynchrone, car on attend une réponse du serveur avec await
  try {
    // Construit l'URL avec le filtre
    const url = `/${filter}`;

    // Exécute la requête asynchrone
    const response = await fetch(url, {  // attente de la réponse
      method: 'GET', // Méthode HTTP
      headers: {
        'Content-Type': 'application/json', // Type de contenu attendu de la réponse, voir types MIME
      },
    });

    // Vérifie si la requête a réussi
    if (!response.ok) {
      throw new Error(`Erreur: ${response.status}`); // Lance une exception si la réponse est une erreur
    }

    // Extrait les données JSON de la réponse
    const data = await response.json();

    // Ici, vous pouvez traiter les données JSON retournées
    console.log(data); // Affiche les données dans la console pour le debug

    // Pour afficher les données sur votre page, vous devez décider comment
    // vous souhaitez les afficher et mettre à jour le DOM en conséquence.
    // Par exemple, si vous avez un élément avec l'id 'dataContainer' :
  //  const container = document.getElementById('dataContainer');
  //  container.textContent = JSON.stringify(data, null, 2); // Convertit les données JSON en chaîne et les affiche
  } catch (error) {
    console.error("Il y a eu une erreur avec la requête fetch: ", error.message);
  }
}
filter= $(this).find(":selected").val();
// Appel de la fonction avec le filtre désiré, par exemple 'monFiltre'
fetchData(filter);
    });
});

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

