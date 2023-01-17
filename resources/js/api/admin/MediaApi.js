import httpClient from "../httpClient";

export class MediaApi {
    static postMedia(data) {
        return httpClient.post('download-media', data);
    }
}
