import apiClient from '@/services/apiClient';

export default {

  /**
   * Entidade
   */
  get entidade() {
    return '/permissoes';
  },

  /**
   * CRUD
   */
  getAll() {
    return apiClient.get(this.entidade);
  }
};
