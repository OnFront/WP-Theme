import {ScrollTo} from "../../../shared/scroll-to/ScrollTo";

export class CustomerZoneVideo {
    constructor(node) {
        this.node = node;
        new ScrollTo(node.querySelector('[data-js-scroll-to]'), '#application');

        node.querySelector('video').currentTime = 3;
    }
}
