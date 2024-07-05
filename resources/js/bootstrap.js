import axios from 'axios';
window.axios = axios;

import tippy from 'tippy.js';
window.tippy = tippy;
import 'tippy.js/dist/tippy.css'; // optional for styling
import "tippy.js/themes/material.css";

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
