import {AjaxProcessor} from "../ajax.js";

export default ({code, page}) => {

    return new Promise((resolve, reject) => {

        new AjaxProcessor(`/api/catalog/${code}/`, {
            page: page
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
