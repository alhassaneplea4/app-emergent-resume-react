import React from 'react';
import { Card, CardContent } from '../components/ui/card';
import { Badge } from '../components/ui/badge';
import { personalInfo, skills, cvData } from '../mock';
import { Mail, Phone, MapPin, Download } from 'lucide-react';
import { Button } from '../components/ui/button';

const About = () => {
  return (
    <div className="min-h-screen py-16">
      <div className="container mx-auto px-4">
        {/* Hero Section */}
        <div className="mb-16 text-center">
          <h1 className="text-4xl md:text-5xl font-bold mb-4">À Propos de Moi</h1>
          <p className="text-muted-foreground text-lg max-w-3xl mx-auto">
            Découvrez mon parcours, mes compétences et mon expérience
          </p>
        </div>

        {/* Bio Section */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
          <div className="lg:col-span-2">
            <Card>
              <CardContent className="p-8">
                <h2 className="text-2xl font-bold mb-4">Biographie</h2>
                <p className="text-muted-foreground leading-relaxed mb-6">
                  {personalInfo.bio}
                </p>
                <div className="space-y-3">
                  <div className="flex items-center text-muted-foreground">
                    <Mail className="h-5 w-5 mr-3 text-primary" />
                    <a href={`mailto:${personalInfo.email}`} className="hover:text-primary transition-colors">
                      {personalInfo.email}
                    </a>
                  </div>
                  <div className="flex items-center text-muted-foreground">
                    <Phone className="h-5 w-5 mr-3 text-primary" />
                    <a href={`tel:${personalInfo.phone}`} className="hover:text-primary transition-colors">
                      {personalInfo.phone}
                    </a>
                  </div>
                  <div className="flex items-center text-muted-foreground">
                    <MapPin className="h-5 w-5 mr-3 text-primary" />
                    {personalInfo.location}
                  </div>
                </div>
              </CardContent>
            </Card>
          </div>

          <div>
            <Card className="bg-primary text-primary-foreground">
              <CardContent className="p-8 text-center">
                <h2 className="text-2xl font-bold mb-2">{personalInfo.firstName}</h2>
                <h2 className="text-2xl font-bold mb-4">{personalInfo.lastName}</h2>
                <p className="text-lg mb-6">{personalInfo.title}</p>
                <Badge variant="secondary" className="mb-6">
                  {personalInfo.availability}
                </Badge>
                <Button variant="secondary" className="w-full" size="lg">
                  <Download className="mr-2 h-5 w-5" />
                  Télécharger CV
                </Button>
              </CardContent>
            </Card>
          </div>
        </div>

        {/* Skills Section */}
        <div className="mb-16">
          <h2 className="text-3xl font-bold mb-8 text-center">Compétences</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {skills.map((skillGroup, index) => (
              <Card key={index} className="hover:shadow-lg transition-shadow">
                <CardContent className="p-6">
                  <h3 className="text-lg font-bold mb-4 text-primary">{skillGroup.category}</h3>
                  <div className="flex flex-wrap gap-2">
                    {skillGroup.items.map((skill, idx) => (
                      <Badge key={idx} variant="secondary">
                        {skill}
                      </Badge>
                    ))}
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>

        {/* CV Section - Formatted as Code */}
        <div className="mb-16">
          <h2 className="text-3xl font-bold mb-8 text-center">Curriculum Vitae</h2>
          <Card className="bg-card">
            <CardContent className="p-0">
              <div className="bg-muted/50 px-6 py-3 border-b border-border flex items-center justify-between">
                <span className="text-sm font-mono text-muted-foreground">cv.py</span>
                <div className="flex space-x-2">
                  <div className="w-3 h-3 rounded-full bg-red-500"></div>
                  <div className="w-3 h-3 rounded-full bg-yellow-500"></div>
                  <div className="w-3 h-3 rounded-full bg-green-500"></div>
                </div>
              </div>
              <pre className="p-6 overflow-x-auto text-sm">
                <code className="font-mono">
{`# Curriculum Vitae - Python Format

profile = {
    "nom": "${cvData.profile.nom}",
    "prenom": "${cvData.profile.prenom}",
    "titre": "${cvData.profile.titre}",
    "telephone": "${cvData.profile.telephone}",
    "email": "${cvData.profile.email}",
    "localisation": "${cvData.profile.localisation}"
}

formation = [
${cvData.formation.map((f, i) => `    {
        "diplome": "${f.diplome}",
        "etablissement": "${f.etablissement}",
        "annee": "${f.annee}",
        "description": "${f.description}"
    }${i < cvData.formation.length - 1 ? ',' : ''}`).join('\n')}
]

experience = [
${cvData.experience.map((e, i) => `    {
        "poste": "${e.poste}",
        "entreprise": "${e.entreprise}",
        "periode": "${e.periode}",
        "missions": [
${e.missions.map((m, j) => `            "${m}"${j < e.missions.length - 1 ? ',' : ''}`).join('\n')}
        ]
    }${i < cvData.experience.length - 1 ? ',' : ''}`).join('\n')}
]

competences = [
${cvData.competences.map((c, i) => `    "${c}"${i < cvData.competences.length - 1 ? ',' : ''}`).join('\n')}
]
`}
                </code>
              </pre>
            </CardContent>
          </Card>
        </div>
      </div>
    </div>
  );
};

export default About;
