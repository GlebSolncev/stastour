import {AjaxProcessor} from "../ajax.js";

export default ({code}) => {

    return new Promise((resolve, reject) => {

        new AjaxProcessor(`/api/language/${code}/`, {}, 'POST')
            .json()
            .then((response) => {
                location.reload();
            })
            .catch((error) => {
                reject(error);
            })
    })

};
