<div class="gallery-element">

    <!-- User + delete -->
    <p class="element-user">Usuario</p>

    <!-- Image -->

    <img class="element-image" src="../assets/favicon.png" alt="image">

    <!-- Likes + comments buttons -->
    
    <div class="flex flex-around element-btn-container">
        
        <button class="flex flex-center element-icon-btn">
            <img class="element-icon" src="../assets/like.svg" alt="like">
            <span class="element-icon-span">24</span>
        </button>

        <button class="flex flex-center element-icon-btn">
            <img class="element-icon" src="../assets/comment.svg" alt="comment">
            <span class="element-icon-span">42</span>
        </button>
        
    </div>

    <!-- Comments container -->

    <div class="comments-container show">

        <!-- Button to close comments -->
        <div class="flex flex-end btn-x-container">
            <button class="btn-x">X</button>
        </div>
        
        <!-- List of comments -->
        <div class="flex flex-column comments-list">
            <div>
                <p class="comment-title">Usuario + fecha</p>
                <p class="comment-text">Comentario</p>
            </div>

            <div>
                <p class="comment-title">Usuario + fecha</p>
                <p class="comment-text">Comentario</p>
            </div>
        </div>
        
        <!-- Write a comment -->
        <div class="flex flex-around upload-container">
            <input type="text" id="comment-text" class="upload-text">
            <button id="comment-btn" class="upload-btn btn-primary">
                Enviar
            </button>
        </div>
    </div>

</div>