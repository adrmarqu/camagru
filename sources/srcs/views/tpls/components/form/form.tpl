<form action="app.php?page={{::formPage::}}" method="post">
    {{::formContent::}}
    <input type="hidden" name="type" value="{{::formType::}}">
    <hr>
    <div class="reverse">
        <button class="btn-reset" type="reset">{{::btnDel::}}</button>
        <button class="btn-send" type="submit">{{::btnSend::}}</button>
    </div>
</form>