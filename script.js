function toggleTheme() {
    const body = document.body;
    const icon = document.getElementById('theme-icon');

    if (body.classList.contains('dark-mode')) {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
    } else {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
    }
}

const sections = document.querySelectorAll('section');
const navLinks = document.querySelectorAll('.nav-link');

window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (scrollY >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Actividad: Manipulación del DOM
document.addEventListener('DOMContentLoaded', function() {
    // Control 1: Mostrar/Ocultar proyectos completados
    const completedProjects = document.querySelectorAll('.project-item.completed');
    const toggleBtn = document.getElementById('toggleCompletedBtn');
    let hidden = false;

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            completedProjects.forEach(function(project) {
                if (hidden) {
                    project.classList.remove('hidden');
                } else {
                    project.classList.add('hidden');
                }
            });
            if (hidden) {
                toggleBtn.innerHTML = '<i class="fa-regular fa-eye-slash me-2"></i>Ocultar completados';
                hidden = false;
            } else {
                toggleBtn.innerHTML = '<i class="fa-regular fa-eye me-2"></i>Mostrar completados';
                hidden = true;
            }
        });
    }

    // Control 2: Cambiar imagen y texto del primer proyecto
    const firstProject = document.querySelector('.project-item');
    const changeBtn = document.getElementById('changeContentBtn');
    let originalContent = {};

    if (firstProject && changeBtn) {
        const projectCard = firstProject.querySelector('.project-card');
        const titleElem = firstProject.querySelector('.project-title');
        const iconElem = firstProject.querySelector('.azure-icon i');
        let originalTitle = titleElem ? titleElem.textContent : '';
        let originalIconClass = iconElem ? iconElem.className : '';
        let modified = false;

        originalContent.title = originalTitle;
        originalContent.icon = originalIconClass;

        changeBtn.addEventListener('click', function() {
            if (!modified) {
                if (titleElem) titleElem.textContent = ' PROYECTO DESTACADO';
                if (iconElem) {
                    iconElem.className = 'fa-solid fa-rocket';
                    iconElem.style.color = '#ff6600';
                }
                changeBtn.innerHTML = '<i class="fa-regular fa-rotate-left me-2"></i>Restaurar original';
                modified = true;
            } else {
                if (titleElem) titleElem.textContent = originalContent.title;
                if (iconElem) {
                    iconElem.className = originalContent.icon;
                    iconElem.style.color = '';
                }
                changeBtn.innerHTML = '<i class="fa-regular fa-image me-2"></i>Cambiar imagen/título del primer proyecto';
                modified = false;
            }
        });
    }
});