<?php ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">VidéoQuizz</a>
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mon profil</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="updatepwd.php">Changer le mot de passe</a>
                        <a class="dropdown-item" href="logout.php">Se déconnecter</a>
                    </div>
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
