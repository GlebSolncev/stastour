import {AjaxProcessor} from "../ajax.js";

export default ({code, data}) => {

    return new Promise((resolve, reject) => {

        new AjaxProcessor(`/api/modal/create/${code}/`, data, 'POST')
            .html()
            .then((response) => {
                resolve(response);
            })
            .catch((error) => {
                reject(error);
            })
    })

};
