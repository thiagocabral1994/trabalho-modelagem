<template>
  <CRow>
    <CCol sm="12" md="6">
      <detail-view 
      v-bind:id_item="id"
      titulo="Ocorrência" 
      v-bind:items="configForm"
      />
    </CCol>
  </CRow>
</template>

<script>
import Detail from "../_parent/Details.vue";
import Subscribe from "../_parent/Subscribe.vue";

import {
  required,
  minLength,
  maxLength,
  email,
  numeric,
  sameAs,
  alphaNum,
  maxValue,
} from "vuelidate/lib/validators";
import { mapActions, mapState } from "vuex";
import validaCPF from "../../js/cpf.check";

export default {
  components: {
    'detail-view': Detail,
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
            type: "select",
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
    ...mapActions("events", ["getEventById"]),
    ...mapActions("users", ["fetchUsers"]),
    ...mapActions("classes", ["fetchClasses"]),

  },
};
</script>
