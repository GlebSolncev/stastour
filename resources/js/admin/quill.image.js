let ImageActions = null;
let ImageFormats = null;

const libsLoaded = new Promise((resolve, reject) => {

    let loaders = [];
    loaders.push(import('https://cdn.jsdelivr.net/npm/@xeger/quill-image-actions/lib/index.mjs').then((module) => {
        ImageActions = module.ImageActions;
    }))

    loaders.push(import('https://cdn.jsdelivr.net/npm/@xeger/quill-image-formats/lib/index.mjs').then((module) => {
        ImageFormats = module.ImageFormats;
    }))

    Promise.all(loaders).then(resolve);
})

document.addEventListener('orchid:quill', (event) => {

    libsLoaded.then(() => {
        event.detail.quill.register("modules/imageActions", ImageActions);
        event.detail.quill.register("modules/imageFormats", ImageFormats);

        event.detail.options.modules = {
            imageActions: {},
            imageFormats: {},
        };
    })

});
