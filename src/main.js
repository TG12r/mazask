import { laberintos } from './laberintos.js';
import { preguntas } from './preguntas.js';

const maze = document.getElementById('maze');
const objeto = document.getElementById('object');
const preguntaBox = document.getElementById('question-box');
const preguntaElemento = document.getElementById('question');
const respuestaInput = document.getElementById('answer');
const enviarBoton = document.getElementById('submit-answer');
const estadoPausa = document.getElementById('estado-pausa');
const popUpRecord = document.getElementById('guardar-record')
const popUpRecordBtn = document.getElementById('btn-guardar-record')
const popUpContainer = document.getElementById('pop-up-container');
const popUpMessage = document.getElementById('pop-up-message');
const closePopUpButton = document.getElementById('close-pop-up');
const nivelIndicador = document.getElementById('nivel-indicador');
// Variables para el temporizador
const tiempoIndicador = document.getElementById('tiempo-indicador');
let tiempoInicio;
let intervaloTemporizador;

let nivelActual = 0;
let posX = 0;
let posY = 0;
const tamanioCelda = 60;

let laberinto = laberintos[nivelActual];

function dibujarLaberinto() {
    maze.style.width = `${laberinto[0].length * tamanioCelda}px`;
    maze.style.height = `${laberinto.length * tamanioCelda}px`;

    laberinto.forEach((fila, i) => {
        fila.forEach((celda, j) => {
            const celdaDiv = document.createElement('div');
            celdaDiv.style.width = `${tamanioCelda}px`;
            celdaDiv.style.height = `${tamanioCelda}px`;
            celdaDiv.style.position = 'absolute';
            celdaDiv.style.left = `${j * tamanioCelda}px`;
            celdaDiv.style.top = `${i * tamanioCelda}px`;

            if (celda === 1) {
                celdaDiv.classList.add('wall');
            } else if (celda === 3) {
                celdaDiv.classList.add('end');
            }
            maze.appendChild(celdaDiv);
        });
    });

    // Establece la posición inicial del objeto dentro del laberinto
    [posX, posY] = encontrarPosicionInicial();
    actualizarPosicion();
}

function reiniciarNivel() {
    maze.innerHTML = '';
    laberinto = laberintos[nivelActual];
    dibujarLaberinto();
}

function encontrarPosicionInicial() {
    for (let i = 0; i < laberinto.length; i++) {
        for (let j = 0; j < laberinto[i].length; j++) {
            if (laberinto[i][j] === 2) {
                // Ajusta la posición del bloque para que esté centrado en la celda inicial
                return [j * tamanioCelda, i * tamanioCelda];
            }
        }
    }
    return [0, 0];
}

function mostrarPopUp(mensaje) {
    popUpMessage.textContent = mensaje;
    popUpContainer.classList.add('show');
    popUpContainer.classList.remove('hidden');

    closePopUpButton.addEventListener('click', cerrarPopUp, { once: true });
}
function record() {
    popUpRecord.classList.add('show')
    popUpContainer.classList.remove('hidden');

    popUpRecordBtn.addEventListener('click', function(){
        popUpRecord.classList.remove('show')
    popUpContainer.classList.add('hidden');
    }, { once: true });
}
function cerrarPopUp() {
    popUpContainer.classList.remove('show');
    popUpContainer.classList.add('hidden');

    if (popUpMessage.textContent === '¡Has llegado al final!') {
        pasarNivel();
    }else if (popUpMessage.textContent  == '¡Has completado todos los niveles!'){
        record();
    }
}
function actualizarNivel() {
    nivelIndicador.textContent = `Nivel: ${nivelActual + 1}/${laberintos.length}`;
}
function pasarNivel() {
    nivelActual++;
    if (nivelActual < laberintos.length) {
        reiniciarNivel();
        mostrarPopUp('¡Nivel completado! Presiona Cerrar para continuar al siguiente nivel.');
        actualizarNivel();
    } else {
        mostrarPopUp('¡Has completado todos los niveles!');
        detenerTemporizador();
    }
}

