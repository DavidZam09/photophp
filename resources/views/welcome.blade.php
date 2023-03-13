<!DOCTYPE html:5>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PHOTO COLLECTOR - PHP</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <style>
        #cam {
            display: flex;
            flex-direction: column;
            align-items: left;
        }

        #camps {
            display: flex;
            flex-direction: column;
            align-items: right;
        }
    </style>

</head>

<body>
    <?php include("top_menu.php"); ?>

    <div class="container" style="margin-top: 50px;">
        <h1 class="text-center">PhotoCollector</h1>
        <div class="col-md-6" id="cam">
            <video muted="muted" id="video"></video>
            <canvas id="canvas" style="display: none;"></canvas>
            <button class="btn btn-success" id="boton">Capturar</button>
        </div>
        <form method="POST" action="../models/insert.php">
            <div class="row" id="camps">
                <div class="col-md-6">
                    <select name="listaDeDispositivos" id="listaDeDispositivos"></select>
                    <div>
                        <br />
                        <input type="text" placeholder="CLIENTE" name="client">
                        <br />
                        <input type="text" placeholder="PRECINTO" name="presinto">
                        <br />
                        <input type="date" name="date">
                    </div>
                    <p id="estado"></p>
                    <div id="results">

                    </div>
                </div>

                <div class="col-md-12">
                    <br />
                    <button class="btn btn-success" id="snapshot">Guardar</button>
                </div>
            </div>
        </form>

    </div>
    <?php include("footer.php"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
<script language="JavaScript">
    const tieneSoporteUserMedia = () =>
        !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia)
    const _getUserMedia = (...arguments) =>
        (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);

    // Declaramos elementos del DOM
    const $video = document.querySelector("#video"),
        $canvas = document.querySelector("#canvas"),
        $estado = document.querySelector("#estado"),
        $boton = document.querySelector("#boton"),
        $results = document.querySelector("#results"),
        $botonSnapshot = document.querySelector("#snapshot"),
        $snapShot = "",
        $listaDeDispositivos = document.querySelector("#listaDeDispositivos");

    let foto = "";
    const limpiarSelect = () => {
        for (let x = $listaDeDispositivos.options.length - 1; x >= 0; x--)
            $listaDeDispositivos.remove(x);
    };
    const obtenerDispositivos = () => navigator
        .mediaDevices
        .enumerateDevices();

    // La función que es llamada después de que ya se dieron los permisos
    // Lo que hace es llenar el select con los dispositivos obtenidos
    const llenarSelectConDispositivosDisponibles = () => {

        limpiarSelect();
        obtenerDispositivos()
            .then(dispositivos => {
                const dispositivosDeVideo = [];
                dispositivos.forEach(dispositivo => {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                if (dispositivosDeVideo.length > 0) {
                    // Llenar el select
                    dispositivosDeVideo.forEach(dispositivo => {
                        const option = document.createElement('option');
                        option.value = dispositivo.deviceId;
                        option.text = dispositivo.label;
                        $listaDeDispositivos.appendChild(option);
                    });
                }
            });
    }

    (function() {
        // Comenzamos viendo si tiene soporte, si no, nos detenemos
        if (!tieneSoporteUserMedia()) {
            alert("Lo siento. Tu navegador no soporta esta característica");
            $estado.innerHTML = "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
            return;
        }
        //Aquí guardaremos el stream globalmente
        let stream;




        obtenerDispositivos()
            .then(dispositivos => {
                // Vamos a filtrarlos y guardar aquí los de vídeo
                const dispositivosDeVideo = [];

                // Recorrer y filtrar
                dispositivos.forEach(function(dispositivo) {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                // y le pasamos el id de dispositivo
                if (dispositivosDeVideo.length > 0) {
                    // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                    mostrarStream(dispositivosDeVideo[0].deviceId);
                }
            });



        const mostrarStream = idDeDispositivo => {
            _getUserMedia({
                    video: {
                        // Justo aquí indicamos cuál dispositivo usar
                        deviceId: idDeDispositivo,
                    }
                },
                (streamObtenido) => {
                    // Aquí ya tenemos permisos, ahora sí llenamos el select,
                    // pues si no, no nos daría el nombre de los dispositivos
                    llenarSelectConDispositivosDisponibles();

                    // Escuchar cuando seleccionen otra opción y entonces llamar a esta función
                    $listaDeDispositivos.onchange = () => {
                        // Detener el stream
                        if (stream) {
                            stream.getTracks().forEach(function(track) {
                                track.stop();
                            });
                        }
                        // Mostrar el nuevo stream con el dispositivo seleccionado
                        mostrarStream($listaDeDispositivos.value);
                    }

                    // Simple asignación
                    stream = streamObtenido;

                    // Mandamos el stream de la cámara al elemento de vídeo
                    $video.srcObject = stream;
                    $video.play();

                    //Escuchar el click del botón para tomar la foto
                    //Escuchar el click del botón para tomar la foto
                    $boton.addEventListener("click", function() {

                        //Pausar reproducción
                        $video.pause();

                        //Obtener contexto del canvas y dibujar sobre él
                        let contexto = $canvas.getContext("2d");
                        $canvas.width = $video.videoWidth;
                        $canvas.height = $video.videoHeight;
                        contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

                        foto = $canvas.toDataURL(); //Esta es la foto, en base 64

                        $estado.innerHTML = "Enviando foto. Por favor, espera...";
                        $estado.innerHTML = "<img src='" + foto + "' />";

                        $results.innerHTML = "<input type='hidden' name='img' id='img' value='" + foto + "' />";

                        $video.play();

                    });
                }, (error) => {
                    console.log("Permiso denegado o error: ", error);
                    $estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
                });

            $botonSnapshot.addEventListener('click', function() {
                /*fetch("./insert.php", {
                        method: "POST",
                        body: encodeURIComponent(foto),
                        headers: {
                            "Content-type": "application/x-www-form-urlencoded",
                        }
                    })
                    .then(resultado => {
                        // A los datos los decodificamos como texto plano
                        return resultado.text()
                    })
                    .then(idFoto => {

                        console.log("La foto fue enviada correctamente");
                        $estado.innerHTML = `Foto guardada con éxito. Puedes verla <a target='_blank' href='./search.php?id=${idFoto}'> aquí</a>`;

                    })*/
                $video.play();
            });
        }
    })();
</script>
<?php

?>
</body>

</html>
