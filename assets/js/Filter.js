
/**
 * @property {HTMLElement} form
 * @property {HTMLElement} content
 */
export default class Filter {

    /**
     * 
     * @param {HTMLElement|null} element 
     * @returns 
     */
    constructor (element) {
        if (element === null) {
            return
        }
        this.form = element.querySelector('.js-filter-form')
        this.content = element.querySelector('.js-filter-content')
        this.bindEvents()
    }

    /**
     * Ajoute les comportements aux différents éléments
     */
    bindEvents () {
        
    }

    async loadUrl (url) {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        if (response.status >= 200 && response.status < 300) {
            const data = await response.json()
            this.content.innerHTML = data.content
            history.replaceState({}, '', url)
        } else {
            console.error(response)
        }
    }
}