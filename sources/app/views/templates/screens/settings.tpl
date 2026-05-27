<main class="flex flex-column flex-center">
    <form class="form big flex flex-column">
        <h1>{{::settings_title::}}</h1>
        
        <hr class="hr">
        
        <div class="flex flex-between">
            <label>{{::change_user::}}</label>
            <button class="btn btn-secondary" type="button">{{::update::}}</button>
        </div>
        
        <div class="flex flex-between">
            <label>{{::change_email::}}</label>
            <button class="btn btn-secondary" type="button">{{::update::}}</button>
        </div>

        <div class="flex flex-between">
            <label>{{::change_pass::}}</label>
            <button class="btn btn-secondary" type="button">{{::update::}}</button>
        </div>

        <hr class="hr">

        <div class="flex flex-between">
            <label>{{::notification::}}</label>
            <button id="noti" class="btn btn-secondary" type="button" value="1">
                Activar
            </button>
        </div>

        <div class="flex flex-between">
            <label>{{::remember_user::}}</label>
            <button
            id="remember" class="btn btn-secondary" type="button" value="0">
                Recordar
            </button>
        </div>

        <hr class="hr">
        <button class="btn btn-primary form-btn-max" type="submit">
            {{::apply::}}
        </button>
    </form>
</main>