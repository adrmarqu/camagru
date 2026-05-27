<div class="gallery-element">
    <!-- User + delete -->
    <p class="element-user">{{::username::}}</p>

    <!-- Image -->
    <img class="element-image" src="/media/{{::image::}}" alt="Upload image" title="Upload image">

    <!-- Likes + comments buttons -->
    <div class="flex flex-around element-btn-container">
        
        <button class="flex flex-center element-icon-btn btn-like">
            <img class="element-icon" src="/media/assets/like.svg" alt="like" title="like">
            <span class="element-icon-span">{{::n_likes::}}</span>
        </button>

        <button class="flex flex-center element-icon-btn btn-com">
            <img class="element-icon" src="/media/assets/comment.svg" alt="comment" title="comment">
            <span class="element-icon-span">{{::n_comments::}}</span>
        </button>
        
    </div>

    <!-- Comments container -->
    <div class="comments-container">

        <div class="flex flex-end btn-x-container">
            <button class="btn-x">X</button>
        </div>
        
        <div class="flex flex-column comments-list">
            {{::comments::}}
        </div>
        
        <div class="flex flex-around upload-container">
            <input type="text" class="upload-text">
            <button class="upload-btn btn-primary">{{::send::}}</button>
        </div>
    </div>
</div>