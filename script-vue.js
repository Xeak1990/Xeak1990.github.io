// script-vue.js
// Framework elegido: Vue.js (versión 2)
// Ventaja: Permite crear componentes reutilizables con props, data y métodos de forma declarativa.

// Datos de los proyectos (simulan una base de datos)
const projectsData = [
    {
        title: "Sistema POS Web para comercios",
        description: "Aplicación web de punto de venta (POS) con inventario en tiempo real, múltiples sucursales y reportes.",
        status: "in-progress",
        tags: ["PostgreSQL", "Node.js", "Next.js"],
        iconClass: "fa-solid fa-cash-register",
        cardColor: "#9b59b6"
    },
    {
        title: "Microservicio en Haskell para Fedora",
        description: "Microservicio funcional en Haskell, desplegado en Fedora Linux sobre Azure VM. Procesa eventos de inventario con alta concurrencia.",
        status: "completed",
        tags: ["Haskell", "Fedora", "Azure VM", "REST API"],
        iconClass: "fa-brands fa-linux",
        cardColor: "#28a745"
    },
    {
        title: "API Serverless para Notificaciones",
        description: "API sin servidor con Azure Functions que envía alertas por correo cuando el stock es bajo.",
        status: "planned",
        tags: ["Azure Functions", "SendGrid", "Queue Storage", "Node.js"],
        iconClass: "fa-solid fa-bolt",
        cardColor: "#17a2b8"
    },
    {
        title: "Búsqueda semántica con Cognitive Search",
        description: "Buscador inteligente sobre catálogo de productos usando Azure Cognitive Search y enriquecimiento con IA.",
        status: "completed",
        tags: ["Cognitive Search", "AI Skills", "Blob Storage"],
        iconClass: "fa-solid fa-magnifying-glass",
        cardColor: "#28a745"
    },
    {
        title: "Infraestructura como Código con Bicep",
        description: "Despliegue automatizado de recursos Azure usando Bicep y Azure Pipelines.",
        status: "in-progress",
        tags: ["Bicep", "Azure Pipelines", "ARM"],
        iconClass: "fa-solid fa-code-branch",
        cardColor: "#9b59b6"
    },
    {
        title: "CI/CD Pipeline con Azure DevOps",
        description: "Pipeline completo desde GitHub a Azure App Service, con pruebas automatizadas.",
        status: "planned",
        tags: ["Azure DevOps", "GitHub Actions", "Testing"],
        iconClass: "fa-brands fa-azure",
        cardColor: "#17a2b8"
    }
];

// 1. Definición del componente reutilizable "project-card"
Vue.component('project-card', {
    // Props: propiedades que recibe el componente desde el padre
    props: {
        title: String,
        description: String,
        status: String,
        tags: Array,
        iconClass: String,
        cardColor: String
    },
    // Template del componente (estructura visual)
    template: `
        <div class="col-md-6 col-lg-4 project-item" :class="status">
            <div class="project-card" :style="{ borderTop: '4px solid ' + cardColor }">
                <div class="azure-icon">
                    <i :class="iconClass"></i>
                </div>
                <h3 class="fw-bold project-title">{{ title }}</h3>
                <p class="text-muted">
                    <span class="badge" :class="statusBadgeClass">{{ statusText }}</span>
                </p>
                <p class="text-muted">{{ description }}</p>
                <div class="mt-3">
                    <span v-for="tag in tags" class="skill-tag">{{ tag }}</span>
                </div>
                <div class="mt-3">
                    <small :class="statusColorClass">
                        <i :class="statusIcon"></i> {{ statusMessage }}
                    </small>
                </div>
                <!-- Botón dinámico que emite un evento al padre -->
                <button @click="$emit('status-click', title)" class="btn btn-sm btn-outline-custom mt-3">
                    Ver detalles del estado
                </button>
            </div>
        </div>
    `,
    // Propiedades computadas para comportamiento dinámico
    computed: {
        statusText() {
            const texts = {
                'completed': 'Completado',
                'in-progress': 'En desarrollo',
                'planned': 'Próximo proyecto'
            };
            return texts[this.status] || 'Estado';
        },
        statusBadgeClass() {
            const classes = {
                'completed': 'bg-success',
                'in-progress': 'bg-primary',
                'planned': 'bg-warning'
            };
            return classes[this.status] || 'bg-secondary';
        },
        statusIcon() {
            const icons = {
                'completed': 'fa-solid fa-circle-check',
                'in-progress': 'fa-solid fa-circle-check',
                'planned': 'fa-regular fa-clock'
            };
            return icons[this.status] || 'fa-regular fa-question-circle';
        },
        statusMessage() {
            const messages = {
                'completed': 'Completado - Práctica académica',
                'in-progress': 'En desarrollo - Proyecto principal',
                'planned': 'Planificado - Para siguiente sprint'
            };
            return messages[this.status] || 'Estado indefinido';
        },
        statusColorClass() {
            const colors = {
                'completed': 'text-success',
                'in-progress': 'text-primary-custom',
                'planned': 'text-warning'
            };
            return colors[this.status] || 'text-muted';
        }
    }
});

// 2. Instancia principal de Vue
new Vue({
    el: '#projectsContainer',  // Se monta en el contenedor de proyectos
    data: {
        projects: projectsData,     // Lista original de proyectos
        showCompleted: true,        // Control para ocultar/mostrar completados
        // Propiedad dinámica para cambiar colores
        colorOverrides: {}          // Almacena colores personalizados por proyecto
    },
    computed: {
        // Filtro dinámico: si showCompleted es false, oculta los completados
        filteredProjects() {
            if (this.showCompleted) {
                return this.projects.map((p, idx) => ({
                    ...p,
                    cardColor: this.colorOverrides[idx] || p.cardColor
                }));
            } else {
                return this.projects
                    .filter(p => p.status !== 'completed')
                    .map((p, idx) => ({
                        ...p,
                        cardColor: this.colorOverrides[idx] || p.cardColor
                    }));
            }
        }
    },
    methods: {
        // Comportamiento dinámico 1: Ocultar/mostrar proyectos completados
        toggleCompleted() {
            this.showCompleted = !this.showCompleted;
        },
        // Comportamiento dinámico 2: Cambiar colores aleatoriamente
        randomizeColors() {
            const colors = ['#e74c3c', '#3498db', '#2ecc71', '#f39c12', '#1abc9c', '#e67e22'];
            this.projects.forEach((_, index) => {
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                // Usamos Vue.set para que sea reactivo (en Vue 2)
                this.$set(this.colorOverrides, index, randomColor);
            });
        },
        // Manejar el evento emitido por el componente hijo
        handleStatusClick(projectTitle) {
            alert(`Has hecho clic en: ${projectTitle}\nEste es un evento emitido desde el componente hijo al padre.`);
        }
    }
});