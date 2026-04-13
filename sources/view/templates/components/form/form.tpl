<form action="index.php?page={{::page::}}" method="post">
    <output id="form-msg">{{::formMsg::}}</output>
    {{::formContent::}}
    <input type="hidden" name="type" value="{{::page::}}">
    <hr>
    <div class="reverse">
        <button class="btn-reset" type="reset">{{::btnDel::}}</button>
        <button class="btn-send" type="submit">{{::btnSend::}}</button>
    </div>
</form>