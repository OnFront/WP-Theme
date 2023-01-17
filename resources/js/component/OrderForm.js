import {Select} from "../../../templates/shared/@select/select";

export class OrderForm {
    constructor(node) {
        new Select(node.querySelector('[name="voivodeship"]'), {
            isRemoveFirstElement: true,
        });

        new Select(node.querySelector('[name="industry"]'), {
            isRemoveFirstElement: true,
        });

        new Select(node.querySelector('[name="product"]'), {
            isRemoveFirstElement: true,
        });
    }
}
