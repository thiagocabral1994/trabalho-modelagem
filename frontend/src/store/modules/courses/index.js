import CourseService from '@/services/CourseService';

export const module = {
  namespaced: true,

  state() {
    return {
      courses: []
    };
  },

  mutations: {
    SET_CLASSES(state, payload) {
      state.courses = payload;
    },

    REMOVE_BY_ID(state, id) {
      state.courses = state.courses.filter(course => course.id != id);
    }
  },

  actions: {

    fetchCourses({ commit }) {
      return CourseService.getAll().then(({ data }) => {
        commit('SET_CLASSES', data);
      });
    },

    getCourseById({ commit }, id) {
      return CourseService.getById(id);
    },

    saveCourse({}, data) {
      return CourseService.save(data);
    },

    deleteCourse({ commit }, id) {
      return CourseService.delete(id).then(() => {
        commit('REMOVE_BY_ID', id);
      });
    }
  }
};
