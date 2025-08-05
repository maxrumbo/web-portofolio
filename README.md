---
# Web Porto maxrumbo

A professional portfolio website built with modern web technologies including HTML5, CSS3, and vanilla JavaScript.

## 🚀 Live Demo
[View Portfolio](https://maxrumbo.github.io/web-portofolio)

## 📋 Overview :

- **3D Hero Section** - Interactive 3D profile card with smooth animations
- **Code Editor Simulation** - Syntax-highlighted about section with typing effects
- **Animated Skills Display** - Progress bars with smooth reveal animations
- **Project Showcase** - Clean grid layout for featured projects
- **Interactive Timeline** - Career journey with hover effects
- **Certificate Gallery** - Professional certifications display
- **Contact Integration** - Functional contact form with validation

## ✨ Key Features

### 🎨 Dual Theme System
- **Dark Mode** - Modern dark theme with vibrant accents
- **Light Mode** - Clean, professional light theme
- **Theme Toggle** - Instant switching with smooth transitions

### 📱 Responsive Architecture
- Mobile-first responsive design
- Optimized for all screen sizes
- Touch-friendly interactions
- Cross-browser compatibility

### 🎭 Advanced Animations
- Scroll-triggered reveal animations
- 3D transform effects
- Floating geometric elements
- Interactive hover states
- Smooth page transitions

### 🔧 Technology Stack
- **HTML5** - Semantic markup structure
- **CSS3** - Modern styling with Flexbox/Grid
- **JavaScript ES6+** - Interactive functionality
- **Font Awesome** - Icon library
- **Custom Fonts** - Typography optimization

## 📁 Project Structure

```
web-portofolio/
├── index.html              # Main HTML file
├── README.md               # Project documentation
├── assets/
│   ├── cv/
│   │   └── Maxwell_Rumahorbo_CV.pdf
│   └── images/
│       ├── profile 1.jpg
│       └── profile 2.jpg
├── css/
│   ├── style.css          # Main stylesheet (dark theme)
│   └── style-light.css    # Light theme stylesheet
├── js/
│   ├── script.js          # Core JavaScript functionality
│   └── theme-toggle.js    # Theme switching logic
└── docs/
    └── README.md          # Additional documentation
```

## 🎯 Installation & Setup

### Clone Repository
```bash
git clone https://github.com/maxrumbo/web-portofolio.git
cd web-portofolio
```

### Local Development
This is a static website, so you can simply:

**Option 1: Direct Browser Access**
```bash
# Open index.html directly in your browser
open index.html  # macOS
start index.html # Windows
xdg-open index.html # Linux
```

**Option 2: Live Server (Recommended for development)**
If you're using VS Code, install the "Live Server" extension and right-click on `index.html` → "Open with Live Server"

**Option 3: Local Server (Optional)**
If you prefer using a local server:
```bash
# Using Python (if you have Python installed)
python -m http.server 8000

# Using Node.js (if you have Node.js installed)
npx http-server

# Then open http://localhost:8000 in your browser
```

## 🎨 Customization Guide

### Theme Configuration
Modify CSS variables in `style.css` or `style-light.css`:

```css
:root {
    --primary-color: #your-color;
    --secondary-color: #your-color;
    --accent-color: #your-color;
}
```

### Adding New Sections
1. Create HTML structure in `index.html`
2. Add corresponding styles in CSS files
3. Implement JavaScript functionality if needed

### Content Updates
- **Profile Information**: Update hero section in `index.html`
- **Skills**: Modify skills grid with your expertise
- **Projects**: Add new projects to the showcase section
- **Experience**: Update timeline with your career history

## 📊 Performance Metrics

- ⚡ Optimized loading performance
- 🔍 SEO-friendly structure
- ♿ WCAG accessibility compliance
- 📱 Cross-device compatibility
- 🎨 Hardware-accelerated animations

## 🤝 Contributing

Contributions are welcome! To contribute to this project:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/NewFeature`)
3. Commit your changes (`git commit -m 'Add NewFeature'`)
4. Push to the branch (`git push origin feature/NewFeature`)
5. Open a Pull Request

## 📝 Version History

### v2.0.0 (August 2025)
- ✨ Implemented 3D hero section with interactive profile card
- 🎨 Added comprehensive dual theme system
- 📱 Enhanced mobile responsiveness and touch interactions
- 🎭 Integrated advanced CSS animations and transitions
- 🔧 Restructured codebase for better maintainability

### v1.0.0 (July 2025)
- 🎉 Initial portfolio release
- 📄 Core portfolio structure implementation
- 🎨 Dark theme design system
- 📱 Basic responsive design

## 📜 License

This project is licensed under the MIT License - see the LICENSE file for details.

---


