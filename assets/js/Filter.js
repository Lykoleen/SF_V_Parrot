
/**
 * @property {HTMLFormElement} forms
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
        this.forms = element.querySelectorAll('.js-filter-form')
        this.content = element.querySelector('.js-filter-content')
        this.bindEvents()
    }

    /**
     * Ajoute les comportements aux différents éléments
     */
    bindEvents () {
        this.forms.forEach(form => {
            form.querySelectorAll('input').forEach(input => {
                input.addEventListener('change', this.loadForm.bind(this))
            })
        })
    }
    
    async loadForm () {
        // Créer un FormData pour chaque formulaire
        const formDataArray = Array.from(this.forms).map(form => new FormData(form));
    
        // Concaténer les données de tous les formulaires
        const data = formDataArray.reduce((acc, formData) => {
            for (const [key, value] of formData.entries()) {
                acc.append(key, value);
            }
            return acc;
        }, new FormData());
    
        // Utiliser le premier formulaire pour récupérer l'URL
        const url = new URL(this.forms[0].getAttribute('action') || window.location.href);
    
        // Créer les paramètres URL
        const params = new URLSearchParams();
        data.forEach((value, key) => {
            params.append(key, value);
        });
        return this.loadUrl(url.pathname + '?' + params.toString())
    }
    

    async loadUrl (url) {
        const ajaxUrl = url + '&ajax=1'
        const response = await fetch(ajaxUrl, {
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