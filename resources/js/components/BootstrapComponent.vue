<template>
  <div class="container">
    <h1 class="display-3">Bootstrap Component</h1>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">
          <strong>Gestion de Productos</strong>
          <button
            type="button"
            class="btn btn-primary rounded-pill float-right"
            @click="crearNuevo()"
          >Crear producto</button>
        </h5>

        <div class="form overflow-hidden full-width">
          <div class="form-group form-inline float-left">
            <label for>Nombre del producto</label>
            <input
              class="form-control m-2"
              type="text"
              v-on:keyup.enter="filtroBuscar"
              v-model="filtro_nombre"
              placeholder="Ingrese su busqueda..."
            />
            <button type="button" class="btn btn-info" v-on:click="filtroBuscar">Buscar</button>
          </div>

          <div class="form-check-inline float-right pt-3">
            <input class="form-check-input" type="checkbox" v-model="filterActivos" />
            <label class="form-check-label">Activos</label>
            <input class="form-check-input" type="checkbox" v-model="filterInactivos" />
            <label class="form-check-label">Inactivos</label>
            <input class="form-check-input" type="checkbox" v-model="filterPendiente" />
            <label class="form-check-label">Pendiente</label>
          </div>
        </div>

        <table class="table table-striped">
          <thead>
            <tr class="columns">
              <th scope="col">Nombre del producto</th>
              <th scope="col">Código</th>
              <th scope="col">Existencia</th>
              <th scope="col">Bodega</th>
              <th scope="col">Descripción</th>
              <th scope="col">Editar</th>
              <th scope="col">Estado</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="producto in filtrosCheck" :key="producto.id_producto">
              <td>{{ producto.nombre }}</td>
              <td>{{ producto.codigo }}</td>
              <td>{{ producto.existencia }}</td>
              <td>{{ producto.bodega }}</td>
              <td>{{ producto.descripcion }}</td>
              <td>
                <button @click="editProducto(producto)">
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
                </button>
              </td>
              <td>{{ producto.estado }}</td>
            </tr>
          </tbody>
        </table>
        <p
          style="background-color: #017AAF;color: white;"
        >Un producto registrado.[productos activos: {{contarActivos}}] - [Productos pendientes por activar: {{contarPendientes}}] - [productos inactivos: {{contarInactivos}}]</p>
      </div>
    </div>

    <!-- Modal -->

    <div v-if="showModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{modalTitle}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" @click="showModal = false">&times;</span>
                  </button>
                </div>
                <div class="modal-body form-group">
                  <label for>Nombre</label>
                  <input type="text" class="form-control m-2" v-model.trim="objetoProducto.nombre" />
                  <label for>Código</label>
                  <input type="text" class="form-control m-2" v-model.trim="objetoProducto.codigo" />
                  <label for>Existencia</label>
                  <input
                    type="text"
                    class="form-control m-2"
                    v-model.trim="objetoProducto.existencia"
                  />
                  <label for>Bodega</label>
                  <input type="text" class="form-control m-2" v-model.trim="objetoProducto.bodega" />
                  <label for>Descripción</label>
                  <input
                    type="text"
                    class="form-control m-2"
                    v-model.trim="objetoProducto.descripcion"
                  />

                  <label for>Estado</label>
                  <select class="custom-select m-2" v-model="objetoProducto.id_estado">
                    <option
                      v-for="option in estados"
                      :value="option.id_estado"
                      :key="option.id_estado"
                    >{{ option.nombre }}</option>
                  </select>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="showModal = false">Cerrar</button>
                  <button type="button" class="btn btn-primary" @click="guardarProducto()">Guardar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import ProductoService from "../services/ProductoService";
export default {
  created() {
    this.ProductoService = new ProductoService();
  },
  mounted() {
    this.consultarProductos();
    this.consultarEstados();
  },
  data() {
    return {
      filtro_nombre: "",
      productos: [],
      productoDialog: false,
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
      submitted: false,
      estados: {},
      filterActivos: false,
      filterInactivos: false,
      filterPendiente: false,
      showModal: false,
      modalTitle: "",
    };
  },
  computed: {
    filtrosCheck() {
      if (this.filterActivos === true) {
        return this.productos.filter((producto) => producto.id_estado == 1);
      }
      if (this.filterInactivos == true) {
        return this.productos.filter((producto) => producto.id_estado == 2);
      }
      if (this.filterPendiente == true) {
        return this.productos.filter((producto) => producto.id_estado == 3);
      } else {
        return this.productos;
      }
    },
    contarActivos() {
      const activos = this.productos.filter(
        (producto) => producto.id_estado == 1
      );
      return activos.length;
    },
    contarInactivos() {
      const inactivos = this.productos.filter(
        (producto) => producto.id_estado == 2
      );
      return inactivos.length;
    },
    contarPendientes() {
      const pendientes = this.productos.filter(
        (producto) => producto.id_estado == 3
      );
      return pendientes.length;
    },
  },
  methods: {
    consultarProductos() {
      this.loading = true;
      this.ProductoService.getProductos().then(
        (productos) => (
          (this.productos = productos), (this.productosbuscar = this.productos)
        )
      );
      this.loading = false;
    },
    consultarEstados() {
      this.ProductoService.getEstados().then(
        (estados) => (this.estados = estados)
      );
    },
    filtroBuscar() {
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
    crearNuevo() {
      this.objetoProducto = {};
      this.submitted = false;
      this.showModal = true;
      this.modalTitle = "Producto Nuevo";
    },
    editProducto(producto) {
      this.objetoProducto = { ...producto };
      this.showModal = true;
      this.modalTitle = "Editar Producto";
    },
    guardarProducto() {
      this.submitted = true;

      if (this.objetoProducto.nombre.trim()) {
        if (this.objetoProducto.id_producto) {
          this.ProductoService.editProducto({
            id_producto: this.objetoProducto.id_producto,
            nombre: this.objetoProducto.nombre,
            codigo: this.objetoProducto.codigo,
            existencia: this.objetoProducto.existencia,
            bodega: this.objetoProducto.bodega,
            descripcion: this.objetoProducto.descripcion,
            id_estado: this.objetoProducto.id_estado,
          });
        } else {
          this.ProductoService.addProducto({
            nombre: this.objetoProducto.nombre,
            codigo: this.objetoProducto.codigo,
            existencia: this.objetoProducto.existencia,
            bodega: this.objetoProducto.bodega,
            descripcion: this.objetoProducto.descripcion,
            id_estado: this.objetoProducto.id_estado,
          });
        }
        this.showModal = false;
        this.consultarProductos();
      }
    },
  },
};
</script>
<style>
.columns {
  background-color: #017aaf;
  color: white;
}

.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}
</style>

