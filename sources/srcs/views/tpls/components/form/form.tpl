<form action="app.php?page={{::page::}}" id="form-cam" method="post">
    {{::formContent::}}
    <input type="hidden" name="type" value="{{::type::}}">
    <hr>
    <div class="reverse">
        <button class="btn-reset" type="reset">{{::btnDel::}}</button>
        <button class="btn-send" type="submit">{{::btnSend::}}</button>
    </div>
</form>