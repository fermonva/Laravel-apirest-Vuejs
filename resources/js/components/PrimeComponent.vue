<template>
  <div class="container">
    <h1 class="display-3">PrimeVue Component</h1>

    <div class="card" style="width: 1080px;background-color: #F6F6F6;">
      <div class="card-body">
        <div>
          <div>
            <strong>Gestión de Productos</strong>
            <Button
              label="Crear producto"
              class="p-button-success p-button-rounded p-button-sm"
              style="float: right;"
              @click="openNew()"
            />
          </div>
          <br />
          <div>
            <label>Nombre del producto</label>
            <Input
              type="text"
              @on-enter="filtroBuscar"
              v-model="filtro_nombre"
              placeholder="Ingrese su busqueda..."
              style="width: 200px"
            />
            <Button class="p-button-info p-button-sm" v-on:click="filtroBuscar">Buscar</Button>

            <CheckboxGroup style="float: right;" class="mt-2">
              <Checkbox></Checkbox>
              <span>Mostrar todos</span>
              <Checkbox v-model="filterActivos" :binary="true"></Checkbox>
              <span>Activos</span>
              <Checkbox v-model="filterInactivos" :binary="true"></Checkbox>
              <span>Inactivos</span>
              <Checkbox v-model="filterPendiente" :binary="true"></Checkbox>
              <span>Pendiente</span>
            </CheckboxGroup>
          </div>

          <br />

          <!-- INICIO DATATABLE -->
          <DataTable
            :value="filtrosCheck"
            class="p-datatable-sm headerClass"
            :paginator="true"
            :rows="10"
          >
            <Column field="nombre" header="Nombre del producto"></Column>
            <Column field="codigo" header="Código"></Column>
            <Column field="existencia" header="Existencia"></Column>
            <Column field="bodega" header="Bodega"></Column>
            <Column field="descripcion" header="Descripción"></Column>
            <Column header="Editar">
              <template #body="slotProps">
                <Button
                  icon="pi pi-pencil"
                  class="p-button-rounded p-button-success p-mr-2"
                  @click="editProducto(slotProps.data)"
                />
              </template>
            </Column>
            <Column field="estado" header="Estado"></Column>
          </DataTable>
          <!-- FIN DATATABLE -->
          <p
            style="background-color: #017AAF;color: white;"
          >Un producto registrado.[productos activos: {{contarActivos}}] - [Productos pendientes por activar: {{contarPendientes}}] - [productos inactivos: {{contarInactivos}}]</p>
        </div>
      </div>
    </div>

    <!-- MODAL CREAR PRODUCTO -->
    <Dialog
      :visible.sync="productoDialog"
      :style="{width: '50vw'}"
      header="producto"
      :modal="true"
      class="p-fluid"
    >
      <div class="p-field">
        <label for="nombre">Nombre del Producto</label>
        <InputText
          id="nombre"
          v-model.trim="objetoProducto.nombre"
          required="true"
          autofocus
          :class="{'p-invalid': submitted && !objetoProducto.nombre}"
        />
        <small class="p-invalid" v-if="submitted && !objetoProducto.nombre">Name is required.</small>
      </div>
      <br />

      <div class="p-field">
        <label for="codigo">Código</label>
        <InputText
          id="codigo"
          v-model.trim="objetoProducto.codigo"
          required="true"
          :class="{'p-invalid': submitted && !objetoProducto.codigo}"
        />
        <small class="p-invalid" v-if="submitted && !objetoProducto.codigo">Código is required.</small>
      </div>
      <br />

      <div class="p-field">
        <label for="existencia">Existencia</label>
        <InputText
          id="existencia"
          v-model.trim="objetoProducto.existencia"
          required="true"
          :class="{'p-invalid': submitted && !objetoProducto.existencia}"
        />
        <small
          class="p-invalid"
          v-if="submitted && !objetoProducto.existencia"
        >Existencia is required.</small>
      </div>
      <br />

      <div class="p-field">
        <label for="bodega">Bodega</label>
        <InputText
          id="bodega"
          v-model.trim="objetoProducto.bodega"
          required="true"
          :class="{'p-invalid': submitted && !objetoProducto.bodega}"
        />
        <small class="p-invalid" v-if="submitted && !objetoProducto.bodega">Bodega is required.</small>
      </div>
      <br />

      <div class="p-field">
        <label for="descripcion">Descripción</label>
        <InputText
          id="descripcion"
          v-model.trim="objetoProducto.descripcion"
          required="true"
          :class="{'p-invalid': submitted && !objetoProducto.descripcion}"
        />
        <small
          class="p-invalid"
          v-if="submitted && !objetoProducto.descripcion"
        >Descripción is required.</small>
      </div>
      <br />

      <div class="p-field">
        <label for="estado">Estado</label>
        <Dropdown
          v-model.trim="objetoProducto.id_estado"
          :options="estados"
          optionValue="id_estado"
          optionLabel="nombre"
          :editable="true"
        />

        <small class="p-invalid" v-if="submitted && !objetoProducto.estado">Estado is required.</small>
      </div>

      <template #footer>
        <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog" />
        <Button label="Save" icon="pi pi-check" class="p-button-text" @click="saveProducto" />
      </template>
    </Dialog>
    <!-- Fin Modal -->
  </div>
</template>

<script>
import ProductoService from "../services/ProductoService";
// Importaciones de vue
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import InputText from "primevue/inputtext";
import Checkbox from "primevue/checkbox";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Dropdown from "primevue/dropdown";

export default {
  components: {
    DataTable,
    Dropdown,
    Column,
    InputText,
    Checkbox,
    Button,
    Dialog,
  },
  created() {
    this.ProductoService = new ProductoService();
  },
  mounted() {
    this.consultarProductos();
    this.consultarEstados();
  },
  data() {
    return {
      filtro_nombre: null,
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
    openNew() {
      this.objetoProducto = {};
      this.submitted = false;
      this.productoDialog = true;
    },
    hideDialog() {
      this.productoDialog = false;
      this.submitted = false;
    },
    editProducto(producto) {
      this.objetoProducto = { ...producto };
      this.productoDialog = true;
    },
    confirmDeleteProducto(producto) {
      this.producto = producto;
      this.deleteProductoDialog = true;
    },
    saveProducto() {
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
        this.productoDialog = false;
        this.consultarProductos();
      }
    },
  },
};
</script scoped>

<style>
.headerClass {
  background-color: #017aaf;
  color: white;
}
.ivu-table-wrapper {
  margin-top: 10px;
}
</style>
