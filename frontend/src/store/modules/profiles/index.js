import ProfileService from '@/services/ProfileService';

export const module = {
  namespaced: true,

  state() {
    return {
      profiles: []
    };
  },

  mutations: {
    SET_PROFILES(state, payload) {
      state.profiles = payload;
    },

    REMOVE_BY_ID(state, id) {
      state.profiles = state.profiles.filter(profile => profile.id != id);
    }
  },

  actions: {

    fetchProfiles({ commit }) {
      return ProfileService.getAll().then(({ data }) => {
        commit('SET_PROFILES', data);
      });
    },

    getProfileById({ commit }, id) {
      return ProfileService.getById(id);
    },

    saveProfile({}, data) {
      return ProfileService.save(data);
    },

    deleteProfile({ commit }, id) {
      return ProfileService.delete(id).then(() => {
        commit('REMOVE_BY_ID', id);
      });
    }
  }
};
