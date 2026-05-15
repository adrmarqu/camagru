<label for="{{::name::}}">{{::verification::}}</label>
<input type="text" name="{{::name::}}" inputmode="numeric" maxlength="6" autocomplete="one-time-code" placeholder="123456"/>

<button type="submit" name="action" value="generate">
    {{::send_code::}}
</button>
