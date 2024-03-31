import {Flipper} from 'flip-toolkit'

/**
 * @property {HTMLFormElement} forms
 * @property {HTMLFormElement} modelsFilters
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
        this.modelsFilters = element.querySelector('.models-filters')
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
        this.modelsFilters.addEventListener('change', (event) => {
            const target = event.target;
            if (target.tagName === 'INPUT') {
                this.loadForm();
            }
        });
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
            this.flipContent(data.content)
            this.modelsFilters.innerHTML = data.modelsFilters
            history.replaceState({}, '', url)
        } else {
            console.error(response)
        }
    }

    /**
     * Remplace les éléments de la grille avec un effet d'animation flip
     * @param {string} content 
     */
    async flipContent(content) {
        const flipper = new Flipper({
            element: this.content
        });
    
        // Enregistrer l'état actuel avant la mise à jour
        flipper.recordBeforeUpdate();
    
        // Mettre à jour le contenu en ajoutant les nouveaux éléments
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = content;
        while (this.content.firstChild) {
            this.content.removeChild(this.content.firstChild);
        }
        while (tempDiv.firstChild) {
            this.content.appendChild(tempDiv.firstChild);
        }
    
        // Sélectionner les nouveaux éléments ajoutés
        const newElements = this.content.querySelectorAll('.col.mb-3');
    
        // Animer les nouveaux éléments avec Flipper
        newElements.forEach(element => {
            flipper.addFlipped({
                element,
                flipId: element.id
            });
        });
    
        // Mettre à jour Flipper pour appliquer les animations
        flipper.update();
    }
    
}