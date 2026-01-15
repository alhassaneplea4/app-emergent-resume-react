// Mock data for portfolio

export const personalInfo = {
  firstName: "Elhadj Alhassana",
  lastName: "CAMARA",
  title: "Développeur Web",
  phone: "+224 624 62 94 77",
  email: "astronetgn@gmail.com",
  bio: "Passionné par le développement web et les solutions numériques, je crée des expériences digitales modernes et performantes. Spécialisé dans la maintenance informatique, la configuration systèmes et l'infographie, je m'engage à livrer des projets de qualité qui répondent aux besoins de mes clients.",
  location: "Guinée",
  availability: "Disponible pour stages et opportunités"
};

export const skills = [
  { category: "Développement Web", items: ["HTML5", "CSS3", "JavaScript ES6+", "PHP 8", "Bootstrap 5", "React"] },
  { category: "Backend & Databases", items: ["MySQL", "PDO", "MongoDB", "RESTful APIs"] },
  { category: "Maintenance & Systèmes", items: ["Configuration Ordinateurs", "Maintenance Informatique", "Support Technique"] },
  { category: "Design & Créativité", items: ["Infographie", "UI/UX Design", "Adobe Suite", "Responsive Design"] },
  { category: "Outils & Méthodologies", items: ["Git", "Apache/Nginx", "Sécurité OWASP", "SEO"] }
];

export const projects = [
  {
    id: 1,
    title: "Plateforme E-Commerce",
    description: "Développement d'une plateforme de commerce en ligne complète avec système de paiement sécurisé, gestion des stocks et interface administrateur.",
    technologies: ["PHP", "MySQL", "Bootstrap", "JavaScript"],
    category: "Web",
    link: "#",
    image: "https://images.unsplash.com/photo-1557821552-17105176677c?w=800&q=80"
  },
  {
    id: 2,
    title: "Application de Gestion",
    description: "Système de gestion pour entreprises incluant gestion clients, facturation automatique, rapports et tableaux de bord analytiques.",
    technologies: ["React", "FastAPI", "MongoDB"],
    category: "Web",
    link: "#",
    image: "https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80"
  },
  {
    id: 3,
    title: "Site Vitrine Responsive",
    description: "Conception et développement d'un site vitrine moderne avec animations fluides, optimisé pour tous les appareils et conforme aux standards SEO.",
    technologies: ["HTML5", "CSS3", "JavaScript", "Bootstrap"],
    category: "Design",
    link: "#",
    image: "https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&q=80"
  },
  {
    id: 4,
    title: "Maintenance Parc Informatique",
    description: "Configuration et maintenance complète d'un parc informatique de 50+ machines, incluant installation systèmes, sécurisation réseau et support utilisateurs.",
    technologies: ["Windows Server", "Linux", "Réseau", "Sécurité"],
    category: "Maintenance",
    link: "#",
    image: "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&q=80"
  }
];

export const cvData = {
  profile: {
    nom: "CAMARA",
    prenom: "Elhadj Alhassana",
    titre: "Développeur Web",
    telephone: "+224 624 62 94 77",
    email: "astronetgn@gmail.com",
    localisation: "Guinée"
  },
  formation: [
    {
      diplome: "Formation Développement Web Full-Stack",
      etablissement: "Centre de Formation Numérique",
      annee: "2023-2024",
      description: "HTML, CSS, JavaScript, PHP, MySQL, Bootstrap"
    },
    {
      diplome: "Certification Maintenance Informatique",
      etablissement: "Institut Technique",
      annee: "2022",
      description: "Configuration systèmes, diagnostic matériel, support utilisateur"
    }
  ],
  experience: [
    {
      poste: "Développeur Web Freelance",
      entreprise: "Indépendant",
      periode: "2023 - Présent",
      missions: [
        "Développement de sites web responsive",
        "Maintenance et optimisation de projets existants",
        "Configuration et support technique"
      ]
    },
    {
      poste: "Technicien Maintenance Informatique",
      entreprise: "Entreprise Locale",
      periode: "2022 - 2023",
      missions: [
        "Configuration et maintenance parc informatique",
        "Installation et mise à jour systèmes",
        "Support technique utilisateurs"
      ]
    }
  ],
  competences: [
    "Développement Web (HTML, CSS, JavaScript, PHP)",
    "Responsive Design & Bootstrap",
    "Maintenance Informatique",
    "Configuration Systèmes",
    "Infographie & Design",
    "Solutions Numériques Personnalisées"
  ]
};

export const carouselSlides = [
  {
    id: 1,
    title: "Développeur Web Créatif",
    subtitle: "Transformons vos idées en réalité numérique",
    description: "Solutions web modernes et performantes",
    image: "https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=1920&q=80"
  },
  {
    id: 2,
    title: "Solutions Numériques",
    subtitle: "De la conception à la maintenance",
    description: "Expertise complète en développement et support",
    image: "https://images.unsplash.com/photo-1487058792275-0ad4aaf24ca7?w=1920&q=80"
  },
  {
    id: 3,
    title: "Maintenance & Support",
    subtitle: "Votre partenaire informatique de confiance",
    description: "Configuration, maintenance et optimisation",
    image: "https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=1920&q=80"
  }
];

// Mock function for contact form submission
export const submitContactForm = async (formData) => {
  return new Promise((resolve) => {
    setTimeout(() => {
      console.log('Form submitted (mock):', formData);
      resolve({ success: true, message: "Message envoyé avec succès!" });
    }, 1000);
  });
};
