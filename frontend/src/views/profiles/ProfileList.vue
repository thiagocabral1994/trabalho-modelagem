<template>
  <list-view
  titulo="Perfis"
  v-bind:items="items"
  v-bind:fields="colunas"
  v-bind:routes="rotas"
  v-bind:deleteCall="deleteProfile"
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
          key: "nome",
          label: "Nome",
          sortable: true,
          sortDirection: "desc"
        },
        {
          key: "descricao",
          label: "Descrição",
          sortable: true,
          sortDirection: "desc"
        }
      ],
      rotas: {
        new: "/admin/profiles/new",
        details: "/admin/profiles/detail",
        edit: "/admin/profiles/edit",
      }
    };
  },
  computed: mapState({
    items: (state) => state.profiles.profiles,
    loggedUser: (state) => state.users.loggedUser,
  }),
  async mounted() {
    await this.fetchProfiles();
  },
  methods: {
    ...mapActions("profiles", ["fetchProfiles", "deleteProfile"]),
  },
};
</script>
