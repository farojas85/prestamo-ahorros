window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    //require('bootstrap');
    require('admin-lte')
    //require('admin-lte/plugins/jquery-ui/jquery-ui')
    require('admin-lte/plugins/bootstrap/js/bootstrap.bundle')
    require('admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars')
} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
