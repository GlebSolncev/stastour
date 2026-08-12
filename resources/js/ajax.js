export class AjaxProcessor {
    constructor(url, data, method) {
        this.url = url;
        this.data = data;
        this.method = method;
    }

    buildFormData(formData, data, parentKey) {
        if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File) && !(data instanceof Blob)) {
            Object.keys(data).forEach(key => {
                this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
            });
        } else {
            const value = data == null ? '' : data;

            formData.append(parentKey, value);
        }
    }

    jsonToFormData(data) {

        const formData = new FormData();
        this.buildFormData(formData, data);
        return formData;
    }

    getFormData() {
        let formData = this.data;

        console.log(this.data, this.data instanceof FormData);

        if (!(this.data instanceof FormData)) {
            formData = this.jsonToFormData(this.data);

        }

        formData.append('_token', window.csrf_token);
        return formData;
    }

    request() {

        const formData = this.getFormData();

        let url = this.url;
        const data = {
            method: this.method,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        if (['GET', 'HEAD'].includes(this.method)) {
            const query = new URLSearchParams(formData).toString();
            if (query) {
                url += '?' + query;
            }
        } else {
            data.body = formData;
        }

        return fetch(url, data)
    }

    json() {
        return new Promise((resolve, reject) => {
            this.request()
                .then(async (response) => {
                    const body = await response.text();
                    let answer;
                    try {
                        answer = JSON.parse(body);
                    } catch (error) {
                        throw new Error(`Server returned ${response.status} instead of JSON`);
                    }

                    if (!response.ok) {
                        throw new Error(answer.message || `Request failed with status ${response.status}`);
                    }

                    resolve(answer);
                })
                .catch(reject)
        })
    }

    html() {
        return new Promise((resolve, reject) => {
            this.request()
                .then((response) => {
                    return response.text()
                        .then((answer) => {
                            resolve(answer);
                        })
                })
                .catch(reject)
        })
    }

}

export const route = (endpoint_url, endpoint_attributes) => {
    return new Promise((resolve, reject) => {

        import('./ajax/' + endpoint_url + '.js')
            .then((route) => {
                console.log("[route]", route)
                route.default(endpoint_attributes).then(resolve).catch(reject);
            })
            .catch(reject);

    })
}

export const extract = (element) => {

    const route_element = element.closest('[js-api]');
    const js_api_data = element.getAttribute('js-api-data');

    if (js_api_data && route_element) {
        const api_data = JSON.parse(js_api_data);
        const route_url = route_element.getAttribute('js-api');

        return route(route_url, api_data);
    }

    return Promise.reject();
}
