export class MapPointsSearch {
    constructor(node) {
        this.node = node;
        this.inputSearch = node.querySelector('[data-js-search]');

        const urlSearchParams = new URLSearchParams(window.location.search);
        const params = Object.fromEntries(urlSearchParams.entries());
        const {query} = params;

        if (query) {
            this.inputSearch.value = query;
        }
    }

    show() {
        this.node.classList.add('map-points-search--active');
    }

    hide() {
        this.node.classList.remove('map-points-search--active');
    }
}
