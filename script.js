window.onload = function () {
  // Obtiene las referencias a los elementos del DOM que se usarán en el script
  const formInicio = document.getElementById("formInicio");
  const formRegistro = document.getElementById("formRegistro");
  const buttons = document.querySelectorAll(".btn-info"); // Botones con clase 'btn-info' para mostrar detalles del coche
  const btnMostrarFiltros = document.getElementById("mostrar-filtros");
  const filtros = document.getElementById("filtros");

  // Evento para mostrar el formulario de registro
  if (formInicio && formRegistro) {
    formInicio.addEventListener("click", mostrarLogin);
    formRegistro.addEventListener("click", mostrarRegistro);
  }

  // Función que muestra el formulario de registro y oculta el de inicio de sesión
  function mostrarRegistro() {
    document.getElementById("registro").removeAttribute("hidden");
    document.getElementById("login").setAttribute("hidden", true);
  }

  // Función que muestra el formulario de inicio de sesión y oculta el de registro
  function mostrarLogin() {
    document.getElementById("login").removeAttribute("hidden");
    document.getElementById("registro").setAttribute("hidden", true);
  }

  // Si hay botones con la clase 'btn-info', se añade un evento a cada uno para mostrar los detalles del coche
  if (buttons.length > 0) {
    buttons.forEach((button) => {
      button.addEventListener("click", function () {
        const carId = this.getAttribute("data-id"); // Obtiene el ID del coche desde el atributo 'data-id'
        fetch("obtenercoche.php?id=" + carId) // Realiza una solicitud para obtener los detalles del coche
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              // Si la solicitud fue exitosa, muestra los detalles del coche en el modal
              const carDetails = `
                <strong>Marca:</strong> ${data.coche.marca}<br>
                <strong>Modelo:</strong> ${data.coche.modelo}<br>
                <strong>Año:</strong> ${data.coche.año}<br>
                <strong>Precio:</strong> €${data.coche.precio}<br>
                <strong>Motor:</strong> ${data.coche.motor}<br>
                <strong>Potencia:</strong> ${data.coche.potencia}<br>
                <strong>Velocidad Máxima:</strong> ${data.coche.velocidad_maxima}<br>
                <strong>Aceleración:</strong> ${data.coche.aceleracion}
              `;
              document.getElementById("car-details").innerHTML = carDetails; // Inserta los detalles en el modal

              // Muestra el modal de Bootstrap
              const modal = new bootstrap.Modal(
                document.getElementById("carModal"),
                {
                  backdrop: "true",
                  keyboard: true,
                }
              );
              modal.show(); // Muestra el modal con los detalles del coche
            }
          })
          .catch((error) => console.error("Error:", error)); // Manejo de errores
      });
    });
  }

  // Manejo de los botones de "Me gusta" y "En favoritos"
  document.querySelectorAll(".like-btn").forEach((button) => {
    if (button.classList.contains("liked")) {
      button.textContent = "En favoritos"; // Cambia el texto si el coche ya está en favoritos
    }
    button.addEventListener("click", () => {
      const cocheId = button.dataset.cocheId; // Obtiene el ID del coche
      const action = button.classList.contains("liked") ? "remove" : "add"; // Determina la acción (agregar o quitar de favoritos)

      fetch("addfavoritos.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `coche_id=${cocheId}&action=${action}`, // Envía la solicitud para agregar o eliminar el coche de favoritos
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            button.classList.toggle("liked"); // Cambia la clase para reflejar el estado de favorito
            button.textContent = button.classList.contains("liked")
              ? "En favoritos" // Si está en favoritos, cambia el texto
              : "Me gusta"; // Si no está en favoritos, muestra "Me gusta"
          } else {
            alert(data.message || "Error al procesar la solicitud."); // Muestra un mensaje de error si no se pudo procesar
          }
        })
        .catch((error) => {
          console.error("Error en la solicitud:", error);
          alert("Error al procesar la solicitud."); // Muestra un error en caso de fallo en la solicitud
        });
    });
  });

  // Filtros: Muestra u oculta los filtros al hacer clic en el botón
  if (btnMostrarFiltros) {
    btnMostrarFiltros.addEventListener("click", function () {
      // Alterna la visibilidad de los filtros
      if (filtros.style.display === "none" || filtros.style.display === "") {
        filtros.style.display = "block";
      } else {
        filtros.style.display = "none";
      }
    });
  }

  // Manejo de la eliminación de coches de favoritos
  document.querySelectorAll(".eliminar-favorito").forEach((button) => {
    button.addEventListener("click", () => {
      const cocheId = button.dataset.id; // Obtiene el ID del coche a eliminar

      fetch("eliminarfavorito.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: cocheId }), // Envía la solicitud para eliminar el coche de favoritos
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            button.closest(".col-md-4").remove(); // Elimina el coche de la lista visualmente

            // Muestra un mensaje de confirmación de eliminación
            const mensaje = document.createElement("div");
            mensaje.classList.add("mensaje-confirmacion");
            mensaje.innerText = "Coche eliminado de favoritos";
            document.body.appendChild(mensaje);

            // Elimina el mensaje de confirmación después de 2 segundos
            setTimeout(() => {
              mensaje.remove();
            }, 2000);
          } else {
            alert("Error: " + (data.message || "No se pudo eliminar.")); // Muestra un mensaje de error si no se pudo eliminar
          }
        })
        .catch((error) => {
          console.error("Error en la solicitud:", error);
          alert("Error al procesar la solicitud."); // Muestra un error en caso de fallo en la solicitud
        });
    });
  });
};
