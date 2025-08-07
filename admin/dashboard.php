
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
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .edit-btn { background: #7dcfff; color: #232946; border: none; border-radius: 6px; padding: 6px 16px; margin-left: 10px; cursor: pointer; font-size: 14px; font-weight: 500; transition: all 0.3s; }
        .edit-btn i { margin-right: 6px; }
        .save-btn { background: #9ece6a; color: #232946; border: none; border-radius: 6px; padding: 6px 16px; margin-left: 10px; cursor: pointer; font-size: 14px; font-weight: 500; transition: all 0.3s; }
        .cancel-btn { background: #ff5c57; color: #fff; border: none; border-radius: 6px; padding: 6px 16px; margin-left: 10px; cursor: pointer; font-size: 14px; font-weight: 500; transition: all 0.3s; }
        .file-input { margin-top: 8px; }
        .logout { float: right; background: #ff5c57; color: #fff; }
        .admin-section { position: relative; margin-bottom: 40px; border: 1px solid #7dcfff; border-radius: 10px; padding: 24px; background: #16161a; }
        .admin-section h2 { display: flex; align-items: center; justify-content: space-between; }
        .admin-section .edit-form { margin-top: 18px; }
    </style>
</head>
<body>
    <form method="post" action="logout.php" style="display:inline; float:right; margin: 20px;">
        <button class="logout" type="submit">Logout</button>
    </form>
    <h1 style="text-align:center; margin-top: 30px;">Admin Dashboard - Edit Portfolio</h1>
    <div class="container" style="max-width: 1000px; margin: 40px auto;">
        <!-- Hero Section -->
        <div class="admin-section" id="admin-hero">
            <h2>Hero/Profile <button class="edit-btn" onclick="editSection('hero')"><i class="fas fa-edit"></i>Edit</button></h2>
            <div id="hero-content">
                <b>Nama:</b> Maxwell Rumahorbo<br>
                <b>Role:</b> Information Systems Student<br>
                <b>Department:</b> Information Technology<br>
                <b>ID:</b> 2024.DEV.001<br>
                <b>Foto Profil:</b> <img src="../assets/images/profile 2.jpg" alt="Profile" style="height:60px;vertical-align:middle;"> <br>
            </div>
            <form id="hero-form" class="edit-form" style="display:none;" enctype="multipart/form-data" method="post" action="save-portfolio.php">
                <input type="hidden" name="section" value="hero">
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
                <button class="save-btn" type="submit"><i class="fas fa-save"></i>Simpan</button>
                <button class="cancel-btn" type="button" onclick="cancelEdit('hero')">Batal</button>
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
        <!-- Experience Section -->
        <div class="admin-section" id="admin-experience">
            <h2>Experience <button class="edit-btn" onclick="editSection('experience')"><i class="fas fa-edit"></i>Edit</button></h2>
            <div id="experience-content">
                Full Stack Developer Intern, Web Developer, IT Support Assistant, Programming Tutor, Software Development Intern
            </div>
            <form id="experience-form" class="edit-form" style="display:none;" method="post" action="save-portfolio.php">
                <input type="hidden" name="section" value="experience">
                <label>Daftar Pengalaman (pisahkan dengan koma)</label>
                <input type="text" name="experiences" value="Full Stack Developer Intern, Web Developer, IT Support Assistant, Programming Tutor, Software Development Intern">
                <button class="save-btn" type="submit"><i class="fas fa-save"></i>Simpan</button>
                <button class="cancel-btn" type="button" onclick="cancelEdit('experience')">Batal</button>
            </form>
        </div>
        <!-- Certificates Section -->
        <div class="admin-section" id="admin-certificates">
            <h2>Certificates <button class="edit-btn" onclick="editSection('certificates')"><i class="fas fa-edit"></i>Edit</button></h2>
            <div id="certificates-content">
                Full Stack Web Development, JavaScript Algorithms, React Development, Database Management, Responsive Web Design, Git & Version Control
            </div>
            <form id="certificates-form" class="edit-form" style="display:none;" enctype="multipart/form-data" method="post" action="save-portfolio.php">
                <input type="hidden" name="section" value="certificates">
                <label>Tambah Sertifikat</label>
                <input type="text" name="certificate_title" placeholder="Judul Sertifikat">
                <input type="text" name="certificate_issuer" placeholder="Penerbit">
                <input type="text" name="certificate_date" placeholder="Tanggal (misal: Desember 2023)">
                <label>Upload File Sertifikat (PDF/JPG/PNG)</label>
                <input type="file" name="certificate_file" class="file-input" accept="application/pdf,image/*">
                <button class="save-btn" type="submit"><i class="fas fa-plus"></i>Tambah Sertifikat</button>
                <button class="cancel-btn" type="button" onclick="cancelEdit('certificates')">Batal</button>
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
        function editSection(section) {
            document.getElementById(section+'-form').style.display = 'block';
            document.getElementById(section+'-content').style.display = 'none';
        }
        function cancelEdit(section) {
            document.getElementById(section+'-form').style.display = 'none';
            document.getElementById(section+'-content').style.display = 'block';
        }
    </script>
</body>
</html>
