<template>
  <div class="container">
      <h1 class="display-3">DataTable Component</h1>
    <div class="row justify-content-center">
      <div>
        <div class="card">
          <div class="card-body" style="width: 900px;">
            <div class="row" v-if="spinnerDetalle">
              <div class="col-md-12 text-center bg-white">
                <div class="spinner-border" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
            </div>

            <div v-if="!spinnerDetalle && mostrarDetalle">
              <div class="table-responsive">
                  <label><strong>Gestión de Productos</strong></label>
                <table
                  id="productos"
                  class="table table-striped table-bordered table-hover"
                  style="width:100%"
                ></table>
              </div>

              <!-- Modal Editar -->
              <div
                class="modal fade"
                id="editarModal"
                tabindex="-1"
                role="dialog"
                aria-labelledby="editarModalLabel"
                aria-hidden="true"
              >
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editarModalLabel">Producto</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form @submit.prevent="confirmarEditar">
                        <div class="form-group">
                          <label for="InputNombre">Nombre</label>
                          <input
                            type="text"
                            class="form-control"
                            v-model="objetoProducto.nombre"
                            aria-describedby="Nombre Producto"
                            required
                          />
                        </div>

                        <div class="form-group">
                          <label for="InputNombre">Código</label>
                          <input
                            type="text"
                            class="form-control"
                            v-model="objetoProducto.codigo"
                            aria-describedby="Codigo Producto"
                            required
                          />
                        </div>

                        <div class="form-group">
                          <label for="InputNombre">Existencia</label>
                          <input
                            type="text"
                            class="form-control"
                            v-model="objetoProducto.existencia"
                            aria-describedby="Existencia Producto"
                            required
                          />
                        </div>

                        <div class="form-group">
                          <label for="InputNombre">Bodega</label>
                          <input
                            type="text"
                            class="form-control"
                            v-model="objetoProducto.bodega"
                            aria-describedby="Bodega Producto"
                            required
                          />
                        </div>

                        <div class="form-group">
                          <label for="InputNombre">Descripción</label>
                          <input
                            type="text"
                            class="form-control"
                            v-model="objetoProducto.descripcion"
                            aria-describedby="Descripción Producto"
                            required
                          />
                        </div>

                        <div class="form-group">
                          <label for="InputNombre">Estado</label>

                          <select class="form-control" v-model="objetoProducto.estado">
                            <option :selected="true" value>-- Seleccione --</option>
                            <option
                              v-for="(option,index) in estados"
                              v-bind:value="option.id_estado"
                              v-bind:key="index"
                            >{{ option.nombre }}</option>
                          </select>
                        </div>

                        <button type="submit" class="btn btn-success">Actualizar</button>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal Crear producto -->
              <div
                class="modal fade"
                id="crearModal"
                tabindex="-1"
                role="dialog"
                aria-labelledby="crearModalLabel"
                aria-hidden="true"
              >
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="crearModalLabel">Producto</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form @submit.prevent="crearProducto">
                        <div class="form-group">
                          <label for="InputNombre">Nombre</label>
                          <input
                            v-model="objetoProducto.nombre"
                            type="text"
                            class="form-control"
                            aria-describedby="Nombre Producto"
                            required
                          />
                        </div>

                        <div class="form-group">
                          <label for="InputNombre">Código</label>
                          <input
                            v-model="objetoProducto.codigo"
                            type="text"
                            class="form-control"
                            aria-describedby="Codigo Producto"
                            required
                          />
                        </div>

                        <div class="form-group">
                          <label for="InputNombre">Existencia</label>
                          <input
                            v-model="objetoProducto.existencia"
                            type="text"
                            class="form-control"
                            aria-describedby="Existencia Producto"
                            required
                          />
                        </div>

                        <div class="form-group">
                          <label for="InputNombre">Bodega</label>
                          <input
                            v-model="objetoProducto.bodega"
                            type="text"
                            class="form-control"
                            aria-describedby="Bodega Producto"
                            placeholder="Centro"
                            required
                            disabled
                          />
                        </div>

                        <div class="form-group">
                          <label for="InputNombre">Descripción</label>
                          <input
                            v-model="objetoProducto.descripcion"
                            type="text"
                            class="form-control"
                            aria-describedby="Descripción Producto"
                            required
                          />
                        </div>

                        <div class="form-group">
                          <label for="InputNombre">Estado</label>

                          <select name="cars" class="custom-select" v-model="objetoProducto.estado">
                            <option selected>Seleccione un estado</option>
                            <option
                              v-for="(option,index) in estados"
                              v-bind:value="option.id_estado"
                              v-bind:key="index"
                            >{{ option.nombre }}</option>
                          </select>
                        </div>

                        <button type="submit" class="btn btn-success">Guardar</button>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Termina modal crearProducto -->

              <br />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    this.consultarDatos();
    this.consultarEstados();
  },
  mounted() {},
  data() {
    return {
      productos: [],
      mostrarDetalle: false,
      objetoProducto: {
        id_producto: null,
        nombre: null,
        codigo: null,
        existencia: null,
        bodega: null,
        descripcion: null,
        estado: null,
      },
      estados: [],
      spinnerDetalle: false,
      mostrarDetalle: false,
    };
  },
  computed:{
  },
  methods: {
    consultarDatos(param) {
      this.spinnerDetalle = true;
      this.mostrarDetalle = false;

      axios
        .post("productos/consultarDatos", {})
        .then((response) => {
          this.productos = response.data.productos;
          this.spinnerDetalle = false;
          this.mostrarDetalle = true;
        })
        .then((response) => {
          this.imprimirTabla();
        })
        .catch((error) => {});
    },
    consultarEstados(param) {
      this.spinnerDetalle = true;
      this.mostrarDetalle = false;

      axios
        .post("productos/consultarDatos", {})
        .then((response) => {
          this.estados = response.data.estados;
          this.spinnerDetalle = false;
          this.mostrarDetalle = true;
        })
        .catch((error) => {});
    },
    imprimirTabla() {
      var params = this.limpiarCampos;

      var productos = $("#productos").DataTable({
        dom: '<"float-right mb-2"B><"form-inline"f>rtip', //Pfrtip //lftiprB //Bfrtilp
        data: this.productos,
        destroy: true,
        buttons: [
          {
            extend: "excel",
            title: "Productos del sistema - " + new Date(),
            className: "btn btn-secondary mr-2",
          },
          {
            text: "Crear Producto", //'<button class="btn btn-primary">Crear Producto</button>',
            className: "btn btn-primary rounded-left rounded-right",
            action: function () {
              params();
              $("#crearModal").modal("show");
            },
          },
        ],
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"],
        ],
        language: {
          url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },

        ordering: false,

        columnDefs: [
          { searchable: false, targets: [0, 2, 3, 4, 5, 6, 7, 8] }, // Disable search on first and last columns
        ],

        columns: [
          {
            data: "id_producto",
            title: "ID",
            name: "id_producto",
            visible: false,
          },
          {
            data: "nombre",
            title: "Nombre",
            name: "nombre",
          },
          {
            data: "codigo",
            title: "Código",
            name: "codigo",
          },
          {
            data: "existencia",
            title: "Existencia",
            name: "existencia",
          },
          {
            data: "bodega",
            title: "Bodega",
            name: "bodega",
          },
          {
            data: "descripcion",
            title: "Descripción",
            name: "descripcion",
          },
          {
            title: "Editar",
            render: function (data) {
              return "<button type='button' class='btn btn-warning'>Editar</button>";
            },
          },
          {
            data: "estado",
            title: "Estado",
            name: "estado",
          },
          {
            data: "idestado",
            title: "ID Estado",
            name: "idestado",
            visible: false,
          },
        ],
      });

      var varAsignarEstado = this.asignarEstado;

      $("#productos tbody").on("click", "button", function () {
        var data = productos.row($(this).parents("tr")).data();

        varAsignarEstado(data);
      });
    },
    asignarEstado(parametro) {
      //console.log(parametro);
      this.objetoProducto.id_producto = parametro.id_producto;
      this.objetoProducto.nombre = parametro.nombre;
      this.objetoProducto.codigo = parametro.codigo;
      this.objetoProducto.existencia = parametro.existencia;
      this.objetoProducto.bodega = parametro.bodega;
      this.objetoProducto.descripcion = parametro.descripcion;
      this.objetoProducto.estado = parametro.idestado;
      $("#editarModal").modal("show");
    },
    confirmarEditar() {
      Swal.fire({
        html: "¿Realmente desea editar el producto?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.value) {
          this.editarProducto();
        }
      });
    },
    editarProducto() {
      axios
        .post("productos/editarProducto", {
          id_producto: this.objetoProducto.id_producto,
          nombre: this.objetoProducto.nombre,
          codigo: this.objetoProducto.codigo,
          existencia: this.objetoProducto.existencia,
          bodega: this.objetoProducto.bodega,
          descripcion: this.objetoProducto.descripcion,
          estado: this.objetoProducto.estado,
        })
        .then((response) => {
          $("#editarModal").modal("hide");
          return response.data.msg;
        })
        .then((response) => {
          this.consultarDatos();
          return response;
        })
        .then((response) => {
          Swal.fire({
            icon: "success",
            title: response,
          });
        })

        .catch((error) => {});
    },

    crearProducto() {
      axios
        .post("productos/crearProducto", {
          nombre: this.objetoProducto.nombre,
          codigo: this.objetoProducto.codigo,
          existencia: this.objetoProducto.existencia,
          bodega: this.objetoProducto.bodega,
          descripcion: this.objetoProducto.descripcion,
          estado: this.objetoProducto.estado,
        })
        .then((response) => {
          $("#crearModal").modal("hide");
          return response.data.msg;
        })
        .then((response) => {
          this.consultarDatos();
          return response;
        })
        .then((response) => {
          Swal.fire({
            icon: "success",
            title: response,
          });
        })
        .catch((error) => {});
    },

    limpiarCampos() {
      this.objetoProducto.id_producto = null;
      this.objetoProducto.nombre = null;
      this.objetoProducto.codigo = null;
      this.objetoProducto.existencia = null;
      this.objetoProducto.bodega = null;
      this.objetoProducto.descripcion = null;
      this.objetoProducto.estado = null;
    },
  },
};
</script>
