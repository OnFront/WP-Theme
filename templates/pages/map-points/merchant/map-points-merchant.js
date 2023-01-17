export class MapPointsMerchant {
    constructor(node) {
        this.node = node;
        this.childNode = {
            image: node.querySelector('[data-js-image]'),
            address: node.querySelector('[data-js-address]'),
            title: node.querySelector('[data-js-title]'),
            descriptionPromo: node.querySelector('[data-js-description-promo]'),
            websiteUrl: node.querySelector('[data-js-website-url]'),
            logoUrl: node.querySelector('[data-js-logo-url]'),
            category: node.querySelector('[data-js-category]'),
            promotion: node.querySelector('[data-js-promotion]'),
            googleMapUrl: node.querySelector('[data-js-navigate-url]'),
        }

        this.state = {
            address: '',
            title: '',
            logo: '',
            descriptionPromo: '',
            websiteUrl: '',
            isPromotion: false,
            category: '',
            googleMapUrl: '',
            imageUrl: '',
        }
    }

    setState(state) {
        this.state = state;
        this.render();
        this.show();
    }

    render() {
        this.childNode.image.src = this.state.imageUrl;
        this.childNode.address.innerText = this.state.address;
        this.childNode.title.innerText = this.state.title;
        this.childNode.descriptionPromo.innerText = this.state.descriptionPromo;
        this.childNode.websiteUrl.href = this.state.websiteUrl;
        this.childNode.logoUrl.src = this.state.logo;
        this.childNode.category.innerText = this.state.category;
        this.childNode.googleMapUrl.href = this.state.googleMapUrl;

        this.childNode.promotion.style.display = this.state.isPromotion ? 'block' : 'none';
    }

    show() {
        this.node.classList.add('map-points-merchant--active');
    }

    hide() {
        this.node.classList.remove('map-points-merchant--active');
    }
}
