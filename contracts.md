# Contracts Backend - Portfolio Elhadj Alhassana CAMARA

## Vue d'ensemble
Document définissant les contrats API entre le frontend React et le backend FastAPI/MongoDB pour le portfolio professionnel.

## Données MOCK à remplacer
**Fichier**: `/app/frontend/src/mock.js`

### Données statiques (restent en mock)
- `personalInfo` - Informations personnelles
- `skills` - Compétences techniques
- `cvData` - CV formaté
- `carouselSlides` - Slides du carousel
- `projects` - Projets portfolio

### Fonction à implémenter
- `submitContactForm(formData)` - Actuellement mock, à connecter avec l'API backend

## Backend API Endpoints

### 1. POST /api/contact
**Description**: Enregistre un message de contact dans MongoDB et envoie un email

**Request Body**:
```json
{
  "name": "string (required, max 255)",
  "email": "string (required, valid email)",
  "subject": "string (required, max 255)",
  "message": "string (required, max 2000)"
}
```

**Response Success (200)**:
```json
{
  "success": true,
  "message": "Message envoyé avec succès!",
  "id": "mongodb_object_id"
}
```

**Response Error (400/500)**:
```json
{
  "success": false,
  "message": "Description de l'erreur",
  "errors": ["field1: error details"]
}
```

**Validations Backend**:
- Nom: non vide, max 255 caractères
- Email: format valide
- Sujet: non vide, max 255 caractères
- Message: non vide, max 2000 caractères
- Sanitisation XSS pour tous les champs

**Sécurité**:
- Rate limiting: max 5 requêtes par IP toutes les 15 minutes
- CORS configuré pour frontend
- Headers sécurisés
- Validation stricte des données

### 2. GET /api/contact/messages (Admin - optionnel)
**Description**: Récupère tous les messages de contact

**Response**:
```json
{
  "messages": [
    {
      "id": "string",
      "name": "string",
      "email": "string",
      "subject": "string",
      "message": "string",
      "created_at": "ISO datetime"
    }
  ],
  "total": 0
}
```

## MongoDB Collection Schema

### Collection: `contacts`
```javascript
{
  _id: ObjectId,
  name: String (required, max 255),
  email: String (required, email format),
  subject: String (required, max 255),
  message: String (required, max 2000),
  created_at: Date (default: now),
  ip_address: String (pour rate limiting),
  user_agent: String (tracking)
}
```

**Indexes**:
- `created_at`: descending (pour tri)
- `email`: normal (pour recherche)
- `ip_address` + `created_at`: compound (pour rate limiting)

## Frontend Integration

### Fichier à modifier: `/app/frontend/src/pages/Contact.jsx`

**Changements**:
```javascript
// AVANT (mock)
import { submitContactForm } from '../mock';

// APRÈS (API)
import axios from 'axios';

const BACKEND_URL = process.env.REACT_APP_BACKEND_URL;

const handleSubmit = async (e) => {
  e.preventDefault();
  setIsSubmitting(true);

  try {
    const response = await axios.post(`${BACKEND_URL}/api/contact`, formData);
    if (response.data.success) {
      toast({
        title: "Succès!",
        description: response.data.message,
      });
      setFormData({ name: '', email: '', subject: '', message: '' });
    }
  } catch (error) {
    const errorMessage = error.response?.data?.message || "Une erreur s'est produite.";
    toast({
      title: "Erreur",
      description: errorMessage,
      variant: "destructive",
    });
  } finally {
    setIsSubmitting(false);
  }
};
```

## Email Configuration (PHPMailer équivalent en Python)

**Utiliser**: `smtplib` ou bibliothèque `python-multipart` avec FastAPI

**Configuration SMTP Gmail**:
- Host: smtp.gmail.com
- Port: 587 (TLS)
- Username: astronetgn@gmail.com
- Password: qdsnlxzmslgbtydf (app password)

**Email Template**:
```
From: Portfolio Contact <astronetgn@gmail.com>
To: astronetgn@gmail.com
Subject: Nouveau message - [subject from form]

Nouveau message de contact reçu :

Nom: [name]
Email: [email]
Sujet: [subject]

Message:
[message]

---
Envoyé depuis votre portfolio professionnel
Date: [timestamp]
```

## Fichiers Backend à créer

1. **`/app/backend/models/contact.py`** - Modèle Pydantic pour validation
2. **`/app/backend/routes/contact.py`** - Routes API contact
3. **`/app/backend/utils/email_sender.py`** - Service d'envoi d'email
4. **`/app/backend/utils/rate_limiter.py`** - Middleware rate limiting
5. **`/app/backend/server.py`** - Mise à jour pour inclure nouvelles routes

## Tests à effectuer

### Tests Backend (via deep_testing_backend_v2)
1. POST /api/contact avec données valides
2. POST /api/contact avec données invalides (validation)
3. POST /api/contact - test rate limiting (6 requêtes rapides)
4. Vérification MongoDB - données enregistrées
5. Vérification email - email reçu

### Tests Frontend (via auto_frontend_testing_agent)
1. Remplir formulaire et soumettre
2. Vérifier toast de succès
3. Vérifier réinitialisation du formulaire
4. Tester validation HTML5
5. Tester mode sombre sur formulaire

## Notes importantes

- Le frontend garde toutes les données mock SAUF `submitContactForm`
- Les projets, skills, CV restent en dur (pas besoin de base de données)
- Seul le formulaire de contact nécessite MongoDB
- Email password déjà fourni - à stocker dans `/app/backend/.env`
- Ne PAS exposer le password dans le code source
