<template>
  <list-view
  titulo="Permissões"
  v-bind:items="items"
  v-bind:fields="colunas"
  v-bind:routes="rotas"

  v-bind:enable_new_button="false"
  v-bind:enable_edit_button="false"
  v-bind:enable_delete_button="false"
  v-bind:enable_detail_button="false"
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
          sortDirection: "desc",
        },
        {
          key: "descricao",
          label: "Descrição",
          sortable: true,
          sortDirection: "desc",
        },
      ],
      rotas: {}
    };
  },
  computed: mapState({
    items: (state) => state.permissions.permissions,
    loggedUser: (state) => state.users.loggedUser,
  }),
  async mounted() {
    await this.fetchPermissions();
  },
  methods: {
    ...mapActions("permissions", ["fetchPermissions"]),
  },
};
</script>
