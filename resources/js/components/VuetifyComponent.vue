<template>
  <v-app>
    <v-container grid-list-xs>
      <h1 class="display-3">Vuetify Component</h1>
      <v-data-table :headers="headers" :items="productos" sort-by="Nombre">
        <template v-slot:top>
          <v-toolbar flat color="white">
            <v-toolbar-title>Gestion de Productos</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">Crear Producto</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field v-model="editedItem.name" label="Nombre"></v-text-field>
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
                        <v-text-field v-model="editedItem.estado" label="Estado"></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="save">Save</v-btn>
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
    editedIndex: -1,
    editedItem: {
      nombre: "",
      codigo: "",
      existencia: "",
      bodega: "",
      descripcion: "",
      estado: "",
    },
    defaultItem: {
      nombre: "",
      codigo: "",
      existencia: "",
      bodega: "",
      descripcion: "",
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
    this.ProductoService.getProductos().then(
      (productos) => (
        (this.productos = productos), (this.productosbuscar = this.productos)
      )
    );
  },

  methods: {
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
      } else {
        this.productos.push(this.editedItem);
      }
      this.close();
    },
  },
};
</script>
