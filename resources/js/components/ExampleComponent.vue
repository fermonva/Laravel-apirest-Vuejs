<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>

          <div class="card-body">I'm an example component.</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      productos: [
        {
          id_producto: 1,
          nombre: "Castell",
          codigo: "0001",
          existencia: 30,
          descripcion: "lapiceros Castell",
          id_estado: 1,
          id_bodega: 1,
        },
        {
          id_producto: 2,
          nombre: "Portaminas",
          codigo: "0002",
          existencia: 13,
          descripcion: "Lapicero",
          id_estado: 1,
          id_bodega: 1,
        },
        {
          id_producto: 3,
          nombre: "Agujas",
          codigo: "0003",
          existencia: 22,
          descripcion: "Descripcion",
          id_estado: 1,
          id_bodega: 1,
        },
        {
          id_producto: 4,
          nombre: "piñas",
          codigo: "0004",
          existencia: 13,
          descripcion: "desc",
          id_estado: 1,
          id_bodega: 1,
        },
        {
          id_producto: 5,
          nombre: "papas",
          codigo: "0005",
          existencia: 60,
          descripcion: "des",
          id_estado: 1,
          id_bodega: 1,
        },
        {
          id_producto: 6,
          nombre: "celulares",
          codigo: "0006",
          existencia: 10,
          descripcion: "desc",
          id_estado: 1,
          id_bodega: 1,
        },
        {
          id_producto: 7,
          nombre: "Audifonos",
          codigo: "0007",
          existencia: 33,
          descripcion: "desc",
          id_estado: 1,
          id_bodega: 1,
        },
      ],
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
