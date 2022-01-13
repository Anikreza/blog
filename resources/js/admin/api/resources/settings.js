import HttpClient from '../index'

class SettingsApi extends HttpClient {
    getSettings() {
        return this.requestType('get').request(`/settings`)
    }

    updateSettings(payload) {
        return this.requestType('post').isMultimedia().formBody(payload).request(`/settings`)
    }

    getAdSpaces() {
        return this.requestType('get').request(`/ad-spaces`)
    }

    saveAdSpace(payload) {
        let url = this.requestType('post');

        if (payload.image !== null) {
            url = url.isMultimedia();
        }

        return url.formBody(payload).request(`ad-spaces`)
    }

    updateAdSpace(payload) {
        let url = this.requestType('post');

        if (payload.image !== null) {
            url = url.isMultimedia();
        }

        return url.formBody(payload).request(`ad-spaces/${payload.id}`)
    }

    deleteAdSpace(id) {
        return this.requestType('delete').request(`ad-spaces/${id}`)
    }
}

const Api = new SettingsApi()
export default Api
