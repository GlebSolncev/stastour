export class String {
    static random(length = 10, prefix = '', chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
        let result = '';
        const charactersLength = chars.length;
        let counter = 0;
        while (counter < length) {
            result += chars.charAt(Math.floor(Math.random() * charactersLength));
            counter += 1;
        }
        return prefix + result;
    }
}
