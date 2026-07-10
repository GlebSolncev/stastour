export class Parallax {
    constructor (element) {

        const config = {
            orientation: element.dataset['orientation'] || 'up',
            scale: element.dataset['scale'] || 1.2,
            overflow: element.dataset['overflow'] || false,
            delay: element.dataset['delay'] || 0.4,
            transition: element.dataset['transition'] || 'cubic-bezier(0,0,0,1)',
            customContainer: element.dataset['customContainer'] || '',
            customWrapper: element.dataset['customWrapper'] || '',
            maxTransition: element.dataset['maxTransition'] || 0,
        }

        this.parallax = new simpleParallax(element, config);
    }
}

export function register (element) {
    if (window.simpleParallax) {
        return new Parallax(element);
    } else {
        console.warn('No simpleParallax vendor js library! ignored')
    }
}

export const PATH = 'parallax';
