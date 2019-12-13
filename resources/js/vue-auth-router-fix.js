/**
 * Fix for error of promise "NavigationDuplicated"
 * See: https://github.com/websanova/vue-auth/issues/503
 */
const vue_router_driver = require('@websanova/vue-auth/drivers/router/vue-router.2.x.js');
vue_router_driver._routerGo =  function (data) {
    let router = this.options.Vue.router;
    (router.push || router.go).call(router, data).catch((err) => {});
}

module.exports = vue_router_driver;
