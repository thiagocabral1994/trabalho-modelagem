<template>
  <list-view
  titulo="Ocorrências"
  v-bind:items="items"
  v-bind:fields="colunas"
  v-bind:routes="rotas"
  v-bind:deleteCall="deleteEvent"
  />
</template>

<script>
import List from "../_parent/List.vue";

import { mapActions, mapState } from "vuex";

export default {
  components: {
    'list-view': List
  },
  data() {
    return {
      colunas: [
        {
          key: "assunto",
          label: "Assunto",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "usuario.nome",
          label: "Responsável",
          sortable: true,
          sortDirection: "desc"
        }
      ],
      rotas: {
        new: "/events/new",
        details: "/events/detail",
        edit: "/events/edit",
      }
    };
  },
  computed: mapState({
    items: (state) => state.events.events,
    loggedUser: (state) => state.users.loggedUser,
  }),
  async mounted() {
    await this.fetchEvents();
  },
  methods: {
    ...mapActions("events", ["fetchEvents", "deleteEvent"]),
  },
};
</script>
