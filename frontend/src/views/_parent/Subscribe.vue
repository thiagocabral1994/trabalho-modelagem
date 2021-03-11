<template>
  <CCard>
    <CCardHeader>{{ titulo }}</CCardHeader>
    <CCardBody>
      <CForm>
        <CRow>
          <CCol>
            <multiselect
              :disabled="view_only"
              v-model="items"
              :options="lista"
              :multiple="true"
              :close-on-select="true"
              :clear-on-select="false"
              :preserve-search="true"
              :placeholder="`Procure ou adicione ${titulo}`"
              selectLabel="Pressione Enter para escolher"
              deselectLabel="Pressione Enter para remover"
              selectGroupLabel="Pressione Enter para escolher grupo"
              deselectGroupLabel="Pressione Enter para remover grupo"
              selectedLabel="Selecionado"
              :label="label"
              track-by="id"
              @input="updateItems"
            >
              <template
                v-if="fields.length > 0"
                slot="selection"
                slot-scope="{ values, search, isOpen }"
              >
                <span
                  class="multiselect__single"
                  v-if="values.length &amp;&amp; !isOpen"
                  >{{ values.length }} {{ titulo }} selecionados</span
                >
              </template>
            </multiselect>

            <!-- Tabela -->
            <b-table
              v-if="fields.length > 0"
              select-mode="single"
              striped
              show-empty
              small
              stacked="sm"
              :items="items"
              :fields="fields"
              :current-page="currentPage"
              :per-page="perPage"
            >
              <template v-slot:cell(action)="row">
                <CButton @click="removeRow(row.item.id)">
                  <CIcon name="cil-trash" />
                </CButton>
              </template>
            </b-table>
          </CCol>
        </CRow>
      </CForm>
    </CCardBody>
    <CCardFooter v-if="fields.length != 0">
      <!-- Config da Paginacao -->
      <CCol class="my-1">
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="center"
          size="md"
          class="my-0"
        ></b-pagination>
      </CCol>
    </CCardFooter>
  </CCard>
</template>

<script>
import Multiselect from "vue-multiselect";
export default {
  components: {
    Multiselect,
  },
  props: {
    titulo: String,
    items_input: Array,
    lista: Array,
    label: String,
    fields: Array,
    view_only: {
      type: Boolean,
      default: false
    },
  },
  data() {
    return {
      items: [],

      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      pageOptions: [5, 10, 15],
      filter: null,
      filterOn: [],
      selectedRow: "",
    };
  },
  async mounted() {
    this.totalRows = this.items.length;
    this.items = this.items_input;
  },
  methods: {
    updateItems() {
      this.$emit("update-items", this.items);
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    onRowSelected(items) {
      this.selectedRow = items[0];
    },
    removeRow(id) {
      this.gruposUsuario = this.gruposUsuario.filter((grupo) => grupo.id != id);
    },
  },
};
</script>
