import {AjaxProcessor} from "../ajax.js";

export default (data) => {

    return new Promise((resolve, reject) => {

        new AjaxProcessor(`/api/basket/add/tour/`, data, 'POST')
            .json()
            .then((response) => {
                resolve(response)
            })
            .catch((error) => {
                reject(error);
            })
    })

};
