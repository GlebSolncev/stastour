import {AjaxProcessor} from "../ajax.js";

export default ({page}) => {

    return new Promise((resolve, reject) => {

        new AjaxProcessor(`/api/blog/`, {
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
