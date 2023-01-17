import {ScrollTo} from "../../../shared/scroll-to/ScrollTo";

export class BusinessZoneIntro {
    constructor(node) {
        new ScrollTo(node.querySelector('[data-js-scroll-to]'), '#video', 50);
    }
}
