
// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

import './styles/app.scss';
import Filter from './js/Filter';
import noUiSlider from 'nouislider'
import 'nouislider/dist/nouislider.css';


new Filter(document.querySelector('.js-filter'));

// Filtre slider

const priceSlider = document.getElementById('price-slider');

if (priceSlider) {
    const min = document.getElementById('minPrice')
    const max = document.getElementById('maxPrice')
    const minValue = Math.floor(parseInt(priceSlider.dataset.min, 10) /1000) * 1000
    const maxValue = Math.ceil(parseInt(priceSlider.dataset.max, 10) /1000) * 1000

    const range = noUiSlider.create(priceSlider, {
        start: [min.value || minValue, max.value || maxValue],
        connect: true,
        range: {
            'min': minValue,
            'max': maxValue
        },
        step: 1000,
        tooltips: true,
        
    })
    range.on('end', function (values, handle) {
        if (handle === 0) {
            min.value = Math.round(values[0])
            min.dispatchEvent(new Event('change'))
        }
        if (handle === 1) {
            max.value = Math.round(values[1])
            max.dispatchEvent(new Event('change'))
        }
        console.log(minValue, maxValue);
    })
    
}



