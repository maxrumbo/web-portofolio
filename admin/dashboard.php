
<?php
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Edit Portfolio</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #7dcfff;
            --accent: #9ece6a;
            --danger: #ff5c57;
            --bg: #232946;
            --card: #16161aee;
            --radius: 16px;
        }
        body {
            background: var(--bg);
            color: #fff;
            font-family: 'Fira Code', 'Arial', monospace;
            margin: 0;
        }
        .admin-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--card);
            padding: 24px 40px 18px 40px;
            border-bottom: 2px solid var(--primary);
            box-shadow: 0 4px 24px #0003;
        }
        .admin-header .admin-info {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .admin-header .avatar {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            border: 2.5px solid var(--primary);
            object-fit: cover;
            background: #232946;
        }
        .admin-header .admin-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }
        .admin-header .logout-btn {
            background: var(--danger);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .admin-header .logout-btn:hover {
            background: #ff7c7c;
        }
        .dashboard-title {
            text-align: center;
            margin: 32px 0 18px 0;
            font-size: 2.1rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--primary);
        }
        .container {
            max-width: 1100px;
            margin: 0 auto 40px auto;
            padding: 0 16px;
        }
        .admin-section {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: 0 2px 16px #0002;
            margin-bottom: 36px;
            padding: 28px 28px 18px 28px;
            border: 1.5px solid var(--primary);
            position: relative;
        }
        .admin-section h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 8px;
        }
        .admin-section h2 i {
            color: var(--primary);
        }
        .edit-btn, .save-btn, .cancel-btn {
            border: none;
            border-radius: 8px;
            padding: 7px 18px;
            font-size: 1rem;
            font-weight: 600;
            margin-left: 10px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }
        .edit-btn { background: var(--primary); color: #232946; }
        .edit-btn:hover { background: #a9b1d6; color: #232946; }
        .save-btn { background: var(--accent); color: #232946; }
        .save-btn:hover { background: #baffb8; color: #232946; }
        .cancel-btn { background: var(--danger); color: #fff; }
        .cancel-btn:hover { background: #ff7c7c; color: #fff; }
        .file-input { margin-top: 8px; }
        .edit-form label {
            color: #a9b1d6;
            font-weight: 500;
            margin-top: 10px;
            display: block;
        }
        .edit-form input, .edit-form textarea {
            width: 100%;
            padding: 11px 12px;
            margin-bottom: 10px;
            border-radius: 7px;
            border: 1.5px solid var(--primary);
            background: #232946;
            color: #fff;
            font-size: 1rem;
            font-family: inherit;
            transition: border 0.2s;
        }
        .edit-form input:focus, .edit-form textarea:focus {
            outline: none;
            border: 1.5px solid var(--accent);
        }
        @media (max-width: 700px) {
            .admin-header { flex-direction: column; gap: 12px; padding: 18px 10px; }
            .dashboard-title { font-size: 1.3rem; }
            .container { padding: 0 2vw; }
            .admin-section { padding: 16px 6vw 10px 6vw; }
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <div class="admin-info">
            <img src="../assets/images/profile 2.jpg" alt="Admin" class="avatar">
            <span class="admin-name">Maxwell Rumahorbo</span>
        </div>
        <div style="display:flex;gap:10px;align-items:center;">
            <button class="logout-btn" type="button" onclick="showPreview()" style="background:var(--primary);color:#232946;"><i class="fas fa-eye"></i> Preview</button>
            <form method="post" action="logout.php" style="margin:0;display:inline;">
                <button class="logout-btn" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>
    <div class="dashboard-title"><i class="fas fa-cogs"></i> Admin Dashboard - Edit Portfolio</div>
    <div class="container">
        <!-- Hero Section (Front & Back) -->
        <div class="admin-section" id="admin-hero">
            <h2><i class="fas fa-id-card"></i> Hero/Profile</h2>
            <form id="hero-form" class="edit-form" enctype="multipart/form-data" method="post" action="save-portfolio.php">
                <input type="hidden" name="section" value="hero">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
                    <div>
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" value="Maxwell Rumahorbo">
                        <label>Role/Profesi</label>
                        <input type="text" name="role" value="Information Systems Student">
                        <label>Department</label>
                        <input type="text" name="department" value="Information Technology">
                        <label>ID</label>
                        <input type="text" name="employee_id" value="2024.DEV.001">
                        <label>Foto Profil (jpg/png)</label>
                        <input type="file" name="profile_image" class="file-input" accept="image/*">
                    </div>
                    <div>
                        <label>Tahun Berlaku (Depan)</label>
                        <input type="text" name="valid_thru" value="12/2027">
                        <label>Tahun Berlaku (Belakang)</label>
                        <input type="text" name="valid_back" value="31 DES 2027">
                        <label>Statistik (Belakang)</label>
                        <input type="text" name="stat1" value="2024|Graduate">
                        <input type="text" name="stat2" value="10+|Projects">
                        <input type="text" name="stat3" value="IT Del|University">
                    </div>
                </div>
                <button class="save-btn" type="submit"><i class="fas fa-save"></i>Simpan</button>
            </form>
        </div>
        <!-- About Section -->
        <div class="admin-section" id="admin-about">
            <h2>About <button class="edit-btn" onclick="editSection('about')"><i class="fas fa-edit"></i>Edit</button></h2>
            <div id="about-content">
                Passionate Information Systems student at Institut Teknologi Del with a strong foundation in web development and software engineering. I enjoy creating innovative solutions and learning new technologies to build the future, one line of code at a time.
            </div>
            <form id="about-form" class="edit-form" style="display:none;" method="post" action="save-portfolio.php">
                <input type="hidden" name="section" value="about">
                <label>Deskripsi About</label>
                <textarea name="about" rows="4">Passionate Information Systems student at Institut Teknologi Del with a strong foundation in web development and software engineering. I enjoy creating innovative solutions and learning new technologies to build the future, one line of code at a time.</textarea>
                <button class="save-btn" type="submit"><i class="fas fa-save"></i>Simpan</button>
                <button class="cancel-btn" type="button" onclick="cancelEdit('about')">Batal</button>
            </form>
        </div>
        <!-- Skills Section -->
        <div class="admin-section" id="admin-skills">
            <h2>Skills <button class="edit-btn" onclick="editSection('skills')"><i class="fas fa-edit"></i>Edit</button></h2>
            <div id="skills-content">
                HTML5, CSS3, JavaScript, React, Bootstrap, Git
            </div>
            <form id="skills-form" class="edit-form" style="display:none;" method="post" action="save-portfolio.php">
                <input type="hidden" name="section" value="skills">
                <label>Daftar Skills (pisahkan dengan koma)</label>
                <input type="text" name="skills" value="HTML5, CSS3, JavaScript, React, Bootstrap, Git">
                <button class="save-btn" type="submit"><i class="fas fa-save"></i>Simpan</button>
                <button class="cancel-btn" type="button" onclick="cancelEdit('skills')">Batal</button>
            </form>
        </div>
        <!-- Projects Section -->
        <div class="admin-section" id="admin-projects">
            <h2>Projects <button class="edit-btn" onclick="editSection('projects')"><i class="fas fa-edit"></i>Edit</button></h2>
            <div id="projects-content">
                <b>E-Commerce Website</b> <i class="fas fa-shopping-cart"></i><br>
                <b>Blog Platform</b> <i class="fas fa-blog"></i><br>
                <b>Calculator App</b> <i class="fas fa-calculator"></i><br>
            </div>
            <form id="projects-form" class="edit-form" style="display:none;" enctype="multipart/form-data" method="post" action="save-portfolio.php">
                <input type="hidden" name="section" value="projects">
                <label>Tambah Project Baru</label>
                <input type="text" name="project_title" placeholder="Judul Project">
                <input type="text" name="project_icon" placeholder="Icon Class (misal: fas fa-code)">
                <textarea name="project_desc" rows="2" placeholder="Deskripsi Project"></textarea>
                <label>Upload Gambar/Media Project</label>
                <input type="file" name="project_media" class="file-input" accept="image/*,video/*">
                <button class="save-btn" type="submit"><i class="fas fa-plus"></i>Tambah Project</button>
                <button class="cancel-btn" type="button" onclick="cancelEdit('projects')">Batal</button>
            </form>
        </div>
        <!-- Experience Section (Detail) -->
        <div class="admin-section" id="admin-experience">
            <h2><i class="fas fa-briefcase"></i> Experience</h2>
            <form id="experience-form" class="edit-form" method="post" action="save-portfolio.php">
                <input type="hidden" name="section" value="experience">
                <div style="display:grid;gap:18px;">
                    <div style="border:1px solid var(--primary);border-radius:8px;padding:12px;">
                        <label>Periode</label>
                        <input type="text" name="exp_period[]" value="2024 - Present">
                        <label>Posisi</label>
                        <input type="text" name="exp_title[]" value="Full Stack Developer Intern">
                        <label>Tempat</label>
                        <input type="text" name="exp_place[]" value="Tech Company">
                        <label>Deskripsi</label>
                        <textarea name="exp_desc[]" rows="2">Developing web applications using modern technologies including React, Node.js, and MongoDB. Collaborating with senior developers to deliver high-quality software solutions.</textarea>
                    </div>
                    <div style="border:1px solid var(--primary);border-radius:8px;padding:12px;">
                        <label>Periode</label>
                        <input type="text" name="exp_period[]" value="2023 - 2024">
                        <label>Posisi</label>
                        <input type="text" name="exp_title[]" value="Web Developer">
                        <label>Tempat</label>
                        <input type="text" name="exp_place[]" value="Freelance">
                        <label>Deskripsi</label>
                        <textarea name="exp_desc[]" rows="2">Created responsive websites for small businesses and personal clients. Focused on modern design principles and user experience optimization.</textarea>
                    </div>
                    <div style="border:1px solid var(--primary);border-radius:8px;padding:12px;">
                        <label>Periode</label>
                        <input type="text" name="exp_period[]" value="2023">
                        <label>Posisi</label>
                        <input type="text" name="exp_title[]" value="IT Support Assistant">
                        <label>Tempat</label>
                        <input type="text" name="exp_place[]" value="University IT Department">
                        <label>Deskripsi</label>
                        <textarea name="exp_desc[]" rows="2">Provided technical support to students and faculty. Maintained computer systems and network infrastructure.</textarea>
                    </div>
                    <div style="border:1px solid var(--primary);border-radius:8px;padding:12px;">
                        <label>Periode</label>
                        <input type="text" name="exp_period[]" value="2022 - 2023">
                        <label>Posisi</label>
                        <input type="text" name="exp_title[]" value="Programming Tutor">
                        <label>Tempat</label>
                        <input type="text" name="exp_place[]" value="Institut Teknologi Del">
                        <label>Deskripsi</label>
                        <textarea name="exp_desc[]" rows="2">Assisted junior students in learning programming fundamentals including algorithms, data structures, and object-oriented programming concepts.</textarea>
                    </div>
                    <div style="border:1px solid var(--primary);border-radius:8px;padding:12px;">
                        <label>Periode</label>
                        <input type="text" name="exp_period[]" value="2022">
                        <label>Posisi</label>
                        <input type="text" name="exp_title[]" value="Software Development Intern">
                        <label>Tempat</label>
                        <input type="text" name="exp_place[]" value="Local Startup">
                        <label>Deskripsi</label>
                        <textarea name="exp_desc[]" rows="2">Participated in agile development process, contributed to mobile app development, and learned industry best practices in software engineering.</textarea>
                    </div>
                </div>
                <button class="save-btn" type="submit"><i class="fas fa-save"></i>Simpan</button>
            </form>
        </div>
        <!-- Certificates Section (Detail) -->
        <div class="admin-section" id="admin-certificates">
            <h2><i class="fas fa-certificate"></i> Certificates</h2>
            <form id="certificates-form" class="edit-form" enctype="multipart/form-data" method="post" action="save-portfolio.php">
                <input type="hidden" name="section" value="certificates">
                <div style="display:grid;gap:18px;">
                    <div style="border:1px solid var(--primary);border-radius:8px;padding:12px;">
                        <label>Judul Sertifikat</label>
                        <input type="text" name="certificate_title[]" value="Full Stack Web Development">
                        <label>Penerbit</label>
                        <input type="text" name="certificate_issuer[]" value="Codecademy">
                        <label>Tanggal</label>
                        <input type="text" name="certificate_date[]" value="December 2023">
                        <label>File Sertifikat (PDF/JPG/PNG)</label>
                        <input type="file" name="certificate_file[]" class="file-input" accept="application/pdf,image/*">
                    </div>
                    <div style="border:1px solid var(--primary);border-radius:8px;padding:12px;">
                        <label>Judul Sertifikat</label>
                        <input type="text" name="certificate_title[]" value="JavaScript Algorithms">
                        <label>Penerbit</label>
                        <input type="text" name="certificate_issuer[]" value="FreeCodeCamp">
                        <label>Tanggal</label>
                        <input type="text" name="certificate_date[]" value="October 2023">
                        <label>File Sertifikat (PDF/JPG/PNG)</label>
                        <input type="file" name="certificate_file[]" class="file-input" accept="application/pdf,image/*">
                    </div>
                    <div style="border:1px solid var(--primary);border-radius:8px;padding:12px;">
                        <label>Judul Sertifikat</label>
                        <input type="text" name="certificate_title[]" value="React Development">
                        <label>Penerbit</label>
                        <input type="text" name="certificate_issuer[]" value="Udemy">
                        <label>Tanggal</label>
                        <input type="text" name="certificate_date[]" value="September 2023">
                        <label>File Sertifikat (PDF/JPG/PNG)</label>
                        <input type="file" name="certificate_file[]" class="file-input" accept="application/pdf,image/*">
                    </div>
                    <div style="border:1px solid var(--primary);border-radius:8px;padding:12px;">
                        <label>Judul Sertifikat</label>
                        <input type="text" name="certificate_title[]" value="Database Management">
                        <label>Penerbit</label>
                        <input type="text" name="certificate_issuer[]" value="Oracle Academy">
                        <label>Tanggal</label>
                        <input type="text" name="certificate_date[]" value="August 2023">
                        <label>File Sertifikat (PDF/JPG/PNG)</label>
                        <input type="file" name="certificate_file[]" class="file-input" accept="application/pdf,image/*">
                    </div>
                    <div style="border:1px solid var(--primary);border-radius:8px;padding:12px;">
                        <label>Judul Sertifikat</label>
                        <input type="text" name="certificate_title[]" value="Responsive Web Design">
                        <label>Penerbit</label>
                        <input type="text" name="certificate_issuer[]" value="FreeCodeCamp">
                        <label>Tanggal</label>
                        <input type="text" name="certificate_date[]" value="July 2023">
                        <label>File Sertifikat (PDF/JPG/PNG)</label>
                        <input type="file" name="certificate_file[]" class="file-input" accept="application/pdf,image/*">
                    </div>
                    <div style="border:1px solid var(--primary);border-radius:8px;padding:12px;">
                        <label>Judul Sertifikat</label>
                        <input type="text" name="certificate_title[]" value="Git & Version Control">
                        <label>Penerbit</label>
                        <input type="text" name="certificate_issuer[]" value="GitHub Learning Lab">
                        <label>Tanggal</label>
                        <input type="text" name="certificate_date[]" value="June 2023">
                        <label>File Sertifikat (PDF/JPG/PNG)</label>
                        <input type="file" name="certificate_file[]" class="file-input" accept="application/pdf,image/*">
                    </div>
                </div>
                <button class="save-btn" type="submit"><i class="fas fa-save"></i>Simpan</button>
            </form>
        </div>
        <!-- Contact Section -->
        <div class="admin-section" id="admin-contact">
            <h2>Contact <button class="edit-btn" onclick="editSection('contact')"><i class="fas fa-edit"></i>Edit</button></h2>
            <div id="contact-content">
                Email: maxrumbo@gmail.com<br>
                WhatsApp: 6282183096287<br>
                GitHub: maxrumbo<br>
                Instagram: maxwellrumbo_<br>
            </div>
            <form id="contact-form" class="edit-form" style="display:none;" method="post" action="save-portfolio.php">
                <input type="hidden" name="section" value="contact">
                <label>Email</label>
                <input type="email" name="email" value="maxrumbo@gmail.com">
                <label>WhatsApp</label>
                <input type="text" name="phone" value="6282183096287">
                <label>GitHub</label>
                <input type="text" name="github" value="maxrumbo">
                <label>Instagram</label>
                <input type="text" name="instagram" value="maxwellrumbo_">
                <button class="save-btn" type="submit"><i class="fas fa-save"></i>Simpan</button>
                <button class="cancel-btn" type="button" onclick="cancelEdit('contact')">Batal</button>
            </form>
        </div>
    </div>
    <script>
        function showPreview() {
            window.open('../index.html', '_blank');
        }
    </script>
</body>
</html>
