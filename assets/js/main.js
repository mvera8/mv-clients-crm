// main.js
import 'bootstrap';
// import 'bootstrap/js/dist/collapse';
import Tooltip from 'bootstrap/js/dist/tooltip';
import '../css/style.scss';

document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new Tooltip(el));
