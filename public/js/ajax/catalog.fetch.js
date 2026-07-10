import {AjaxProcessor} from "../ajax.js";

export default (filters) => {

    return new Promise((resolve, reject) => {

        new AjaxProcessor(`/api/catalog/fetch/`, {
            filters: filters
        }, 'POST')
            .html()
            .then((response) => {
                resolve(response)
            })
            .catch((error) => {
                reject(error);
            })
    })

};
