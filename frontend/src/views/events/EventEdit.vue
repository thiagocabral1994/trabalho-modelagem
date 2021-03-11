<template>
  <CRow>
    <CCol sm="12" md="6">
      <edit-view 
      v-bind:id_item="id"
      titulo="Ocorrência" 
      v-bind:items="configForm" 
      v-bind:validator="$v"
      v-bind:saveCall="save"
      returnRoute="/admin/events"
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
import { mapActions, mapState } from "vuex";

export default {
  components: {
    'edit-view': Edit,
    'subscribe': Subscribe
  },
  data() {
    return {
      id: null,
      assunto: null,
      detalhes: null,
      usuario: null,
      plano_acao: null,
      turma: null,

      configForm: [
        [
          {
            model: "assunto",
            type: "text",
            placeholder: "Assunto",
            icon: "cil-ocorrencia",
          },
        ],
        [
          {
            model: "usuario",
            type: "select",
            lista: {
              model: this.usuarioLista,
              placeholder: "nome"
            },
            placeholder: "Relator",
            icon: "cil-ocorrencia",
          },
        ],
        [
          {
            model: "turma",
            type: "select",
            lista: {
              model: this.turmaLista,
              placeholder: "nome"
            },
            placeholder: "Turma",
            icon: "cil-ocorrencia",
          },
        ],
        [
          {
            model: "detalhes",
            type: "text",
            placeholder: "Detalhes",
            icon: "cil-ocorrencia",
          },
        ],

      ]
    };
  },
  validations: {
    assunto: { required },
    usuario: { required },
    detalhes: { required },
    plano_acao: {},
    turma: { required },
  },
  computed: mapState({
    usuarioLista: (state) => state.users.users,
    turmaLista: (state) => state.classes.classes,
  }),
  async mounted() {
    await this.fetchUsers();
    await this.fetchClasses();

    if (this.$route.params.id) {
      this.id = this.$route.params.id;
      const res = await this.getEventById(this.id);

      const ocorrencia = res.data;
      
      this.assunto = ocorrencia.assunto;
      this.detalhes = ocorrencia.detalhes;
      this.usuario =  ocorrencia.usuario;
      this.plano_acao = ocorrencia.plano_acao;
      this.turma =  ocorrencia.turma;
    }
  },
  methods: {
    ...mapActions("users", ["fetchUsers"]),
    ...mapActions("classes", ["fetchClasses"]),
    ...mapActions("events", ["saveEvent", "getEventById"]),

    save() {
      const dadosOcorrencia = {
        id: this.id,
        assunto: this.assunto,
        detalhes: this.detalhes,
        usuario: this.usuario,
        plano_acao: this.plano_acao,
        turma: this.turma,
      };

      return this.saveEvent(dadosOcorrencia);
    }
  },
};
</script>
