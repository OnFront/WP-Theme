export class Maintenance {
    constructor(node) {
        this.components = {
            footer: node.querySelector('[data-js-footer]'),
            counter: node.querySelector('[data-js-counter]'),
        }

        this.state = {
            counter: parseInt(this.components.counter.innerHTML),
        }

        setInterval(() => {
            this.state.counter--;
            this.render();
        }, 1000);
    }

    render() {
        if (this.state.counter > 0) {
            this.components.counter.innerHTML = this.state.counter;
        } else {
            this.components.footer.innerHTML = '<a class="maintenance__link" href="/">Refresh page</a>';
        }
    }
}
