<template>
  <div class="container">
    <div class="row justify-content-center">
      <div>
        <div class="card">
          <div class="card-body" style="width: 1080px;background-color: #F6F6F6;">
            <div>
              <div>
                <strong>Gestión de Productos - Filtro de Buscador</strong>
                <Button
                  color="#638695"
                  style="float: right;background-color: #06C4BD;color: white;"
                  shape="circle"
                >Crear producto</Button>
              </div>
              <br />

              <div>
                <label>Nombre del producto</label>
                <Input
                  type="text"
                  @on-enter="filtro"
                  v-model="filtro_nombre"
                  @on-search="filtro"
                  placeholder="Ingrese su busqueda..."
                  style="width: 200px"
                />
                <Button
                  @click="filtro"
                  color="#638695"
                  style="background-color: #6DAEC7;color: white;"
                >Buscar</Button>
                <CheckboxGroup style="float: right;">
                  <Checkbox label="Mostrar todos">Mostrar todos</Checkbox>
                  <Checkbox label="Activos" v-model="filterActivos" v-bind="productos">
                    <span>Activos</span>
                  </Checkbox>
                  <Checkbox label="Inactivos" v-model="filterInactivos">
                    <span>Inactivos</span>
                  </Checkbox>
                  <Checkbox label="Pendiente" v-model="filterPendiente">
                    <span>Pendiente</span>
                  </Checkbox>
                </CheckboxGroup>
              </div>

              <Table stripe :loading="loading" :columns="column" :data="mostrarActivos">
                <template slot-scope="{ row }" slot="nombre">
                  <Icon type="md-checkmark-circle" style="width: 30px;" size="24" color="#06C4BD" />
                  {{ row.nombre }}
                </template>
                <template slot-scope="{ index }" slot="action">
                  <Icon type="md-create" color="#638695" size="24" @click="show(index)" />
                  <!-- <Button type="error" size="small" @click="remove(index)">Delete</Button> -->
                </template>

                <template slot-scope="{ row }" slot="estado" style="width: 30px;">
                  <p style="background-color:#00CF00;">{{row.estado}}</p>
                </template>
              </Table>

              <p
                style="background-color: #017AAF;color: white;"
              >Un producto registrado.[productos activos:] - [Productos pendientes por activar:0] - [productos inactivos:0]</p>
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
  <!-- </div> -->
</template>

<script>
import ProductoService from "../services/ProductoService";

export default {
  created() {
    this.ProductoService = new ProductoService();
  },
  mounted() {
    this.loading = true;
    this.ProductoService.getProductos().then(
      (productos) => (
        (this.productos = productos), (this.productosbuscar = this.productos)
      )
    );

    this.loading = false;
  },
  data() {
    return {
      loading: false,
      column: [
        {
          title: "Nombre del producto",
          key: "nombre",
          slot: "nombre",
          width: 200,
        },
        {
          title: "Código",
          key: "codigo",
        },
        {
          title: "Existencia",
          key: "existencia",
          align: "center",
          width: 150,
        },
        {
          title: "Bodega",
          key: "bodega",
        },
        {
          title: "Descripción",
          key: "descripcion",
          width: 150,
        },
        {
          title: "Editar",
          slot: "action",
          align: "center",
        },
        {
          title: "Estado",
          key: "estado",
          align: "center",
          slot: "estado",
        },
      ],
      productosbuscar: [],
      productos: [],
      filterActivos: false,
      filterInactivos: false,
      filterPendiente: false,
      filtro_nombre: null,
      objetoProducto: {
        id_producto: null,
        nombre: null,
        codigo: null,
        existencia: null,
        bodega: null,
        descripcion: null,
        id_estado: null,
        estado: null,
      },
      estados: [],
    };
  },
  computed: {
    mostrarActivos() {
      if (this.filterActivos == true) {
        return this.productos.filter((producto) => (producto.id_estado == 1));
      } if (this.filterInactivos == true) {
          return this.productos.filter((producto) => (producto.id_estado == 2));
      }if (this.filterPendiente == true) {
          return this.productos.filter((producto) => (producto.id_estado == 3));
      }else {
        return this.productos;
      }
    },
  },
  methods: {
    show(index) {
      this.$Modal.info({
        title: "Producto",
        content: `Nombre：${this.productos[index].nombre}<br>Código：${this.productos[index].codigo}<br>Existencia：${this.productos[index].existencia}<br>Bodega：${this.productos[index].bodega}<br>Descripción：${this.productos[index].descripcion}<br>Estado:${this.productos[index].id_estado}`,
      });
    },
    // remove(index) {
    //   this.productos.splice(index, 1);
    // },
    filtro() {
      if (this.filtro_nombre === "") {
        this.productos = this.productosbuscar;
      } else {
        this.productos = this.productosbuscar;
        this.productos = this.productos.filter((producto) => {
          return (
            producto.nombre.toLowerCase() === this.filtro_nombre.toLowerCase()
          );
        });
      }
    },
    consultarEstados(param) {
      axios
        .post("productos/consultarDatos", {})
        .then((response) => {
          this.estados = response.data.estados;
        })
        .catch((error) => {});
    },
    asignarEstado(parametro) {
      this.objetoProducto.id_producto = parametro.id_producto;
      this.objetoProducto.nombre = parametro.nombre;
      this.objetoProducto.codigo = parametro.codigo;
      this.objetoProducto.existencia = parametro.existencia;
      this.objetoProducto.bodega = parametro.bodega;
      this.objetoProducto.descripcion = parametro.descripcion;
      this.objetoProducto.id_estado = parametro.id_estado;
      $("#editarModal").modal("show");
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
          id_estado: this.objetoProducto.id_estado,
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
          id_estado: this.objetoProducto.id_estado,
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
      this.objetoProducto.id_estado = null;
    },
  },
};
</script>

<style>
.ivu-table th {
  background-color: #017aaf;
  color: white;
}
.ivu-table-wrapper {
  margin-top: 10px;
}
</style>


