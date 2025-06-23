/**
 * Validation JavaScript côté client
 */
class FormValidator {
    constructor(formSelector, options = {}) {
        this.form = document.querySelector(formSelector);
        this.options = {
            showErrors: true,
            realTime: true,
            ...options
        };
        
        if (this.form) {
            this.init();
        }
    }

    init() {
        this.setupEventListeners();
        this.setupRealTimeValidation();
    }

    setupEventListeners() {
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
            }
        });
    }

    setupRealTimeValidation() {
        if (!this.options.realTime) return;

        const inputs = this.form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });
    }

    validateForm() {
        let isValid = true;
        const inputs = this.form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        const rules = this.getFieldRules(field);
        let isValid = true;
        let errorMessage = '';

        // Validation requise
        if (rules.required && !value) {
            isValid = false;
            errorMessage = 'Ce champ est obligatoire.';
        }

        // Validation email
        if (rules.email && value && !this.isValidEmail(value)) {
            isValid = false;
            errorMessage = 'Veuillez entrer une adresse email valide.';
        }

        // Validation longueur minimale
        if (rules.minLength && value.length < rules.minLength) {
            isValid = false;
            errorMessage = `Ce champ doit contenir au moins ${rules.minLength} caractères.`;
        }

        // Validation longueur maximale
        if (rules.maxLength && value.length > rules.maxLength) {
            isValid = false;
            errorMessage = `Ce champ ne peut pas dépasser ${rules.maxLength} caractères.`;
        }

        // Validation téléphone
        if (rules.phone && value && !this.isValidPhone(value)) {
            isValid = false;
            errorMessage = 'Veuillez entrer un numéro de téléphone valide.';
        }

        // Validation URL
        if (rules.url && value && !this.isValidUrl(value)) {
            isValid = false;
            errorMessage = 'Veuillez entrer une URL valide.';
        }

        // Validation personnalisée
        if (rules.custom && typeof rules.custom === 'function') {
            const customResult = rules.custom(value, field);
            if (customResult !== true) {
                isValid = false;
                errorMessage = customResult || 'Validation échouée.';
            }
        }

        if (isValid) {
            this.clearFieldError(field);
        } else {
            this.showFieldError(field, errorMessage);
        }

        return isValid;
    }

    getFieldRules(field) {
        const rules = {};
        
        // Règles basées sur les attributs HTML
        if (field.hasAttribute('required')) rules.required = true;
        if (field.type === 'email') rules.email = true;
        if (field.type === 'tel') rules.phone = true;
        if (field.type === 'url') rules.url = true;
        
        // Règles basées sur les attributs data
        if (field.dataset.minLength) rules.minLength = parseInt(field.dataset.minLength);
        if (field.dataset.maxLength) rules.maxLength = parseInt(field.dataset.maxLength);
        
        // Règles basées sur les classes CSS
        if (field.classList.contains('js-validate-email')) rules.email = true;
        if (field.classList.contains('js-validate-phone')) rules.phone = true;
        if (field.classList.contains('js-validate-url')) rules.url = true;

        return rules;
    }

    showFieldError(field, message) {
        if (!this.options.showErrors) return;

        this.clearFieldError(field);
        
        field.classList.add('is-invalid');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        errorDiv.id = `${field.id || field.name}-error`;
        
        field.parentNode.appendChild(errorDiv);
    }

    clearFieldError(field) {
        field.classList.remove('is-invalid');
        
        const errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    isValidPhone(phone) {
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]{8,}$/;
        return phoneRegex.test(phone);
    }

    isValidUrl(url) {
        try {
            new URL(url);
            return true;
        } catch {
            return false;
        }
    }

    // Méthodes utilitaires
    static validateEmail(email) {
        const validator = new FormValidator('body');
        return validator.isValidEmail(email);
    }

    static validatePhone(phone) {
        const validator = new FormValidator('body');
        return validator.isValidPhone(phone);
    }
}

// Initialisation automatique pour les formulaires avec la classe js-validate
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form.js-validate');
    forms.forEach(form => {
        new FormValidator(`#${form.id}`);
    });
});

// Export pour utilisation dans d'autres modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = FormValidator;
} 