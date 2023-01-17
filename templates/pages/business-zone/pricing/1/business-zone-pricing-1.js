import {ScrollTo} from "../../../../shared/scroll-to/ScrollTo";

export class BusinessZonePricing1 {
    constructor(node) {
        new ScrollTo(node.querySelector('[data-js-scroll-to]'), '#order-form');
    }
}
