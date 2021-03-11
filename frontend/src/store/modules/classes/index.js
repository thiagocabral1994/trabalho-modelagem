import ClassService from '@/services/ClassService';

export const module = {
  namespaced: true,

  state() {
    return {
      classes: []
    };
  },

  mutations: {
    SET_CLASSES(state, payload) {
      state.classes = payload;
    },

    REMOVE_BY_ID(state, id) {
      state.classes = state.classes.filter(clazz => clazz.id != id);
    }
  },

  actions: {

    fetchClasses({ commit }) {
      return ClassService.getAll().then(({ data }) => {
        commit('SET_CLASSES', data);
      });
    },

    getClassById({ commit }, id) {
      return ClassService.getById(id);
    },

    saveClass({}, data) {
      return ClassService.save(data);
    },

    deleteClass({ commit }, id) {
      return ClassService.delete(id).then(() => {
        commit('REMOVE_BY_ID', id);
      });
    }
  }
};
