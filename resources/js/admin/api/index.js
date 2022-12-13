import axios from 'axios';

class HttpClient {
    constructor() {
        this.validRequestTypes = ['get', 'post', 'patch', 'put', 'delete']
        this.multimedia = false

        this.client = axios.create({
            withCredentials: true,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })

        if (localStorage.getItem('token')) {
            this.attachToken(localStorage.getItem('token'))
        }

        // Handling automatic logout
        this.client.interceptors.response.use(response => response, (error) => {
            if (
                401 === error.response.status &&
                (error.response.data.message !== undefined &&
                    (
                        error.response.data.message === 'invalid_credentials' ||
                        error.response.data.message === 'Unauthenticated.'
                    )
                )
            ) {
                localStorage.clear()
                window.location.href = '/'
            } else if (422 === error.response.status) {
                let errors = [];

                for (let [key, value] of Object.entries(error.response.data.errors)) {
                    errors = [...errors, ...value]
                }

                error.response.errors = errors;
            }

            return error.response
        })
    }

    static resetConstructor() {
        return new HttpClient()
    }

    attachToken(token) {
        this.client.interceptors.request.use((config) => {
            config.headers.common['Authorization'] = JSON.parse(token)
            config.headers.common['Accept-Language'] = localStorage.getItem('locale') || 'de'

            return config
        });
    }

    requestType(type) {
        if (this.validRequestTypes.includes(type)) {
            this.requestMethod = type

            return this
        } else {
            throw new Error(`Your request type ${type} is not valid. Valid requests are: ${(this.validRequestTypes).toString()}`)
        }
    }

    formBody(data) {
        this.formData = data
        return this
    }

    isMultimedia() {
        this.multimedia = true
        this.client.defaults.headers['Content-Type'] = 'multipart/form-data' // for image upload

        return this
    }

    request(url, isApiRequest = true) {
        const requestShouldCarryFormData = this.validRequestTypes.map(type => type !== 'get' || type !== 'delete')

        // Attaching api slug with base url
        if (isApiRequest) {
            this.client.defaults.baseURL = process.env.MIX_APP_URL + '/api/v1'
        } else {
            this.client.defaults.baseURL = process.env.MIX_APP_URL
        }

        // validating request type
        if (this.requestMethod === undefined) {
            throw new Error('Request Method Type is not found. Please use requestType(param) method')
        }

        let requestConfig = {
            method: this.requestMethod,
            url: url,
        }
        let formData = null

        // validating request
        if (requestShouldCarryFormData.includes(this.requestMethod) && this.formData !== undefined) {
            throw new Error('Form Data not found. Please use formBody() method to set form data.')
        } else {
            // setting form body
            if (this.multimedia) {
                formData = new FormData()

                for (const [key, value] of Object.entries(this.formData)) {
                    formData.append(key, value)
                }
            } else {
                formData = this.formData
            }

            requestConfig.data = formData
        }

        // check authorization token is available & authorization token is missing in header
        if (localStorage.getItem('token') && this.client.headers === undefined) {
            this.attachToken(localStorage.getItem('token'))
        }

        // sending request
        return new Promise((resolve, reject) => {
            this.client(requestConfig)
                .then(response => {
                    if (response.status >= 200 && response.status <= 203) {
                        resolve(response)
                    } else {
                        reject(response)
                    }
                })
                .catch(error => reject(error))
        })
    }
}

export default HttpClient
