import httpClient from "../httpClient";

export class QuestionApi {
    static like(data) {
        return httpClient.post('question-like', data);
    }

    static getList() {
        return httpClient.get('/questions');
    }
}
