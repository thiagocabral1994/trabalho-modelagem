import apiClient from '@/services/apiClient';

export default {

  /**
   * Entidade
   */
  get entidade() {
    return '/atividades';
  },

  getAll() {
    return apiClient.get(this.entidade);
  },

  getById(id) {
    return apiClient.get(this.entidade + `/${id}`);
  },

  getByClassId(id) {
    return apiClient.get(this.entidade + `/listByClass/${id}`);
  },

  saveList(objeto) {
    return apiClient.post(this.entidade+ `/saveList`, objeto);
  },

  save(objeto) {
    return apiClient.post(this.entidade, objeto);
  },

  delete(id) {
    return apiClient.delete(this.entidade + `/${id}`);
  },
};
