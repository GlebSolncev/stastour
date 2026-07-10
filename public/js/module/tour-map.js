class TourMap {
    constructor(element) {
        this.element = element;
        this.start();
    }

    async start() {
        await window.await.wait('google_map');
        const src = this.element.dataset.kml;

        this.map = new google.maps.Map(this.element, {
            center: { lat: -34.397, lng: 150.644 },
            zoom: 8,
        });

        let kmlLayer = new google.maps.KmlLayer(src, {
            suppressInfoWindows: true,
            preserveViewport: false,
            map: this.map
        });
        kmlLayer.addListener('click', function(event) {
            let content = event.featureData.infoWindowHtml;
            let testimonial = document.getElementById('capture');
            testimonial.innerHTML = content;
        });

        console.log("[Tourmap - ready]")
    }
}

export function register(element) {
    return new TourMap(element);
}
