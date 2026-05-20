<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <a class="navbar-brand" href="accueil.php">
                <img src="images/logo5.png" alt="Logo Cinéphoria">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="accueil.php">ACCUEIL</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="films.php">RÉSERVATION</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="films.php">FILMS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">CONTACT</a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>

                        <li class="nav-item">
                            <a class="nav-link" href="mon_espace.php">MON ESPACE</a>
                        </li>

                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php">ESPACE ADMIN</a>
                            </li>
                        <?php endif; ?>

                        <?php if ($_SESSION['user_role'] === 'employe'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="intranet.php">INTRANET</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">DÉCONNEXION</a>
                        </li>

                    <?php else: ?>

                        <li class="nav-item">
                            <a class="nav-link" href="login.php">CONNEXION</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="inscription.php">INSCRIPTION</a>
                        </li>

                    <?php endif; ?>

                </ul>
            </div>

        </div>
    </nav>
</header>