<style>
    /* Contenedor general */
    .container-tiempo {
        /* width: 100px; */
        display: flex;
        /* margin-top: 30px; */
        align-items: center;
        position: relative;
        font-family: Arial, sans-serif;
        /* position: fixed; */
        z-index: 1000;
    }

    /* Contenedor del tiempo */
    .tiempo-container {
        
        display: flex;
        align-items: center;
        background-color: #ffd930;
        padding: 5px 10px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: absolute;
        z-index: 1;
        top: 18%;
        transform: translateY(-60%);
        opacity: 1;
        visibility: hidden;
        width: auto;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .tiempo-container.show {
        opacity: 1;
        visibility: visible;
        transform: translateX(0);
    }

    .tiempo-container.hidden {
        transform: translateX(40px);
    }

    .tiempo {
        margin-left: 10px;
        font-size: 1rem;
        font-weight: bold;
        color: #333;
        margin-right: 10px;
    }

    .minutos {
        font-size: 1rem;
        color: #666;
    }

    .reloj {
        
        position: relative;
        z-index: 2;
    }

    .reloj-btn {
        /* width: 70px; */
        width: 50px;
        height: 50px;
        border-radius: 50%;
        /* background-color: #4CAF50; */
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .reloj-btn:hover {
        background-color: #ffd930;
    }

    .reloj-btn.disabled {
        cursor: not-allowed;
        background-color: #ffd930;
    }

    .reloj-btn img {

        margin-top: -11px;
        width: 50px;
        /* Ajusta el tamaño de la imagen según lo necesites */
        height: 50px;
        /* Ajusta el tamaño de la imagen según lo necesites */
    }
</style>

<div class="container-tiempo">
    <div class="reloj">
        <button class="reloj-btn" type="button" id="toggleButton" onclick="toggleTime()">
            <img src="https://bibliotecacoopsemularchivos.s3.amazonaws.com/assets/alarma.png" alt="Ícono de alarma">
        </button>
    </div>
    <div class="tiempo-container hidden">
        <div class="tiempo"> {{ $tiempo }}</div>
        <div class="minutos">min.</div>
    </div>
</div>

<!-- Elemento de audio -->
<audio id="alertaSound" src="https://bibliotecacoopsemularchivos.s3.amazonaws.com/assets/alerta.mp3"
    preload="auto"></audio>
