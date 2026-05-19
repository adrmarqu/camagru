<header>
    <a href="/{{::language::}}/gallery" class="logo">Camagru</a>
    
    <nav class="{{::conn_class::}}">
        <a href="/{{::language::}}/gallery">{{::gallery::}}</a>
        <a href="/{{::language::}}/photo-editor">{{::editor::}}</a>

        <div class="dropdown">
            <button class="dropbtn">{{::username::}} ▼</button>

            <div class="dropdown-content">
                <div class="dropdown-links">
                    <a href="/{{::language::}}/profile/favorites">{{::favorite::}}</a>
                    <a href="/{{::language::}}/profile/gallery">{{::my_gallery::}}</a>
                    <a href="/{{::language::}}/profile/settings">{{::settings::}}</a>
                    <!-- Desplegable con idiomas -->
                </div>
            </div>
        </div>
        <a href="/{{::language::}}/logout">{{::logout::}}</a>
    </nav>

    <nav class="{{::discon_class::}}">
        <a href="/{{::language::}}/login">{{::login::}}</a>
        <a href="/{{::language::}}/signin">{{::signin::}}</a>
    </nav>
</header>