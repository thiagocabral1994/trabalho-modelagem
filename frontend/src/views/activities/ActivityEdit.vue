<template>
  <CRow>
    <CCol sm="12" md="6">
      <edit-view 
      v-bind:id_item="id"
      titulo="Atividade" 
      v-bind:items="configForm" 
      v-bind:validator="$v"
      v-bind:saveCall="save"
      returnRoute="/classes"
      />
    </CCol>
  </CRow>
</template>

<script>
import Edit from "../_parent/Edit.vue";
import Subscribe from "../_parent/Subscribe.vue";

import {
  required,
} from "vuelidate/lib/validators";
import { mapActions } from "vuex";

export default {
  components: {
    'edit-view': Edit,
    'subscribe': Subscribe
  },
  data() {
    return {
      id_atividade: null,
      id_turma: null,
      titulo: null,
      descricao: null,
      anexo: null,

      configForm: [
        [
          {
            model: "titulo",
            type: "text",
            placeholder: "Título",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "descricao",
            type: "textarea",
            placeholder: "Descrição",
            icon: "cil-user",
          },
        ],
        [
          {
            model: "anexo",
            type: "text",
            placeholder: "Anexo",
            icon: "cil-user",
          },
        ],
      ]
    };
  },
  validations: {
    titulo: { required },
    descricao: { required },
    anexo: { },
  },
  async mounted() {
    if (this.$route.params.id_atividade) {
      this.id_atividade = this.$route.params.id_atividade;
      const res = await this.getActivityById(this.id_atividade);

      const activity = res.data;
      this.titulo = activity.titulo;
      this.descricao = activity.descricao;
      this.anexo = activity.anexo;
    }
  },
  methods: {
    ...mapActions("activities", ["saveActivity", "getActivityById"]),

    save() {
      const dadosAtividade = {
        id: this.id_atividade,
        id_turma: this.id_turma,
        titulo: this.titulo,
        descricao: this.descricao,
        anexo: this.anexo,
      };

      return this.saveActivity(dadosAtividade);
    }
  },
};
</script>
