window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');
window.moment = require('moment');

window.swal = require('sweetalert');
window.marked = require('marked');
// window.hljs = require('../vendor/highlight/highlight.min.js');

window.toastr = require('toastr/build/toastr.min.js');
window.toastr.options = {
    positionClass: "toast-bottom-right",
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
};

require('social-share.js/dist/js/social-share.min.js');

require('./init.js');

