import {ApplicationBadge} from "../../../shared/@application-badge/application-badge";

export class CustomerZoneApplication {
    constructor(node) {
        const applicationBadge = new ApplicationBadge();

        node.querySelector('[data-js-badge-link]').href = applicationBadge.link;
        node.querySelector('[data-js-badge-image]').src = applicationBadge.icon;
    }
}
