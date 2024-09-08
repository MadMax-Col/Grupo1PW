document.getElementById('cuentoForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

    // Captura los valores ingresados
    const nombres = document.getElementById('nombres').value;
    const apodo = document.getElementById('apodo').value;
    const colorCabello = document.getElementById('colorCabello').value;
    const colorOjos = document.getElementById('colorOjos').value;
    const edad = document.getElementById('edad').value;
    const hobby = document.getElementById('hobby').value;

    // Genera el cuento
    const cuento = `${nombres}, conocido cariñosamente por sus amigos como "${apodo}", tenía un cabello de color ${colorCabello} que siempre llamaba la atención, y unos ojos ${colorOjos} que parecían esconder secretos. 
    A sus ${edad} años, ${nombres} era una persona apasionada por ${hobby}. Un día, mientras practicaba su hobby, encontró un antiguo y polvoriento libro que hablaba de un tesoro oculto.

    Intrigado, ${nombres} decidió seguir las pistas del libro, y sin dudarlo, emprendió un viaje lleno de desafíos. En su travesía, se encontró con criaturas mágicas y lugares increíbles. 
    Cada paso que daba lo acercaba más a descubrir un mundo que jamás había imaginado. Y aunque el camino estaba lleno de peligros, su espíritu aventurero y su amor por ${hobby} le dieron la fuerza para continuar.

    Al final, ${nombres} aprendió que el verdadero tesoro no era lo que estaba buscando, sino las experiencias y amistades que hizo en el camino.`;
    // Muestra el cuento en la página
    document.getElementById('cuento').innerText = cuento;
});