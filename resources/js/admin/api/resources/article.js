import HttpClient from '../index'

class CategoryApi extends HttpClient {
    list(page = 1, query) {
        return this.requestType('get').request(`/articles?page=${page}&${query}`)
    }

    get(slug) {
        return this.requestType('get').request(`/articles/${slug}/edit`)
    }

    save(payload) {
        let url = this.requestType('post');

        if (payload.image !== null) {
            url = url.isMultimedia();
        }

        return url.formBody(payload).request(`articles`)
    }

    update(payload) {
        let url = this.requestType('post');

        if (payload.image !== null) {
            url = url.isMultimedia();
        }
        return url.formBody(payload).request(`articles/${payload.id}`)
    }

    delete(id) {
        return this.requestType('delete').request(`articles/${id}`)
    }
}

const Api = new CategoryApi()
export default Api
