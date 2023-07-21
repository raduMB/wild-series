import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["body"];
    //darkMode = false;

    connect() {
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';

        this.darkMode = JSON.parse(localStorage.getItem('darkMode')) ?? false;
        this.updateTheme();
    }

    toggleDarkMode(event) {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode)
        this.updateTheme();
    }

    updateTheme() {
        this.bodyTarget.setAttribute('data-bs-theme', this.darkMode ? 'dark' : '');
    }
}
