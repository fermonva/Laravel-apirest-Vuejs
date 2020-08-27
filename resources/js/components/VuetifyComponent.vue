<template>
  <v-app>
    <v-container grid-list-xs>
      <h1 class="display-3">Vuetify Component</h1>

      <div>
        <strong>Gestión de Productos</strong>
      </div>
      <br />

      <v-data-table :headers="headers" :items="productos" sort-by="Nombre">
        <template v-slot:top>
          <v-toolbar flat color="white">
            <v-spacer></v-spacer>

            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn rounded color="primary" v-bind="attrs" v-on="on">Crear Producto</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field v-model="editedItem.nombre" label="Nombre"></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field v-model="editedItem.codigo" label="Código"></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field v-model="editedItem.existencia" label="Existencia"></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field v-model="editedItem.bodega" label="Bodega"></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field v-model="editedItem.descripcion" label="Descripción"></v-text-field>
                      </v-col>

                      <v-col cols="12" sm="6" md="4">
                        <v-select
                          v-model="editedItem.id_estado"
                          :items="estados"
                          item-text="nombre"
                          item-value="id_estado"
                          label="Estado"
                        ></v-select>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">Cancelar</v-btn>
                  <v-btn color="blue darken-1" text @click="save">Guardar</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>

        <template v-slot:item.actions="{ item }">
          <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
          <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
        </template>

        <template v-slot:no-data>
          <v-btn color="primary" @click="productos">Reset</v-btn>
        </template>
      </v-data-table>
    </v-container>
  </v-app>
</template>
<script>
import ProductoService from "../services/ProductoService";
export default {
  data: () => ({
    dialog: false,
    headers: [
      {
        text: "Nombre del producto",
        value: "nombre",
      },
      { text: "Código", value: "codigo" },
      { text: "Existencia", value: "existencia" },
      { text: "Bodega", value: "bodega" },
      { text: "Descripción", value: "descripcion" },
      { text: "Acciones", value: "actions", sortable: false },
      { text: "Estado", value: "estado" },
    ],
    productos: [],
    estados: [],
    editedIndex: -1,
    editedItem: {
      nombre: "",
      codigo: "",
      existencia: "",
      bodega: "",
      descripcion: "",
      id_estado: "",
      estado: "",
    },
    defaultItem: {
      nombre: "",
      codigo: "",
      existencia: "",
      bodega: "",
      descripcion: "",
      id_estado: "",
      estado: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo producto" : "Edit Item";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.ProductoService = new ProductoService();
  },
  mounted() {
    this.loading = true;
    this.consultarProductos();
    this.consultarEstados();
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
    editItem(item) {
      this.editedIndex = this.productos.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.productos.indexOf(item);
      confirm("Are you sure you want to delete this item?") &&
        this.productos.splice(index, 1);
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.productos[this.editedIndex], this.editedItem);
        this.ProductoService.editProducto({
          id_producto: this.editedItem.id_producto,
          nombre: this.editedItem.nombre,
          codigo: this.editedItem.codigo,
          existencia: this.editedItem.existencia,
          bodega: this.editedItem.bodega,
          descripcion: this.editedItem.descripcion,
          id_estado: this.editedItem.id_estado,
        });
      } else {
        this.productos.push(this.editedItem);
        this.ProductoService.addProducto({
          nombre: this.editedItem.nombre,
          codigo: this.editedItem.codigo,
          existencia: this.editedItem.existencia,
          bodega: this.editedItem.bodega,
          descripcion: this.editedItem.descripcion,
          id_estado: this.editedItem.id_estado,
        });
      }
      this.consultarProductos();
      this.close();
    },
  },
};
</script>
