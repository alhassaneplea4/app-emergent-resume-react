import React from 'react';
import { Link } from 'react-router-dom';
import { ArrowRight, Code, Wrench, Palette } from 'lucide-react';
import { Button } from '../components/ui/button';
import { Card, CardContent } from '../components/ui/card';
import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious,
} from '../components/ui/carousel';
import { carouselSlides, projects } from '../mock';

const Home = () => {
  return (
    <div className="min-h-screen">
      {/* Hero Carousel Section */}
      <section className="relative">
        <Carousel className="w-full" opts={{ loop: true }}>
          <CarouselContent>
            {carouselSlides.map((slide) => (
              <CarouselItem key={slide.id}>
                <div className="relative h-[600px] md:h-[700px]">
                  <img
                    src={slide.image}
                    alt={slide.title}
                    className="absolute inset-0 w-full h-full object-cover"
                    loading="lazy"
                  />
                  <div className="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent" />
                  <div className="absolute inset-0 flex items-center">
                    <div className="container mx-auto px-4">
                      <div className="max-w-2xl">
                        <h1 className="text-4xl md:text-6xl font-bold text-white mb-4">
                          {slide.title}
                        </h1>
                        <p className="text-xl md:text-2xl text-gray-200 mb-3">
                          {slide.subtitle}
                        </p>
                        <p className="text-lg text-gray-300 mb-8">
                          {slide.description}
                        </p>
                        <div className="flex flex-wrap gap-4">
                          <Button asChild size="lg">
                            <Link to="/projects">
                              Voir mes projets <ArrowRight className="ml-2 h-5 w-5" />
                            </Link>
                          </Button>
                          <Button asChild variant="outline" size="lg" className="bg-white/10 backdrop-blur-sm border-white/20 text-white hover:bg-white/20">
                            <Link to="/contact">Me contacter</Link>
                          </Button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </CarouselItem>
            ))}
          </CarouselContent>
          <CarouselPrevious className="left-4" />
          <CarouselNext className="right-4" />
        </Carousel>
      </section>

      {/* Services Section */}
      <section className="py-20 bg-background">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">Mes Services</h2>
            <p className="text-muted-foreground text-lg max-w-2xl mx-auto">
              Des solutions complètes pour tous vos besoins numériques
            </p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <Card className="hover:shadow-lg transition-shadow">
              <CardContent className="p-6">
                <div className="h-12 w-12 rounded-lg bg-primary/10 flex items-center justify-center mb-4">
                  <Code className="h-6 w-6 text-primary" />
                </div>
                <h3 className="text-xl font-bold mb-3">Développement Web</h3>
                <p className="text-muted-foreground">
                  Création de sites web modernes, responsive et performants avec les dernières technologies (HTML5, CSS3, JavaScript, PHP, React).
                </p>
              </CardContent>
            </Card>
            <Card className="hover:shadow-lg transition-shadow">
              <CardContent className="p-6">
                <div className="h-12 w-12 rounded-lg bg-primary/10 flex items-center justify-center mb-4">
                  <Wrench className="h-6 w-6 text-primary" />
                </div>
                <h3 className="text-xl font-bold mb-3">Maintenance Informatique</h3>
                <p className="text-muted-foreground">
                  Configuration, maintenance et support technique pour ordinateurs et systèmes. Diagnostic et résolution de problèmes matériels et logiciels.
                </p>
              </CardContent>
            </Card>
            <Card className="hover:shadow-lg transition-shadow">
              <CardContent className="p-6">
                <div className="h-12 w-12 rounded-lg bg-primary/10 flex items-center justify-center mb-4">
                  <Palette className="h-6 w-6 text-primary" />
                </div>
                <h3 className="text-xl font-bold mb-3">Infographie & Design</h3>
                <p className="text-muted-foreground">
                  Création de visuels professionnels, design UI/UX et identité visuelle pour donner vie à vos projets numériques.
                </p>
              </CardContent>
            </Card>
          </div>
        </div>
      </section>

      {/* Featured Projects */}
      <section className="py-20 bg-card">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">Projets Récents</h2>
            <p className="text-muted-foreground text-lg max-w-2xl mx-auto">
              Découvrez quelques-unes de mes réalisations
            </p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {projects.slice(0, 4).map((project) => (
              <Card key={project.id} className="overflow-hidden hover:shadow-xl transition-all hover:-translate-y-1">
                <img
                  src={project.image}
                  alt={project.title}
                  className="w-full h-64 object-cover"
                  loading="lazy"
                />
                <CardContent className="p-6">
                  <h3 className="text-xl font-bold mb-2">{project.title}</h3>
                  <p className="text-muted-foreground mb-4">{project.description}</p>
                  <div className="flex flex-wrap gap-2">
                    {project.technologies.map((tech) => (
                      <span
                        key={tech}
                        className="px-3 py-1 bg-primary/10 text-primary text-sm rounded-full"
                      >
                        {tech}
                      </span>
                    ))}
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
          <div className="text-center mt-12">
            <Button asChild size="lg">
              <Link to="/projects">
                Voir tous les projets <ArrowRight className="ml-2 h-5 w-5" />
              </Link>
            </Button>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-primary text-primary-foreground">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl md:text-4xl font-bold mb-4">
            Prêt à démarrer votre projet ?
          </h2>
          <p className="text-lg mb-8 max-w-2xl mx-auto opacity-90">
            Je suis disponible pour des stages et opportunités professionnelles. Discutons de votre projet !
          </p>
          <Button asChild size="lg" variant="secondary">
            <Link to="/contact">
              Me contacter maintenant
            </Link>
          </Button>
        </div>
      </section>
    </div>
  );
};

export default Home;
