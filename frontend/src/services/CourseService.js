import apiClient from '@/services/apiClient';

export default {

  /**
   * Entidade
   */
  get entidade() {
    return '/cursos';
  },

  getAll() {
    return apiClient.get(this.entidade);
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
