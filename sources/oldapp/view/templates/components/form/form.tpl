<form action="/{{::language::}}/{{::page::}}" method="post">
    <output id="form-msg">{{::form_output::}}</output>
    {{::form_content::}}
    <input type="hidden" name="type" value="{{::page::}}">
    <hr>
    <div class="reverse">
        <button class="btn-reset" type="reset">
            {{::btn_del::}}
        </button>
        <button class="btn-send" type="submit" name="action">
            {{::btn_send::}}
        </button>
    </div>
</form>