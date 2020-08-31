<template>
  <div class="container">
    <h1 class="display-3">Tareas Component</h1>
    <!-- mensaje -->
    <div class="mb-2">
      <h1 v-show="mensaje">Mensaje al reves: {{mensajeAlReves}}</h1>
      <input class="m-2" type="text" v-model="mensaje" />
    </div>
    <br />

    <!-- dias -->
        <div class="mb-2">
    <h1>Dias de la semana</h1>
    <li v-for="(dia, index) in dias" :key="index">{{ dia }}</li>
    <input
      class="m-2"
      type="text"
      placeholder="Escribe"
      v-model="nuevoDia"
      v-on:keyup.enter="agregar"
    />
    <button class="btn btn-danger" v-on:click="agregar">Agregar</button>
        </div>
    <br />

    <!-- ordenar heroes -->
    <div class="mb-2">
    <h1>Ordenar por fecha</h1>
    <li v-for="(heroe, index) in ordenarHeroes" :key="`A-${index}`">{{heroe}}</li>
    </div>
    <br />

    <!-- Buscar heroe al escribir -->
    <div class="mb-2">
    <h1>Buscador autocompletado</h1>
    <li v-for="(jugador, index) in buscarjugadores" :key="`B-${index}`">{{jugador}}</li>
    <input type="search" v-model="busqueda" placeholder="Buscar jugador" />
    </div>
    <br />

    <!-- imagenes api -->
    <div class="mb-2">
    <h1>Mostrar imagenes de Api</h1>
    <img
      v-for="(usuario, index) in usuarios"
      :key="`C-${index}`"
      v-bind:src="usuario.picture.thumbnail"
      :alt="usuario.name.first"
    />
    </div>

    <!-- <pre class="fondo">{{$data}}</pre> -->
    <br />
  </div>
</template>

<script>
export default {
  mounted() {
    this.cargarPersonas();
  },
  data() {
    return {
      mensaje: "hola mundo",
      nuevoDia: null,
      dias: ["lunes", "martes", "miercoles", "jueves", "viernes"],
      busqueda: "",
      heroes: [
        {
          squadName: "Super hero squad",
          homeTown: "Metro City",
          formed: 2016,
          secretBase: "Super tower",
          active: true,
        },
        {
          squadName: "Minimal Operator",
          homeTown: "Metro maal",
          formed: 2015,
          secretBase: "Super",
          active: true,
        },
      ],
      jugadores: [
        {
          squadName: "Messi",
          homeTown: "Metro City",
          formed: 2016,
          secretBase: "Super tower",
          active: true,
        },
        {
          squadName: "Cristiano",
          homeTown: "Metro maal",
          formed: 2015,
          secretBase: "Super",
          active: true,
        },
      ],
      usuarios: [],
    };
  },
  methods: {
    agregar() {
      this.dias.push(this.nuevoDia);
      this.nuevoDia = null;
    },
    cargarPersonas() {
      return axios
        .get("https://randomuser.me/api/?results=100")
        .then((response) => {
          this.usuarios = response.data.results;
        });
    },
  },
  computed: {
    mensajeAlReves() {
      return this.mensaje.split("").reverse().join("");
    },
    ordenarHeroes() {
      return this.heroes.sort((a, b) => b.formed + a.formed); // Javascript
      //   return _.orderBy(this.heroes, ["formed"], ["asc"]); // lodash
    },
    buscarjugadores() {
      return this.jugadores.filter((jugador) =>
        jugador.squadName.toLowerCase().includes(this.busqueda.toLowerCase())
      );
    },
  },
};
</script>

<style>
</style>

