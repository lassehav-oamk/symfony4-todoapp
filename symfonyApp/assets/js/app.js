/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// var $ = require('jquery');

import axios from 'axios';


function handleMarkIsDoneClick(event)
{
    console.log(event);

    const todoId = event.target.getAttribute('data-id');
    console.log('data-id: ' + todoId);


    axios.post(`/todo/${todoId}/toggleIsDone`)
        .then(function (response) {
            console.log(response);
            if(response.status == 200)
            {
                location.reload();
            }
        })
        .catch(function (error) {
            console.log(error);
        });
}

let todoMarkers = document.querySelectorAll(".mark_done");
todoMarkers.forEach(function(marker) {
    marker.addEventListener("click", handleMarkIsDoneClick);
});

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
