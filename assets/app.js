/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// Styles
import './styles/app.scss';

// jQuery
const $ = require('jquery');

// Stimulus
import './bootstrap';

// Bootstrap
import 'bootstrap';
import bsCustomFileInput from 'bs-custom-file-input';
bsCustomFileInput.init();

// Font Awesome
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');