<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">Blindtest</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <?php if (!empty($nickname)): ?>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="navbar-brand">Bienvenue <?= $nickname; ?></a>
                </li>
                <li class="nav-item">
                    <?php if (!empty($play)): ?>
                        <a class="nav-link active" href="#">Jouer</a>
                    <?php else: ?>
                        <a class="nav-link" href="play.php">Jouer</a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <?php if (!empty($param)): ?>
                        <a class="nav-link active" href="#">Paramètres</a>
                    <?php else: ?>
                        <a class="nav-link" href="param.php">Paramètres</a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <?php if (!empty($profile)): ?>
                        <a class="nav-link active" href="#">Mon profil</a>
                    <?php else: ?>
                        <a class="nav-link" href="profile.php">Mon profil</a>
                    <?php endif; ?>
                </li>
                <?php if ($userData['user_status'] == 1): ?>
                    <li class="nav-item">
                        <?php if (!empty($crud)): ?>
                            <a class="nav-link active" href="#">Liste des questions</a>
                        <?php else: ?>
                            <a class="nav-link" href="crud_option.php">Liste des questions</a>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Se déconnecter</a>
                </li>
            </ul>
        </div>
    <?php else: ?>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php if (!empty($index)): ?>
                        <a class="nav-link active" href="#">Accueil</a>
                    <?php else: ?>
                        <a class="nav-link" href="index.php">Accueil</a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <?php if (!empty($register)): ?>
                        <a class="nav-link active" href="#">Inscription</a>
                    <?php else: ?>
                        <a class="nav-link" href="register.php">Inscription</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</nav>
