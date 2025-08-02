# Portfolio Website

Sebuah website portofolio modern dan responsif yang dibangun menggunakan HTML5, CSS3, dan JavaScript vanilla.

## Fitur

- **Desain Responsif**: Bekerja dengan baik di semua perangkat (desktop, tablet, mobile)
- **Navigasi Smooth**: Smooth scrolling antar section
- **Animasi Interaktif**: Progress bars untuk skills, hover effects, dan animasi reveal
- **Form Kontak**: Form kontak dengan validasi
- **Mobile Menu**: Hamburger menu untuk mobile devices
- **Modern UI**: Gradient backgrounds, glassmorphism effects
- **Performance Optimized**: Lazy loading dan debounced scroll events

## Struktur File

```
web-portofolio/
├── index.html          # Struktur HTML utama
├── style.css           # Styling dan responsive design
├── script.js           # Interaktivitas dan animasi
└── README.md           # Dokumentasi
```

## Sections

1. **Header/Navigation**: Fixed navbar dengan smooth scrolling
2. **Hero Section**: Introduction dengan animated elements
3. **About**: Informasi tentang diri dengan statistics
4. **Skills**: Progress bars untuk kemampuan teknis
5. **Projects**: Showcase proyek-proyek
6. **Contact**: Form kontak dan informasi kontak
7. **Footer**: Copyright information

## Teknologi yang Digunakan

- **HTML5**: Semantic markup
- **CSS3**: Flexbox, Grid, Animations, Responsive Design
- **JavaScript (ES6+)**: DOM manipulation, Event handling, Animations
- **Font Awesome**: Icons
- **Google Fonts**: Typography (jika diperlukan)

## Cara Menggunakan

1. Clone atau download repository ini
2. Buka file `index.html` di browser
3. Customize konten sesuai dengan informasi pribadi Anda:
   - Ganti nama di section hero
   - Update informasi about
   - Modifikasi skills sesuai kemampuan
   - Tambahkan proyek-proyek nyata
   - Update informasi kontak

## Customization

### Mengubah Warna Theme
Edit variabel di file `style.css`:
```css
/* Primary colors */
--primary-color: #3498db;
--secondary-color: #9b59b6;
--accent-color: #f39c12;
```

### Menambah/Mengurangi Skills
Edit section skills di `index.html` dan sesuaikan persentase di `data-width` attribute.

### Menambah Proyek
Duplikasi struktur `.project-card` di section projects dan sesuaikan konten.

## Browser Support

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Internet Explorer 11+

## Tips Optimasi

1. **Images**: Gunakan format WebP untuk gambar yang lebih ringan
2. **Icons**: Pertimbangkan menggunakan SVG untuk icons custom
3. **Fonts**: Gunakan font-display: swap untuk loading yang lebih cepat
4. **Performance**: Minify CSS dan JS untuk production

## Deployment

Website ini dapat di-deploy ke:
- **GitHub Pages**: Gratis dan mudah
- **Netlify**: Continuous deployment dari Git
- **Vercel**: Optimized untuk frontend frameworks
- **Firebase Hosting**: Google Cloud solution

### Deploy ke GitHub Pages
1. Push code ke GitHub repository
2. Go to Settings > Pages
3. Select source branch (main/master)
4. Your site akan tersedia di `https://username.github.io/repository-name`

## Kontribusi

Jika Anda menemukan bug atau ingin menambahkan fitur:
1. Fork repository
2. Buat feature branch
3. Commit changes
4. Push ke branch
5. Create Pull Request

## License

MIT License - Anda bebas menggunakan code ini untuk proyek pribadi maupun komersial.

## Author

Created with ❤️ by [Your Name]

---

**Selamat mencoba dan semoga website portofolio Anda menarik perhatian recruiter!** 🚀