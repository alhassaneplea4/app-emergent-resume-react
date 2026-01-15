    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3"><?= PERSONAL_INFO['firstName'] . ' ' . PERSONAL_INFO['lastName'] ?></h5>
                    <p class="text-muted"><?= PERSONAL_INFO['title'] ?></p>
                    <p class="small">Passionné par la création de solutions numériques innovantes et performantes.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Navigation</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-light text-decoration-none">Accueil</a></li>
                        <li><a href="about.php" class="text-light text-decoration-none">À Propos</a></li>
                        <li><a href="projects.php" class="text-light text-decoration-none">Projets</a></li>
                        <li><a href="contact.php" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Contact</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-envelope me-2"></i>
                            <a href="mailto:<?= PERSONAL_INFO['email'] ?>" class="text-light text-decoration-none"><?= PERSONAL_INFO['email'] ?></a>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone me-2"></i>
                            <a href="tel:<?= PERSONAL_INFO['phone'] ?>" class="text-light text-decoration-none"><?= PERSONAL_INFO['phone'] ?></a>
                        </li>
                        <li>
                            <i class="bi bi-geo-alt me-2"></i>
                            <?= PERSONAL_INFO['location'] ?>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; <?= date('Y') ?> <?= PERSONAL_INFO['firstName'] . ' ' . PERSONAL_INFO['lastName'] ?>. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-light me-3"><i class="bi bi-github fs-5"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-linkedin fs-5"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>
