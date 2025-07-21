const calendario = document.getElementById("calendario");
const selectorMes = document.getElementById("mes");
let diasEnElMes = 0;
let diasSeleccionados = [];

// Obtén los días ocupados de la base de datos
let diasOcupados = [];
fetch("guardar_reservas.php")
  .then(res => res.json())
  .then(data => {
    diasOcupados = data;
    selectorMes.dispatchEvent(new Event("change")); // Dibujar el calendario al cargar
  });

document.getElementById("Guardar").addEventListener("click", function () {
  diasSeleccionados.forEach(day => {
    console.log(day.textContent);
  });
});

selectorMes.addEventListener("change", () => {
  const mes = parseInt(selectorMes.value);
  const añoActual = new Date().getFullYear();
  
  switch (mes) {
    case 1: case 3: case 5: case 7: case 8: case 10: case 12:
      diasEnElMes = 31;
      break;
    case 4: case 6: case 9: case 11:
      diasEnElMes = 30;
      break;
    case 2:
      diasEnElMes = (añoActual % 4 === 0 && (añoActual % 100 !== 0 || añoActual % 400 === 0)) ? 29 : 28;
      break;
  }

  calendario.innerHTML = "";

  for (let i = 1; i <= diasEnElMes; i++) {
    const dia = document.createElement("div");
    dia.className = "dia disponible";
    dia.textContent = i;

    // Agrega atributos data
    dia.dataset.dia = i;
    dia.dataset.mes = mes;
    dia.dataset.anio = añoActual;

    // Verificar si está ocupado
    const ocupado = diasOcupados.find(d =>
      parseInt(d.dias) === i &&
      parseInt(d.mes) === mes &&
      parseInt(d.anio) === añoActual
    );

    if (ocupado) {
      dia.classList.remove("disponible");
      dia.classList.add("reservado");
    }

    dia.addEventListener("click", () => {
      dia.classList.toggle("disponible");
      dia.classList.toggle("reservado");

      if (dia.classList.contains("reservado")) {
        diasSeleccionados.push(dia);
      } else {
        let index = diasSeleccionados.indexOf(dia);
        if (index > -1) diasSeleccionados.splice(index, 1);
      }
    });

    calendario.appendChild(dia);
  }
});


selectorMes.value = "1";
