
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
import wNumb from './js/wNumb';


new Filter(document.querySelector('.js-filter'));

// Filtre slider

const priceSlider = document.getElementById('price-slider');
const yearsSlider = document.getElementById('years-slider');
const mileageSlider = document.getElementById('mileage-slider');

if (priceSlider) {
    const min = document.getElementById('minPrice')
    const max = document.getElementById('maxPrice')
    const minValue = Math.round(parseInt(priceSlider.dataset.min, 10) /1000) * 1000
    const maxValue = Math.round(parseInt(priceSlider.dataset.max, 10) /1000) * 1000

    const range = noUiSlider.create(priceSlider, {
        start: [min.value || minValue, max.value || maxValue],
        connect: true,
        range: {
            'min': minValue,
            'max': maxValue
        },
        step: 1000,
        tooltips: true,
        format: wNumb({decimals: 0,
        thousand: '.',
        suffix: ' €'})
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
    })
    
}

if (yearsSlider) {
    const minYears = document.getElementById('minYears')
    const maxYears = document.getElementById('maxYears')
    const minValueYears = parseInt(yearsSlider.dataset.min, 10)
    const maxValueYears = parseInt(yearsSlider.dataset.max, 10)

    const range = noUiSlider.create(yearsSlider, {
        start: [minYears.value || minValue, maxYears.value || maxValue],
        connect: true,
        range: {
            'min': minValueYears,
            'max': maxValueYears
        },
        step: 1,
        tooltips: true,
        format: wNumb({decimals: 0})
        
    })
    range.on('end', function (values, handle) {
        if (handle === 0) {
            minYears.value = Math.round(values[0])
            minYears.dispatchEvent(new Event('change'))
        }
        if (handle === 1) {
            maxYears.value = Math.round(values[1])
            maxYears.dispatchEvent(new Event('change'))
        }
    })
    
}
if (mileageSlider) {
    const minMileage = document.getElementById('minMileage')
    const maxMileage = document.getElementById('maxMileage')
    const minValueMileage = parseInt(mileageSlider.dataset.min, 10)
    const maxValueMileage = parseInt(mileageSlider.dataset.max, 10)

    const range = noUiSlider.create(mileageSlider, {
        start: [minMileage.value || minValue, maxMileage.value || maxValue],
        connect: true,
        range: {
            'min': minValueMileage,
            'max': maxValueMileage
        },
        step: 1000,
        tooltips: true,
        format: wNumb({decimals: 0,
        thousand: '.',
        suffix: ' km'})
        
    })
    range.on('end', function (values, handle) {
        if (handle === 0) {
            minMileage.value = Math.round(values[0])
            minMileage.dispatchEvent(new Event('change'))
        }
        if (handle === 1) {
            maxMileage.value = Math.round(values[1])
            maxMileage.dispatchEvent(new Event('change'))
        }
    })
    
}



