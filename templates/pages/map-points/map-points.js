import {GoogleMap} from "../../../resources/js/common/GoogleMap";
import {currentLanguage} from "../../../resources/js/common/Language";
import {MerchantsApi} from "../../../resources/js/api/front/MerchantsApi";
import {InputCheckbox} from "../../shared/input-chekbox/input-checkbox";
import {ListPartners} from "./list/list-partners";
import {MapPointsCount} from "./count/map-points-count";
import {MapPointsMerchant} from "./merchant/map-points-merchant";
import {MapPointsCategory} from "./category/map-points-category";
import {MapPointsSearch} from "./search/map-points-search";

export class MapPoints {
    constructor(node) {
        this.node = node;

        this.node.querySelectorAll('[data-js-checkbox]').forEach(node => new InputCheckbox(node));

        this.googleMap = new GoogleMap(true);
        this.currentLanguage = currentLanguage();
        this.selectCategory = node.querySelectorAll('[name="category"]');
        this.openCategoryNodes = node.querySelectorAll('[data-js-open-category]');
        this.closeCategoryNodes = node.querySelectorAll('[data-js-close-category]');
        this.listWrapper = node.querySelector('[data-js-map-points-list-wrapper]');
        this.openListNodes = node.querySelectorAll('[data-js-open-list]');

        this.search = new MapPointsSearch(node.querySelector('[data-js-map-points-search]'));
        this.listPartners = new ListPartners(node);
        this.category = new MapPointsCategory(node.querySelector('[data-js-map-point-category]'));
        this.count = new MapPointsCount(node.querySelector('[data-js-map-points-count]'));
        this.merchant = new MapPointsMerchant(node.querySelector('[data-js-map-points-merchant]'));
        
        window.map = this.googleMap.map;

        this.state = {
            markers: [],
            data: {
                ids: [],
                isPromo: false
            },
            onLoad: true,
        }

        const breakpointDesktopHeader = 1200; 
        
        this.isDesktopHeader = window.innerWidth > breakpointDesktopHeader;

        if (this.isDesktopHeader) {
            this.showList();
        }

        if (this.search.inputSearch.value) {
            this.listPartners.showPostsByTermsAndIsPromo(this.state.data.ids, this.state.data.isPromo);
            this.listPartners.showPostsByContainsTitle(this.search.inputSearch.value);
            this.showList();
        }

        this.mounted();
        this.events();
    }

    mounted() {
        MerchantsApi.getMerchants().then(response => this.showPartners(response));

        this.selectCategory.forEach(checkbox => checkbox.addEventListener('click', () => {
            const value = checkbox.value;

            if (checkbox.checked && !this.state.data.ids.includes(value)) {
                this.state.data.ids.push(value);
            } else {
                this.state.data.ids = this.state.data.ids.filter(id => id !== value);
            }

            if (this.state.data.ids) {
                MerchantsApi.getMerchantsByTermIdsAndByIsPromo(this.state.data).then(response => this.showPartners(response));
            } else {
                MerchantsApi.getMerchants().then(response => this.showPartners(response));
            }

            this.count.setCounter(this.state.data.ids.length);

            this.listPartners.showPostsByTermsAndIsPromo(this.state.data.ids, this.state.data.isPromo);
        }));
    }

    events() {

        this.listPartners.posts.forEach(partner => {
            partner.addEventListener('click', event => {
                event.preventDefault();
                const {partnerId} = partner.dataset;

                this.googleMap.selectPoint(partnerId, this.state.markers);

                this.listPartners.setActive(partnerId);
            })
        });

        this.search.inputSearch.addEventListener('keyup', () => {
            this.listPartners.hideNotFound();
            this.listPartners.showPostsByTermsAndIsPromo(this.state.data.ids, this.state.data.isPromo);
            this.listPartners.showPostsByContainsTitle(this.search.inputSearch.value);

            if (!this.listPartners.state.isFindSomething) {
                this.listPartners.showNotFound();
            }
        })

        this.search.inputSearch.addEventListener('click', () => {
            this.merchant.hide();
            this.showList();
            this.googleMap.map.closePopup();
        })

        this.openCategoryNodes.forEach(node => node.addEventListener('click', (e) => {
            e.preventDefault();
            this.category.show();
            this.merchant.hide();
            this.hideList();
            this.search.hide();
        }));

        this.closeCategoryNodes.forEach(node => node.addEventListener('click', (e) => {
            e.preventDefault();
            this.category.hide();
            this.showList();
            this.search.show();
        }));

        this.openListNodes.forEach(node => node.addEventListener('click', (e) => {
            e.preventDefault();
            this.merchant.hide();
            this.showList();
            this.googleMap.map.closePopup();
            this.search.show();
        }))

        this.googleMap.map.on('click', () => {

            if (!this.isDesktopHeader) {
                this.hideList();
            }
        })
    }

