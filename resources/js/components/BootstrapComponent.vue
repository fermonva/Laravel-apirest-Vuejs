<template>
  <div class="container">
    <h1 class="display-3">BootStrap Component</h1>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          <strong>Gestion de Productos</strong>
          <button
            type="button"
            class="btn btn-primary btn-sm rounded-pill float-right"
          >Crear producto</button>
        </h5>

        <div class="form overflow-hidden full-width">
          <div class="form-group form-inline float-left">
            <label for>Nombre del producto</label>
            <input class="m-2" type="text" />
            <button type="button" class="btn btn-info btn-sm">Buscar</button>
          </div>

          <div class="form-check-inline float-right pt-3">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" />
            <label class="form-check-label" for="inlineCheckbox1">Mostrar todos</label>
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" />
            <label class="form-check-label" for="inlineCheckbox1">Activos</label>
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" />
            <label class="form-check-label" for="inlineCheckbox1">Inactivos</label>
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" />
            <label class="form-check-label" for="inlineCheckbox1">Pendiente</label>
          </div>
        </div>

        <table class="table table-striped">
          <thead>
            <tr class="columns">
              <th scope="col">First</th>
              <th scope="col">Last</th>
              <th scope="col">Handle</th>
              <th scope="col">First</th>
              <th scope="col">Last</th>
              <th scope="col">Handle</th>
              <th scope="col">First</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
              <td>Mark</td>
              <td>Otto</td>
              <td class="text-center">
                <svg
                  width="1em"
                  height="1em"
                  viewBox="0 0 16 16"
                  class="bi bi-pencil"
                  fill="#06C4BD"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"
                  />
                  <path
                    fill-rule="evenodd"
                    d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"
                  />
                </svg>
              </td>
              <td>Mark</td>
            </tr>
            <tr>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
              <td>Mark</td>
              <td>Otto</td>
              <td class="text-center">
                <svg
                  width="1em"
                  height="1em"
                  viewBox="0 0 16 16"
                  class="bi bi-pencil"
                  fill="#06C4BD"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"
                  />
                  <path
                    fill-rule="evenodd"
                    d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"
                  />
                </svg>
              </td>
              <td>Mark</td>
            </tr>
          </tbody>
        </table>
        <p
          style="background-color: #017AAF;color: white;"
        >Un producto registrado.[productos activos:] - [Productos pendientes por activar:0] - [productos inactivos:0]</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>
<style>
.btn-info {
  color: white;
  background-color: #6daec7;
}

.btn-primary {
  color: white;
  background-color: #06c4bd;
}

.card-body {
  background-color: #f6f6f6;
}

.columns {
  background-color: #017aaf;
  color: white;
}
.fondo {
  background-color: #c9c9c9;
}
</style>
