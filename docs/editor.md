# Editor

## Estructura Html

<main>
    <article></article>
    <section></section>
    <form></form>
</main>
<aside></aside>

En el article estara la lista de stickers disponibles que podras poner en la imagen.
En el section estara el programa de la camara, que estara formado por un video, un v¡canvas, una img donde se mostrara la imagen final, los botones y un form encargado de modificar los stickers.
Por ultimo el aside mostrara los previews de las imagenes subidas por el usuario.

Habra 3 botones:
- Izquierda: Se encarga de ir al estado anterior de la camara
- Centro: Se encarga de ir al siguiente estado de la camara
- Derecha: Se encarga de subir y descargar imagenes

Los 3 botones no tendran texto tendran una imagen que podra ir cambiando dependiendo del estado en el que se encuentren.

## Funcionamiento

El frontend definira el funcionamiento de la camara y el backend se encargara del manejo de las imagenes.

### Frontend

La camara tendra 4 estados:

- Inicial

Este sera el estado inical de la camara, tendra activados la lista de stickers, la camara y las previews. En cuanto a los botones solo se vera el boton central, además estara desactivado.

Solo podras ir al siguiente estado cuando selecciones algun sticker de la lista de stickers.

- Manejo de stickers

Este sera el estado de manejo de stickers, tendra activados la lista de stickers, la camara y el formulario de modificacion de stickers. En cuanto a los botones se veran el boton izquierdo y el boton central estara activado.

El modificador de stickers tendra el siguiente formato:

- El nombre del input
- Un boton para cerrar el modificador
- Un input range para escalar el sticker
- Un input range para rotar el sticker
- Un boton para resetear el sticker
- Un boton para eliminar al sticker

En caso de cerrar el modificador, se volveran a mostrar las previews, para volver a abrir el modificador puedes seleccionar un nuevo sticker de la lista de stickers o seleccionar un sticker de la camara.

Puedes arrastrar los stickers por la pantalla de la camara para moverlos de posicion. El sticker no podra salirse de la pantalla 

Si le das al boton izquierdo todos los stickers de la camara seran eliminados y volveras al estado inicial.

Si le das al boton central iras al siguiente estado.

- Tomar foto

Este sera el estado donde tomaras la foto o subiras un archivo de tu dispositivo. La lista de stickers, el modificador y las previews no se veran por pantalla. Además ya no podras modificar los stickers. En cuanto a los botones estaran los 3.

Si le das al boton izquierdo volveras al estado anterior y los stickers estaran donde los dejaste.

Si le das al boton central haras una foto y la mandaras al backend, luego iras al siguiente estado.

Si le das al boton de la derecha podras subir una imagen de tu dispositivo y la mandaras al backend, luego iras al siguiente estado.

En caso de que el backend de error te mantendras en el mismo estado y podras volver a hacer/subir una foto.

- Foto final

En este estado solo se veran la imagen final y los 3 botones.

La imagen sera la imagen recibida del backend.

El boton de la izquierda te mandara al anterior estado y mantendra los stickers que tenias con sus modificaciones.

El boton central subira la imagen al servidor y te llevara al estado inicial.

El boton de la derecha descargara la imagen y seguiras en el mismo estado donde podras volver a descargar la imagen, subirla o volver al estado anterior.

### Backend

El backend de la edicion tendra dos funciones: juntar imagenes y subirlas al servidor.

## Merge

Aqui el servidor recibira un fetch con la imagen y un json con los datos de todos los stickers.

Para la imagen se llamara a una funcion auxiliar que comprobara si la imagen es una imagen permitida (png, jpg, gif) o si no es una imagen. Si falla no se harra la fusion y devolvera error.

Para los stickers se llamara a otra funcion que ira recogiendo los stickers de donde esten guardados. 
- Warning: En caso de que un sticker no se pueda conseguir, se eliminara de la lista de stickers enviados, mandara un warning y pasara con el siguiente sticker.
- Error: En caso de que no haya stickers devolvera un error.

Por ultimo se fusionaran la imagen con los stickers y lo devolvera al frontend como un PNG.

## Upload

Aqui el servidor recibira un fetch con la informacion de la imagen final, creara la imagen y la subira al servidor.

La imagen sera un PNG y se guardara en public/media/uploads/hash_usuario/