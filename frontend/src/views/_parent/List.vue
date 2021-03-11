<template>
  <CRow>
    <CCol col="12" xl="12">
      <transition name="slide">
        <CCard>
          <CCardHeader>Lista de {{ titulo }}</CCardHeader>
          <CCardBody>
            <!-- Botao de Cadastro e Barra de Pesquisa -->
            <CRow>
              <CCol>
                <CButton
                  v-if="enable_new_button"
                  class="mr-1"
                  size="sm"
                  color="success"
                  :to="routes.new"
                >
                  <CIcon name="cil-plus" />Cadastrar
                </CButton>
                <CButton
                  v-if="enable_detail_button"
                  color="info"
                  size="sm"
                  class="mr-1"
                  :disabled="!selectedRow"
                  :to="selectedRow ? `${routes.details}/${selectedRow.id}` : ''"
                  ><CIcon name="cil-magnifying-glass" />Detalhes</CButton
                >
                <CButton
                  v-if="enable_edit_button"
                  color="warning"
                  size="sm"
                  class="mr-1"
                  :disabled="!selectedRow"
                  :to="selectedRow ? `${routes.edit}/${selectedRow.id}` : ''"
                  ><CIcon name="cil-pencil" />Editar</CButton
                >
                <CButton
                  v-if="enable_delete_button"
                  color="danger"
                  size="sm"
                  class="mr-1"
                  :disabled="!selectedRow"
                  @click="selectedRow ? deleteItem(selectedRow.id) : ''"
                  ><CIcon name="cil-trash" />Apagar</CButton
                >
              </CCol>
              <CCol>
                <CInput
                  placeholder="Pesquisar"
                  type="search"
                  v-model="filter"
                />
              </CCol>
            </CRow>

            <!-- Tabela -->
            <b-table
              selectable
              select-mode="single"
              striped
              show-empty
              small
              stacked="sm"
              :items="items"
              :fields="fields"
              :current-page="currentPage"
              :per-page="perPage"
              :filter="filter"
              :filterIncludedFields="filterOn"
              @filtered="onFiltered"
              @row-selected="onRowSelected"
            >
            </b-table>

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
          </CCardBody>
        </CCard>
      </transition>
    </CCol>
  </CRow>
</template>

<script>
import swal from "sweetalert";

export default {
  props: {
    titulo: String,
    items: Array,
    fields: Array,
    routes: Object,
    deleteCall: {
      type: Function,
      default: () => {}
    },
    enable_new_button: {
      type: Boolean,
      default: true,
    },
    enable_detail_button: {
      type: Boolean,
      default: true,
    },
    enable_edit_button: {
      type: Boolean,
      default: true,
    },
    enable_delete_button: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      pageOptions: [5, 10, 15],
      filter: null,
      filterOn: [],
      infoModal: false,
      modalItem: "",
      selectedRow: "",
    };
  },
  mounted() {
    // Set the initial number of items
    this.totalRows = this.items.length;
  },
  methods: {
    async deleteItem(id) {
      const willDelete = await swal({
        title: "Tem certeza?",
        text: "Uma vez que apagado, não será possivel recuperar seu dado!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      });

      if (willDelete) {
        try {
          await this.deleteCall(id);

          swal("Remoção concluída!", {
            icon: "success",
          });
        } catch (error) {
          swal(
            "Não foi possível realizar a operação. Tente novamente mais tarde!",
            {
              icon: "warning",
              dangerMode: true,
            }
          );
        }
      }
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    onRowSelected(items) {
      this.selectedRow = items[0];
    },
  },
};
</script>