function pausarJuego() {
    estadoPausa.classList.remove('hidden');
    objeto.style.pointerEvents = 'none';
    arrastrando = false;
    document.removeEventListener('mousemove', moverObjeto);
}

function activarInmunidad() {
    enInmunidad = true;
    objeto.classList.add('parpadeo');
    
    setTimeout(() => {
        enInmunidad = false;
        objeto.classList.remove('parpadeo');
    }, duracionInmunidad);
}

function reanudarJuego() {
    estadoPausa.classList.add('hidden');
    objeto.style.pointerEvents = 'auto';
}

function mostrarPregunta() {
    const preguntaActual = preguntas[Math.floor(Math.random() * preguntas.length)];
    preguntaElemento.textContent = preguntaActual.pregunta;
    preguntaBox.classList.remove('hidden');
    enviarBoton.onclick = () => {
        const respuesta = respuestaInput.value.trim();
        if (respuesta === preguntaActual.respuesta) {
            preguntaBox.classList.add('hidden');
            respuestaInput.value = '';
            reanudarJuego();
            activarInmunidad();
        } else {
            mostrarPopUp('Respuesta incorrecta. Inténtalo de nuevo.');
        }
    };
}

function verificarPosicion() {
    if (enInmunidad) return;

    const x = Math.floor((posX + objeto.clientWidth / 2) / tamanioCelda);
    const y = Math.floor((posY + objeto.clientHeight / 2) / tamanioCelda);
    const celdaActual = laberinto[y] && laberinto[y][x];

    if (celdaActual === 1) {
        console.log('¡El objeto ha tocado una pared!');
        pausarJuego();
        mostrarPregunta();
    } else if (celdaActual === 3) {
        mostrarPopUp('¡Has llegado al final!');
    }
}

let arrastrando = false;
let desplazamientoX = 0;
let desplazamientoY = 0;
let enInmunidad = false;
const duracionInmunidad = 1000;

objeto.addEventListener('mousedown', (e) => {
    if (!arrastrando) {
        desplazamientoX = e.clientX - objeto.getBoundingClientRect().left;
        desplazamientoY = e.clientY - objeto.getBoundingClientRect().top;
        arrastrando = true;
        document.addEventListener('mousemove', moverObjeto);
        document.addEventListener('mouseup', () => {
            if (arrastrando) {
                arrastrando = false;
                document.removeEventListener('mousemove', moverObjeto);
                verificarPosicion();
            }
        });
    }
});

function moverObjeto(e) {
    if (arrastrando) {
        posX = e.clientX - maze.getBoundingClientRect().left - desplazamientoX;
        posY = e.clientY - maze.getBoundingClientRect().top - desplazamientoY;

        // Limita el movimiento del objeto dentro del laberinto
        if (posX < 0) posX = 0;
        if (posY < 0) posY = 0;
        if (posX > maze.clientWidth - objeto.clientWidth) posX = maze.clientWidth - objeto.clientWidth;
        if (posY > maze.clientHeight - objeto.clientHeight) posY = maze.clientHeight - objeto.clientHeight;

        actualizarPosicion();
        verificarPosicion();
    }
}
// Función para iniciar el temporizador
function iniciarTemporizador() {
    tiempoInicio = Date.now();
    intervaloTemporizador = setInterval(actualizarTemporizador, 1000);
}

// Función para actualizar el temporizador
function actualizarTemporizador() {
    const tiempoTranscurrido = Math.floor((Date.now() - tiempoInicio) / 1000);
    const minutos = Math.floor(tiempoTranscurrido / 60).toString().padStart(2, '0');
    const segundos = (tiempoTranscurrido % 60).toString().padStart(2, '0');
    tiempoIndicador.textContent = `Tiempo: ${minutos}:${segundos}`;
}

// Función para detener el temporizador
function detenerTemporizador() {
    clearInterval(intervaloTemporizador);
}

function actualizarPosicion() {
    objeto.style.position = 'absolute'; // Asegúrate de que el objeto tenga posición absoluta
    objeto.style.left = `${posX}px`;
    objeto.style.top = `${posY}px`;
}
// Inicializa el primer nivel
reiniciarNivel();
actualizarNivel();
iniciarTemporizador();