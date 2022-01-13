import HttpClient from '../index'

class PageApi extends HttpClient {
    list(page = 1, query) {
        return this.requestType('get').request(`/pages?page=${page}&${query}`)
    }

    getAllPages() {
        return this.requestType('get').request(`/fetch-all-published-pages`)
    }

    get(slug) {
        return this.requestType('get').request(`/pages/${slug}/edit`)
    }

    save(payload) {
        return this.requestType('post').formBody(payload).request(`pages`)
    }

    update(payload) {
        return this.requestType('post').formBody(payload).request(`pages/${payload.id}`)
    }

    delete(id) {
        return this.requestType('delete').request(`pages/${id}`)
    }


    savePageIds(payload) {
        return this.requestType('post').formBody(payload).request(`save-page-ids`)
    }
}

const pageApi = new PageApi()
export default pageApi
