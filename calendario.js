const calendario = document.getElementById("calendario");
const selectorMes = document.getElementById("mes");
let diasEnElMes = 0;
let diasSeleccionados = [];
let diasNoSeleccionados = [];

// Obtiene los días ocupados de la base de datos
let diasOcupados = [];
fetch("reservas.php")
  .then(res => res.json())
  .then(data => {
    diasOcupados = data;
    selectorMes.dispatchEvent(new Event("change"));
  });

if (!esDueno) {
  document.getElementById("Guardar").style.display = "none";
}else{

  document.getElementById("Guardar").addEventListener("click", function () {

  console.log(esDueno);
  const reservas = diasSeleccionados.map(day => ({
    dias: day.dataset.dia,
    mes: day.dataset.mes,
    anio: day.dataset.anio,
    estado: "reservado"
  }));

  const disponibles = diasNoSeleccionados.map(day =>({
    dias: day.dataset.dia,
    mes: day.dataset.mes,
    anio: day.dataset.anio,
    estado: "disponible"
  }));

  fetch("guardarReservas.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      reservas: reservas,
      disponibles: disponibles
    })
  })
  .then(response => response.text())
  .then(result => {
    alert("Días guardados correctamente");
    diasSeleccionados = [];
    diasNoSeleccionados = [];
    selectorMes.dispatchEvent(new Event("change"));
  })
  .catch(error => {
    console.error("Error al guardar:", error);
    alert("Error al guardar los días");
  });
});

}

selectorMes.addEventListener("change", () => {
  const mes = parseInt(selectorMes.value);
  const añoActual = new Date().getFullYear();
  let index = 0;

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

    dia.dataset.dia = i;
    dia.dataset.mes = mes;
    dia.dataset.anio = añoActual;

    const ocupado = diasOcupados.find(d =>
      parseInt(d.dias) === i &&
      parseInt(d.mes) === mes &&
      parseInt(d.anio) === añoActual
    );

    if (ocupado) {
      dia.classList.remove("disponible");
      dia.classList.add("reservado");
    }

    if (dia.classList.contains("reservado")) {
      diasSeleccionados.push(dia);
      index = diasNoSeleccionados.indexOf(dia);
      if (index > -1) diasNoSeleccionados.splice(index, 1);
    } else {
      diasNoSeleccionados.push(dia);
      index = diasSeleccionados.indexOf(dia);
      if (index > -1) diasSeleccionados.splice(index, 1);
    }

    if (esDueno) {
      dia.addEventListener("click", () => {
        dia.classList.toggle("disponible");
        dia.classList.toggle("reservado");

        if (dia.classList.contains("reservado")) {
          diasSeleccionados.push(dia);
          index = diasNoSeleccionados.indexOf(dia);
          if (index > -1) diasNoSeleccionados.splice(index, 1);
        } else {
          diasNoSeleccionados.push(dia);
          index = diasSeleccionados.indexOf(dia);
          if (index > -1) diasSeleccionados.splice(index, 1);
        }
      });
    }

    calendario.appendChild(dia);
  }
});



selectorMes.value = "1";
