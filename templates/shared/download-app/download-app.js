import {ApplicationBadge} from "../@application-badge/application-badge";

export class DownloadApp {
    constructor(node) {
        this.node = node;

        const applicationBadge = new ApplicationBadge();

        this.link = applicationBadge.link;
        this.icon = applicationBadge.icon;

        this.render();
    }

    render() {
        if (this.link) {
            this.node.querySelector('[data-js-href]').href = this.link;
        }

        if (this.icon) {
            const image = this.node.querySelector('[data-js-image]');

            if (image) {
                image.src = this.icon;
            }
        }
    }
}
