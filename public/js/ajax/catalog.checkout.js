import {AjaxProcessor} from "../ajax.js";

export default (id) => {

    return new Promise((resolve, reject) => {

        new AjaxProcessor(`/api/catalog/checkout/${id}/`, {}, 'GET')
            .json()
            .then((response) => {
                resolve(response)
            })
            .catch((error) => {
                reject(error);
            })
    })

};
