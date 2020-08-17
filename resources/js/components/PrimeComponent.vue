<template>
  <div class="container">
    <h1 class="display-3">PrimeVue Component</h1>
    <!-- Inicio Data Table -->
    <DataTable
      :value="productos"
      class="p-datatable-striped"
      :paginator="true"
      :rows="5"
      paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
      :rowsPerPageOptions="[10,20,50]"
      currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
      :selection.sync="selectedProductos"
      data-key="id"
      :filters="filters"
    >
      <template #header>
        <div class="table-header">
          Gestión de Productos
          <span class="p-input-icon-left">
            <i class="pi pi-search" />
            <InputText v-model="filters['global']" placeholder="Global Search" />
          </span>
        </div>
      </template>
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
    <!-- Fin Data Table -->

    <!-- Inicio Modal -->
    <Dialog
      :visible.sync="productoDialog"
      :style="{width: '450px'}"
      header="producto"
      :modal="true"
      class="p-fluid"
    >
      <div class="p-field">
        <label for="nombre">Nombre del Producto</label>
        <InputText
          id="nombre"
          v-model.trim="producto.nombre"
          required="true"
          autofocus
          :class="{'p-invalid': submitted && !producto.nombre}"
        />
        <small class="p-invalid" v-if="submitted && !producto.nombre">Name is required.</small>
      </div>
      <br />

      <div class="p-field">
        <label for="codigo">Código</label>
        <InputText
          id="codigo"
          v-model.trim="producto.codigo"
          required="true"
          :class="{'p-invalid': submitted && !producto.codigo}"
        />
        <small class="p-invalid" v-if="submitted && !producto.codigo">Código is required.</small>
      </div>
      <br />

      <div class="p-field">
        <label for="existencia">Existencia</label>
        <InputText
          id="existencia"
          v-model.trim="producto.existencia"
          required="true"
          :class="{'p-invalid': submitted && !producto.existencia}"
        />
        <small class="p-invalid" v-if="submitted && !producto.existencia">Existencia is required.</small>
      </div>
      <br />

      <div class="p-field">
        <label for="bodega">Bodega</label>
        <InputText
          id="bodega"
          v-model.trim="producto.bodega"
          required="true"
          :class="{'p-invalid': submitted && !producto.bodega}"
        />
        <small class="p-invalid" v-if="submitted && !producto.bodega">Bodega is required.</small>
      </div>
      <br />

      <div class="p-field">
        <label for="descripcion">Descripción</label>
        <InputText
          id="descripcion"
          v-model.trim="producto.descripcion"
          required="true"
          :class="{'p-invalid': submitted && !producto.descripcion}"
        />
        <small class="p-invalid" v-if="submitted && !producto.descripcion">Descripción is required.</small>
      </div>
      <br />

      <div class="p-field">
        <label for="estado">Estado</label>
        <InputText
          id="estado"
          v-model.trim="producto.estado"
          required="true"
          :class="{'p-invalid': submitted && !producto.estado}"
        />
        <small class="p-invalid" v-if="submitted && !producto.estado">Estado is required.</small>
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
import Button from "primevue/button";
import Dialog from "primevue/dialog";
export default {
  components: {
    DataTable,
    Column,
    InputText,
    Button,
    Dialog,
  },
  created() {
    this.ProductoService = new ProductoService();
  },
  mounted() {
    this.ProductoService.getProductos().then(
      (productos) => (
        (this.productos = productos), (this.productosbuscar = this.productos)
      )
    );
  },
  data() {
    return {
      productos: [],
      productoDialog: false,
      selectedProductos: null,
      producto: {},
      filters: {},
      submitted: false,
    };
  },
  methods: {
    openNew() {
      this.producto = {};
      this.submitted = false;
      this.productoDialog = true;
    },
    hideDialog() {
      this.productoDialog = false;
      this.submitted = false;
    },
    editProducto(producto) {
      this.producto = { ...producto };
      this.productoDialog = true;
    },
    confirmDeleteProducto(producto) {
      this.producto = producto;
      this.deleteProductoDialog = true;
    },
    saveProducto() {
      this.submitted = true;

      if (this.producto.name.trim()) {
        if (this.producto.id) {
          this.$set(
            this.productos,
            this.findIndexById(this.producto.id),
            this.producto
          );
          this.$toast.add({
            severity: "success",
            summary: "Successful",
            detail: "Producto Updated",
            life: 3000,
          });
        } else {
          this.producto.id = this.createId();
          this.producto.image = "producto-placeholder.svg";
          this.productos.push(this.producto);
          this.$toast.add({
            severity: "success",
            summary: "Successful",
            detail: "Producto Created",
            life: 3000,
          });
        }

        this.productoDialog = false;
        this.producto = {};
      }
    },
  },
};
</script>

<style>
</style>
