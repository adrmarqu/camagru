<main>
    <h1>{{::welcome::}}</h1>
    <p>{{::intro::}}</p>
    
    <section class="flex flex-center gallery-container">
        {{::gallery_elements::}}
    </section>

    <div class="flex flex-center index-container {{::hidden::}}">
        {{::index::}}
    </div>
</main>