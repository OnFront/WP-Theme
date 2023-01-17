export class MapPointsCount {
    constructor(node) {
        this.node = node;
        this.counterNode = node.querySelector('[data-js-map-points-counter]');

        this.state = {
            counter: 0,
        }
    }

    setState(state) {
        this.state = state;
        this.render();
    }

    setCounter(counter) {
        this.state.counter = counter;
        this.render();
    }

    render() {
        this.node.style.display = "block";

        this.counterNode.innerHTML = this.state.counter;

        if (this.state.counter === 0) {
            this.node.style.display = "none";
        }
    }
}
