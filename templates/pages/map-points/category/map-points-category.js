export class MapPointsCategory {
    constructor(node) {
        this.node = node;
    }

    show() {
        this.node.classList.add('map-points-category--active');
    }

    hide() {
        this.node.classList.remove('map-points-category--active');
    }
}
