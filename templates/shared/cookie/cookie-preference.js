export class CookiePreference {
    constructor(node) {
        this.node = node;

        this.components = {
            acceptAll: this.node.querySelector('[data-js-accept-all]'),
            analytics: this.node.querySelector('[data-js-analytics-value]'),
            ads: this.node.querySelector('[data-js-ads-value]'),
        }

        this.state = {
            analytics: this.components.analytics.checked,
            ads: this.components.ads.checked,
        }

        this.components.acceptAll.addEventListener('click', () => {
            this.state.analytics = true;
            this.state.ads = true;
            this.render();
        })

        this.components.analytics.addEventListener('click', () => {
            this.state.analytics = this.components.analytics.checked;
        })

        this.components.ads.addEventListener('click', () => {
            this.state.ads = this.components.ads.checked;
        })
    }

    render() {
        this.components.analytics.checked = this.state.analytics;
        this.components.ads.checked = this.state.ads;
    }
}
