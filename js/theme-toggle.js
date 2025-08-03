// Theme Toggle System - Clean Version
class ThemeManager {
    constructor() {
        this.currentTheme = localStorage.getItem('theme') || 'dark';
        this.themeToggleBtn = document.getElementById('themeToggle');
        this.themeIcon = document.getElementById('themeIcon');
        this.themeText = document.getElementById('themeText');
        this.themeCssLink = document.getElementById('theme-css');
        
        this.init();
    }

    init() {
        // Set initial theme
        this.setTheme(this.currentTheme);
        
        // Add event listener
        if (this.themeToggleBtn) {
            this.themeToggleBtn.addEventListener('click', () => this.toggleTheme());
        }
    }

    setTheme(theme) {
        this.currentTheme = theme;
        
        // Update CSS file
        if (this.themeCssLink) {
            if (theme === 'light') {
                this.themeCssLink.href = 'css/style-light.css';
            } else {
                this.themeCssLink.href = 'css/style.css';
            }
        }
        
        // Update button content
        this.updateButton();
        
        // Save to localStorage
        localStorage.setItem('theme', theme);
        
        // Add body class for additional styling if needed
        document.body.className = `${theme}-theme`;
    }

    toggleTheme() {
        const newTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
        this.setTheme(newTheme);
    }

    updateButton() {
        if (this.themeIcon && this.themeText) {
            if (this.currentTheme === 'light') {
                this.themeIcon.textContent = '🌙';
                this.themeText.textContent = 'Dark Mode';
            } else {
                this.themeIcon.textContent = '☀️';
                this.themeText.textContent = 'Light Mode';
            }
        }
    }
}

// Initialize theme manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ThemeManager();
});

// Export for debugging
window.ThemeManager = ThemeManager;
