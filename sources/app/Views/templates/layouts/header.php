<!-- 
Para que los botones y links sean iguales
.nav-item {
    background: none;
    border: none;
    color: inherit;
    font: inherit;
    text-decoration: none;
    cursor: pointer;
    padding: .5rem 1rem;
}
-->
<a class="logo-link" href="/<?= $lang ?>/gallery">
    <svg xmlns="http://www.w3.org/2000/svg"
     viewBox="6.5 8.5 29 23"
     width="42"
     height="42"
     fill="none"
     stroke="currentColor"
     stroke-width="2"
     stroke-linecap="round"
     stroke-linejoin="round">

        <!-- Cuerpo de la cámara -->
        <rect x="7" y="11" width="28" height="20" rx="4"/>

        <!-- Parte superior -->
        <path d="M13 11l2-3h12l2 3"/>

        <!-- Lente -->
        <circle cx="21" cy="21" r="6"/>

        <!-- Obturador -->
        <circle cx="21" cy="21" r="2.2"/>

        <!-- Flash -->
        <circle cx="30" cy="16" r="1"/>
    </svg>
    <span>Camagru</span>
</a>

<nav>
    <!-- Guests -->
    <?php if (!$logged): ?>
        <!-- Only mobile -->
        <button class="burger open">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div>
            <a href="/<?= $lang ?>/login">Login</a>
            <a href="/<?= $lang ?>/signin">Signin</a>
        </div>

    <!-- Users -->
    <?php else: ?> 
        <!-- Only mobile -->
        <button class="burger">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div>
            <a href="/<?= $lang ?>/gallery">Galeria</a>
            <a href="/<?= $lang ?>/photo-editor">Editor</a>

            <div>
                <button>usuario</button>
                <div>
                    <a href="/<?= $lang ?>/profile">Perfil</a>
                    <a href="/<?= $lang ?>/private-gallery">Mi galeria</a>
                    
                    <!-- Only pc -->
                    <div>
                        <button>Idioma</button>
                        <div>
                            <a href="/en/<?= $page ?>">Ingles</a>
                            <a href="/es/<?= $page ?>">Español</a>
                            <a href="/ca/<?= $page ?>">Catalan</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Only mobile -->
            <div>
                <button>Idioma</button>
                <div>
                    <a href="/en/<?= $page ?>">Ingles</a>
                    <a href="/es/<?= $page ?>">Español</a>
                    <a href="/ca/<?= $page ?>">Catalan</a>
                </div>
            </div>

            <button class="btn-logout">Logout</button>
        </div>
    <?php endif; ?>
</nav>