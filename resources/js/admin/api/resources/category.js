import HttpClient from '../index'

class CategoryApi extends HttpClient {
    getCategories(page = 1) {
        return this.requestType('get').request(`/categories?page=${page}`)
    }

    getCategoryDetails(id) {
        return this.requestType('get').request(`/categories/${id}`)
    }

    saveCategory(payload) {
        return this.requestType('post').formBody(payload).request(`categories`)
    }

    updateCategory(payload, id) {
        return this.requestType('patch').formBody(payload).request(`categories/${id}`)
    }

    deleteCategory(id) {
        return this.requestType('delete').request(`categories/${id}`)
    }

    updatePriority(payload) {
        return this.requestType('post').formBody(payload).request(`/categories/priority-update`)
    }
}

const categoryApi = new CategoryApi()
export default categoryApi
