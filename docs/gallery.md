# Gallery

## Estructura

La galeria estara dividida mediante un indice. Cada parte tendra hasta 6 imagenes que estaran en orden de creacion (de imagen mas nueva a mas vieja)

Indice formato:

Paginas:

- 1: Sin indice

- 2-5: 

< | 1 | [2] | 3 | 4 | 5 | >

- >5: Mostrar siempre 9 espacios contando <>

< | 1 | 2 | [3] | [4] | ... | 87 | >
< | 1 | ... | 31 | [32] | 33 | ... | 87 | >
< | 1 | ... | 31 | [32] | 33 | [86] | 87 | >

En caso de estar conectado las imagenes tendran un boton para likes y uno para comentar.

El boton de likes sera como un booleano, si un usuario le da like a una imagen, se enviara al servidor y guardara la información, en cuando al fontend el boton de likes cambiara de color marcando que ya le ha dado like a esa imagen. Si el boton de likes esta encendido y lo vuelves a pulsar, el color volvera a la normalidad y el servidor borrara la informacion de tu like en la bd.

El boton de comentario habrira los comentarios, ahi puedes crear un comentario y ver los comentarios de las otras presonas. Un comentario tendra un maximo de 200 caracters y solo podras escribir texto.

En caso de crear un comentario, el usuario que subio la foto recibira un correo con una notificación de que le han dado like a su imagen.
El usuario podra apagar estas notificaciones para que cuando le comenten una de sus imagenes no se le envie ningun correo.