<main class="flex flex-column flex-center">

    <h1 class="h text-white">{{::form_title::}}</h1>

    <p class="p text-white">{{::form_text::}}</p>

    <form class="form flex flex-column" action="{{::form_url::}}" method="post">
        <output class="form-error {{::output_transparent::}}"></output>
        {{::form_content::}}
        <div class="form-btn-container">
            <button class="btn btn-secondary" type="button">{{::cancel::}}</button>
            <button class="btn btn-primary" type="submit">{{::send::}}</button>
        </div>
    </form>
</main> 