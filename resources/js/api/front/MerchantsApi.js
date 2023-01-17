import httpClient from "../httpClient";

export class MerchantsApi {
    static getMerchants() {
        return httpClient.get('merchants');
    }

    static getMerchant(id) {
        return httpClient.get(`merchants/${id}`);
    }

    static getMerchantsByTermIdsAndByIsPromo(data) {
        const {ids, isPromo} = data;

        const query = {};

        if (isPromo) {
            query.promo = isPromo;
        }

        if (ids.length) {
            query.terms = ids.join();
        }

        const searchParams = new URLSearchParams(query);

        return httpClient.get(`merchants?${searchParams.toString()}`);
    }
}
