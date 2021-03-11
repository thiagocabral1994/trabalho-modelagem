<template>
  <CRow>
    <CCol sm="12" md="6">
      <detail-view 
      v-bind:id_item="id"
      titulo="Curso" 
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
      nome: null,
      descricao: null,
      duracao: null,
      ementa: null,
      gruposUsuario: [],

      configForm: [
        [
          {
            model: "nome",
            type: "text",
            placeholder: "Nome",
            icon: "cil-course",
          },
        ],
        [
          {
            model: "descricao",
            type: "textarea",
            placeholder: "Descrição",
            icon: "cil-course",
          },
        ],
        [
          {
            model: "duracao",
            type: "text",
            placeholder: "Duração",
            icon: "cil-course",
          },
        ],
        [
          {
            model: "ementa",
            type: "textArea",
            placeholder: "Ementa",
            icon: "cil-course",
          }
        ],
      ]
    };
  },
  validations: {
    nome: {
      required,
      validLetters: (name) => !!name.match(/^[A-Za-z ']*$/),
    },
    descricao: {
      required
    },
    duracao: {
      required,
      numeric
    },
    ementa: {
      required
    }
  },
  async mounted() {
    if (this.$route.params.id) {
      this.id = this.$route.params.id;
      const res = await this.getCourseById(this.id);

      const course = res.data;
      this.nome = course.nome;
      this.descricao = course.descricao;
      this.duracao = course.duracao;
      this.ementa = course.ementa;
    }
  },
  methods: {
    ...mapActions("courses", ["getCourseById"]),
  },
};
</script>
