import apiClient from '@/services/apiClient';

export default {

  /**
   * Entidade
   */
  get entidade() {
    return '/turmas';
  },

  getAll() {
    return apiClient.get(this.entidade);
  },

  getByStatusId(id) {
    return apiClient.get(this.entidade + `/listByStatus/${id}`);
  },

  getById(id) {
    return apiClient.get(this.entidade + `/${id}`);
  },

  save(objeto) {
    return apiClient.post(this.entidade, objeto);
  },

  delete(id) {
    return apiClient.delete(this.entidade + `/${id}`);
  },
};