    showPartners(response) {
        const {data} = response;
        this.state.markers = [];

        const markersClusterGroup = this.googleMap.markersClusterGroup.clearLayers();

        data.forEach(merchant => {
            const {branches, logo, imageUrl, title} = merchant;

            branches.forEach(branch => {
                const {id, location, address, websiteUrl, googleMapUrl, isDisableBranch} = branch;

                if (isDisableBranch) {
                    return;
                }

                const icon = L.icon({
                    iconUrl: merchant.promotion.isEnable && !branch.isDisablePromotion ? this.googleMap.styles().icon.promo : this.googleMap.styles().icon.standard,
                    iconSize: [24, 24],
                    iconAnchor: [21.5, 21.5],
                    popupAnchor: [0, -20],
                    shadowSize: [68, 95],
                    shadowAnchor: [22, 94]
                });
                const latLang = new L.LatLng(location.latitude, location.longitude);

                let marker = L.marker(
                    latLang,
                    {
                        title: title,
                        icon,
                        riseOnHover: true,
                        id: id
                    }
                );

                marker
                    .on('popupopen', (popup) => {
                        document.body.classList.add('popup-open');
                        this.merchant.setState({
                            address: `${address.street}, ${address.city}`,
                            title: title,
                            logo: logo,
                            imageUrl: imageUrl,
                            descriptionPromo: merchant.promotion.description[this.currentLanguage],
                            websiteUrl: websiteUrl[this.currentLanguage],
                            isPromotion: merchant.promotion.isEnable && !branch.isDisablePromotion,
                            category: merchant.category[this.currentLanguage],
                            googleMapUrl: googleMapUrl
                        })
                        this.clearActiveMarkers('leaflet-marker-icon');
                        this.googleMap.centerMarker(latLang);
                        this.hideList();
                        this.addMarkerActiveClass(marker);
                        merchant.promotion.isEnable && !branch.isDisablePromotion ? this.addMarkerPromoClass(marker) : '';

                        if (!this.isDesktopHeader) {
                            this.search.hide();
                        }
                    })
                    .on('popupclose', (popup) => {
                        document.body.classList.remove('popup-open');
                        this.merchant.hide();
                        this.showList();
                        this.search.show();
                        this.googleMap.markersClusterGroup.enableClustering();
                    })
                    .on('click', () => {
                        this.clearActiveMarkers('leaflet-marker-icon');
                        this.addMarkerActiveClass(marker);
                        merchant.promotion.isEnable && !branch.isDisablePromotion ? this.addMarkerPromoClass(marker) : '';
                    })

                this.state.markers.push(marker);

                marker.bindPopup('');
                markersClusterGroup.addLayer(marker);
            });
        });

        this.googleMap.map.addLayer(markersClusterGroup);

        if (this.state.onLoad) {
            this.state.onLoad = false;
        }
    }

    showList() {
        this.listWrapper.classList.add('map-points__list-wrapper--active');
    }

    hideList() {
        this.listWrapper.classList.remove('map-points__list-wrapper--active');
    }

    clearActiveMarkers(className) {
        const markers = this.node.querySelectorAll('.' + className);

        markers.forEach(marker => marker.classList.remove('marker-icon-active', 'marker-icon-active--promo'));
    }

    addMarkerActiveClass(marker) {
        marker._icon.classList.add('marker-icon-active');
    } 

    addMarkerPromoClass(marker) {
        marker._icon.classList.add('marker-icon-active--promo');
    }
}
