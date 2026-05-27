<div class="flex flex-column">
    <label class="form-label" for="usermail">{{::usermail::}}</label>
    <input class="form-input" type="text" name="usermail">
</div>

<div class="flex flex-column">
    <label class="form-label" for="pass">{{::pass::}}</label>
    <input class="form-input" type="password" name="pass">
</div>

<div class="flex flex-between">
    <div class="flex flex-end flex-row-reverse">
        <label class="form-label" for="remember">{{::remember_user::}}</label>
        <input class="form-checkbox" type="checkbox" name="remember">
    </div>
    <a class="link" href="{{::language::}}/send-email?type=forgot">
        {{::forgot_pass::}}
    </a>
</div> 