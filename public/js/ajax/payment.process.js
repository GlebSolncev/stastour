import {AjaxProcessor} from "../ajax.js";

export default (orderId) => {

    return new Promise((resolve, reject) => {

        new AjaxProcessor(`/api/payment/stripe/`, {order_id: orderId}, 'POST')
            .json()
            .then((response) => {
                resolve(response)
            })
            .catch((error) => {
                reject(error);
            })
    })

};
