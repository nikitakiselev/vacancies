
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        area_id: 1,
        query: '',
        page: 1,
        results: []
    },

    watch: {
        query: function (newQuery) {
            this.results = [];
            this.page = 0;

            if (newQuery.length) {
                this.search(newQuery, this.page);
            }
        },

        page: function (newPage) {
            $('html, body').animate({
                scrollTop: $("#search-results").offset().top
            }, 1000);

            this.search(this.query, newPage);
        },

        area_id: function (newAreaId) {
            this.search(this.query, this.page);
        }
    },

    methods: {
        search: function (query, page = 0) {

            let data = {
                query: query,
                page: page,
                area: this.area_id
            };

            $.getJSON('/search', data, function (response) {
                this.results = response;
            }.bind(this));
        },

        nextPage: function () {
            this.page++;
        },

        prevPage: function () {
            this.page--;
        }
    }
});