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


</head>

<body>
    <?php include("top_menu.php"); ?>

    <div class="container" style="margin-top: 50px;">
        <h1 class="text-center">PhotoCollector</h1>
        <div class="row">
            <div class="col-md-6">
                <select name="listaDeDispositivos" id="listaDeDispositivos"></select>
                <div>
                    <br />
                    <input type="text" value="Cliente" name="client">
                    <br />
                    <input type="text" value="Presinto" name="presinto">
                    <br />
                    <input type="date" value="Fecha" name="date">
                </div>
                <p id="estado"></p>
                <div id="results">

                </div>
            </div>
            <div class="col-md-6">
                <video muted="muted" id="video"></video>
                
                <canvas id="canvas" style="display: none;"></canvas>
                <button class="btn btn-success" onClick="take_snapshot()">Tomar foto</button>
            </div>
            <div class="col-md-12">
                <br />
                <button class="btn btn-success" id="boton">Guardar</button>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
<!--
<!DOCTYPE html>
<html lang="es">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Tomar foto </title>
    <style>
        @media only screen and (max-width: 700px) {
            video {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <h1>Tomando foto</h1>

    <h1>Selecciona un dispositivo</h1>
    <div>
        <select name="listaDeDispositivos" id="listaDeDispositivos"></select>
        <button id="boton">Tomar foto</button>
        <p id="estado"></p>
    </div>
    <br>
    <video muted="muted" id="video"></video>
    <canvas id="canvas" style="display: none;"></canvas>
</body>

</html>
 -->
<script language="JavaScript">
    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'png',
        jpeg_quality: 90
    });

    Webcam.attach('#video');

    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
        });
    }
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
        $listaDeDispositivos = document.querySelector("#listaDeDispositivos");


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




        // Comenzamos pidiendo los dispositivos
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

                        let foto = $canvas.toDataURL(); //Esta es la foto, en base 64
                        $estado.innerHTML = "Enviando foto. Por favor, espera...";
                        fetch("./insert.php", {
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
                                // idFoto trae el id de la foto
                                console.log("La foto fue enviada correctamente");
                                $estado.innerHTML = `Foto guardada con éxito. Puedes verla <a target='_blank' href='./search.php?id=${idFoto}'> aquí</a>`;




                            })

                        //Reanudar reproducción
                        $video.play();
                    });
                }, (error) => {
                    console.log("Permiso denegado o error: ", error);
                    $estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
                });
        }
    })();
</script>

</body>

</html>