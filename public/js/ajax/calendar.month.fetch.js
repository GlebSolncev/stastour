import {AjaxProcessor} from "../ajax.js";

export default ({tour, month}) => {

    return new Promise((resolve, reject) => {

        new AjaxProcessor(`/api/calendar/${tour}/${month}/`, {}, 'GET')
            .json()
            .then((response) => {
                resolve(response)
            })
            .catch((error) => {
                reject(error);
            })
    })

};
