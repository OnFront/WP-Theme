import {ScrollTo} from "../../../shared/scroll-to/ScrollTo";

export class CustomerZoneIntro {
    constructor(node) {
        new ScrollTo(node.querySelector('[data-js-scroll-to]'), '#application');
    }
}
