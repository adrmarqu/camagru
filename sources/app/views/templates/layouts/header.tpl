<header class="flex flex-between">
    <a id="home" class="link" href="/gallery">Camagru</a>

    <nav class="flex flex-between">
        <a class="link header nav-pc" href="/{{::language::}}/{{::a_href::}}">
            {{::a_text::}}
        </a>
        <a class="link header nav-pc" href="/{{::language::}}/{{::b_href::}}">
            {{::b_text::}}
        </a>

        <div class="dropdown {{::nav_mobile::}}">
            <button id="btn-drop" class="{{::btn_drop_type::}}">
                {{::btn_drop_content::}}
            </button>

            <div id="drop" class="hidden">
                <div class="dropdown-list">
                    {{::drop_links::}}

                    <button id="btn-lang" class="btn btn-lang">
                        {{::language_name::}}
                    </button>
                    
                    <div id="drop-lang" class="hidden">
                        <div class="dropdown-list lang-pos">
                            <a class="link header drop" href="/{{::language::}}/{{::page::}}">{{::lang_es::}}</a>
                            <a class="link header drop" href="/{{::language::}}/{{::page::}}">{{::lang_ca::}}</a>
                            <a class="link header drop" href="/{{::language::}}/{{::page::}}">{{::lang_en::}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{::logout::}}
    </nav>
</header>