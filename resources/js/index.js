import {LazyLoad} from "./bootstrap/LazyLoad";
import WOW from "wow.js/dist/wow";
import {NavSticky} from "./bootstrap/NavSticky";
import {NavMenu} from "./bootstrap/NavMenu";
import {Accordion} from "./bootstrap/Accordion";
import "slick-carousel";
import {loadClass} from "./common/functions";
import {Countdown} from "../../templates/shared/countdown/countdown";
import {Popover} from "../../templates/shared/popover/popover";
import {CustomerZoneVideo} from "../../templates/pages/customer-zone/video/customer-zone-video";
import {CustomerZoneIntro} from "../../templates/pages/customer-zone/intro/customer-zone-intro";
import {CustomerZoneApplication} from "../../templates/pages/customer-zone/application/customer-zone-application";
import {DownloadApp} from "../../templates/shared/download-app/download-app";
import {BusinessZoneIntro} from "../../templates/pages/business-zone/intro/business-zone-intro";
import {BusinessZoneEyePosColor} from "../../templates/pages/business-zone/eye-pos-color/business-zone-eye-pos-color";
import {Faq} from "../../templates/pages/faq/faq";
import {Contact} from "../../templates/pages/contact/contact";
import {Media} from "../../templates/pages/media/media";
import {AboutUsPayEye} from "../../templates/pages/about-us/payeye/about-us-payeye";
import {CookieBanner} from "../../templates/shared/cookie/cookie-banner";
import {Maintenance} from "../../templates/pages/maintenance/maintenance";
import {Questions} from "../../templates/pages/questions/questions";
import {TeamKey} from "../../templates/pages/team/key/team-key";
import {BusinessZone20} from "../../templates/pages/business-zone/2.0/business-zone-2-0";
import {BusinessZonePricing1} from "../../templates/pages/business-zone/pricing/1/business-zone-pricing-1";
import {PromotionApplication} from "../../templates/pages/promotion-application/promotion-application";
import {BusinessZoneVideo} from "../../templates/pages/business-zone/video/business-zone-video";
import {Courses} from "../../templates/pages/courses/courses";
import {ModalCourse} from '../../templates/pages/courses/modal/modal';
import {CardQR} from '../../templates/shared/card-qr/card-qr';

new LazyLoad("body");

if (document.querySelector('[data-js-navigation]')) {
    new NavSticky('[data-js-navigation]', new NavMenu());
}

new Accordion();

loadClass('[data-js-download-app]', DownloadApp);
loadClass('[data-js-countdown]', Countdown);
loadClass('[data-js-popover]', Popover);
loadClass('[data-js-customer-zone-video]', CustomerZoneVideo);
loadClass('[data-js-customer-zone-intro]', CustomerZoneIntro);
loadClass('[data-js-customer-zone-application]', CustomerZoneApplication);
loadClass('[data-js-business-zone-intro]', BusinessZoneIntro);
loadClass('[data-js-business-zone-eye-pos-color]', BusinessZoneEyePosColor);
loadClass('[data-js-faq]', Faq);
loadClass('[data-js-contact]', Contact);
loadClass('[data-js-media]', Media);
loadClass('[data-js-about-us-payeye]', AboutUsPayEye);
loadClass('[data-js-cookie]', CookieBanner);
loadClass('[data-js-maintenance]', Maintenance);
loadClass('[data-js-questions]', Questions);
loadClass('[data-js-team-key]', TeamKey);
loadClass('[data-js-eye-pos-2-0]', BusinessZone20);
loadClass('[data-js-business-zone-pricing-1]', BusinessZonePricing1);
loadClass('[data-js-promotion-application]', PromotionApplication);
loadClass('[data-js-business-zone-video]', BusinessZoneVideo);
loadClass('[data-js-courses]', Courses);
loadClass('[data-js-modal-course]', ModalCourse);
loadClass('[data-js-card-qr]', CardQR);

const wow = new WOW({
    boxClass: 'wow',      // animated element css class (default is wow)
    animateClass: 'animated', // animation css class (default is animated)
    offset: 100,          // distance to the element when triggering the animation (default is 0)
    mobile: false,       // trigger animations on mobile devices (default is true)
    live: true,       // act on asynchronously loaded content (default is true)
    callback: function (box) {
        // the callback is fired every time an animation is started
        // the argument that is passed in is the DOM node being animated
    }, scrollContainer: null // optional scroll container selector, otherwise use window
});
wow.init();
