import {loadClass} from "./common/functions";
import {Promotion} from "../../templates/pages/promotion/promotion";
import {PromotionBigSixApplication} from "../../templates/pages/promotion-big-six-application/promotion-big-six-application";

loadClass('[data-js-promotion]', Promotion);
loadClass('[data-js-promotion-big-six-application]', PromotionBigSixApplication);
