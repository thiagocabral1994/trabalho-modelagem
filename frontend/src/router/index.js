import Vue from "vue";
import Router from "vue-router";
import store from "../store";

// Containers
const TheContainer = () => import("@/containers/TheContainer");

// Main Views
const Home = () => import("@/views/Home");
const Login = () => import("@/views/Login");

// Errors
const Page404 = () => import("@/views/error/Page404");
const Page500 = () => import("@/views/error/Page500");

// Users
const UserList = () => import("@/views/users/UserList");
const UserEdit = () => import("@/views/users/UserEdit");
const UserDetail = () => import("@/views/users/UserDetail");

// Permissions
const PermissionList = () => import("@/views/permissions/PermissionList");

// Profiles
const ProfileList = () => import("@/views/profiles/ProfileList");
const ProfileEdit = () => import("@/views/profiles/ProfileEdit");
const ProfileDetail = () => import("@/views/profiles/ProfileDetail");

// Courses
const CourseList = () => import("@/views/courses/CourseList");
const CourseEdit = () => import("@/views/courses/CourseEdit");
const CourseDetail = () => import("@/views/courses/CourseDetail");

// Events
const EventList = () => import("@/views/events/EventList");
const EventEdit = () => import("@/views/events/EventEdit");
const EventDetail = () => import("@/views/events/EventDetail");

// Classes
const ClassList = () => import("@/views/classes/ClassList");
const ClassEdit = () => import("@/views/classes/ClassEdit");
const ClassDetail = () => import("@/views/classes/ClassDetail");

// Activity
const ActivityEdit = () => import("@/views/activities/ActivityEdit");
const ActivityDetail = () => import("@/views/activities/ActivityDetail");

Vue.use(Router);

const router = new Router({
  mode: "history", // https://router.vuejs.org/api/#mode
  linkActiveClass: "active",
  scrollBehavior: () => ({ y: 0 }),
  routes: configRoutes(),
});

function _validaRota(routeTo, next) {
  const permissionRoute = routeTo.matched.find(
    (record) => record.meta.permission
  );
  // Valida a rota quando nao ha permissao
  if (!permissionRoute) {
    next();
    return;
  }
  const permission = permissionRoute.meta.permission;
  const userPermissions = store.state.users.loggedUser.permissoes;

  // Verifica se o usuario tem a permissao requerida
  if (
    userPermissions.some((userPermission) => userPermission.nome == permission || userPermission.nome==`ADMIN_${permission}`)
  ) {
    next();
  } else {
    next("/500");
  }
}

router.beforeEach((routeTo, routeFrom, next) => {
  if (
    routeTo.path == "/logout" ||
    (!localStorage.getItem("loggedUser") && routeTo.path != "/login")
  ) {
    store.dispatch("users/logout");
    next("/login");
    return;
  }

  /**
   * Validacao direta quando o loggedUser
   *  esta registrado no state
   */
  var loggedUser = store.state.users.loggedUser;
  if (loggedUser) {
    _validaRota(routeTo, next);
    return;
  }

  /**
   * Validacao via token quando o loggedUser
   *  o state eh nulo
   */
  store
    .dispatch("users/loginJwt")
    .then(() => {
      loggedUser = store.state.users.loggedUser;
      //temporario, arrumar
      if (routeTo.path == "/users/edit/" + loggedUser.id) {
        next("/users");
      } else if (routeTo.path == "/login" && loggedUser) {
        next("/home");
      }
      _validaRota(routeTo, next);
    })
    .catch(() => {
      if (routeTo.path != "/login") {
        next("/login");
      } else {
        next();
      }
    });
});

function configRoutes() {
  return [
    {
      path: "/login",
      name: "Login",
      component: Login,
    },
    {
      path: "/logout",
      name: "Logout",
      component: Login,
    },
    {
      path: "/",
      redirect: "/home",
      name: "Home",
      meta: {
        requiresAuth: true,
      },
      component: TheContainer,
      children: [
        {
          path: "",
          redirect: "/home",
        },
        {
          path: "home",
          name: "",
          component: Home,
        },
        {
          path: "admin",
          component: {
            render(c) {
              return c("router-view");
            },
          },
          children: [
            {
              path: "users",
              meta: {
                label: "Usuários",
                //permission: "USUARIO",
              },
              component: {
                render(c) {
                  return c("router-view");
                },
              },
              children: [
                {
                  path: "",
                  component: UserList,
                },
                {
                  path: "new",
                  meta: {
                    label: "Novo Usuário",
                    //permission: "ADMIN_USUARIO"
                  },
                  component: UserEdit,
                },
                {
                  path: "edit/:id",
                  meta: {
                    label: "Editar Usuário",
                  },
                  component: UserEdit,
                },
                {
                  path: "detail/:id",
                  meta: {
                    label: "Detalhes do Usuário",
                  },
                  component: UserDetail,
                },
              ],
            },
            {
              path: "permissions",
              name: "Permissions",
              meta: {
                label: "Permissões",
                // permission: 'PERMISSAO',
              },
              component: PermissionList,
            },
            {
              path: "profiles",
              meta: {
                label: "Perfis",
                //permission: 'GRUPO',
              },
              component: {
                render(c) {
                  return c("router-view");
                },
              },
              children: [
                {
                  path: "",
                  component: ProfileList,
                },
                {
                  path: "new",
                  meta: {
                    label: "Novo Perfil",
                    //permission: 'ADMIN_GRUPO',
                  },
                  component: ProfileEdit,
                },
                {
                  path: "edit/:id",
                  meta: {
                    label: "Editar Perfil",
                  },
                  component: ProfileEdit,
                },
                {
                  path: "detail/:id",
                  meta: {
                    label: "Detalhes do Perfil",
                  },
                  component: ProfileDetail,
                },
              ],
            },
            {
              path: "courses",
              meta: {
                label: "Cursos",
                //permission: 'COURSE',
              },
              component: {
                render(c) {
                  return c("router-view");
                },
              },
              children: [
                {
                  path: "",
                  component: CourseList,
                },
                {
                  path: "new",
                  meta: {
                    label: "Novo Curso",
                    //permission: 'ADMIN_COURSE',
                  },
                  component: CourseEdit,
                },
                {
                  path: "edit/:id",
                  meta: {
                    label: "Editar Curso",
                  },
                  component: CourseEdit,
                },
                {
                  path: "detail/:id",
                  meta: {
                    label: "Detalhes do Curso",
                  },
                  component: CourseDetail,
                },
              ],
            },
          ],
        },
        {
          path: "events",
          meta: {
            label: "Ocorrências",
            //permission: "EVENT",
          },
          component: {
            render(c) {
              return c("router-view");
            },
          },
          children: [
            {
              path: "",
              component: EventList,
            },
            {
              path: "new",
              meta: {
                label: "Nova Ocorrência",
                //permission: "ADMIN_EVENT"
              },
              component: EventEdit,
            },
            {
              path: "edit/:id",
              meta: {
                label: "Editar Ocorrência",
              },
              component: EventEdit,
            },
            {
              path: "detail/:id",
              meta: {
                label: "Detalhes da Ocorrência",
              },
              component: EventDetail,
            },
          ],
        },
        {
          path: "classes",
          meta: {
            label: "Turmas",
            //permission: "CLASS",
          },
          component: {
            render(c) {
              return c("router-view");
            },
          },
          children: [
            {
              path: "",
              component: ClassList,
            },
            {
              path: "new",
              meta: {
                label: "Nova Turma",
                //permission: "ADMIN_CLASS"
              },
              component: ClassEdit,
            },
            {
              path: "edit/:id",
              meta: {
                label: "Editar Turma",
              },
              component: ClassEdit,
            },
            {
              path: "detail/:id",
              meta: {
                label: "Detalhes da Turma",
                //permission: "ACTIVITY",
              },
              component: {
                render(c) {
                  return c("router-view");
                },
              },
              children: [
                {
                  path: "",
                  component: ClassDetail,
                },
                {
                  path: "new",
                  meta: {
                    label: "Nova Atividade",
                    //permission: 'ADMIN_ACTIVITY',
                  },
                  component: ActivityEdit,
                },
                {
                  path: "edit/:id_atividade",
                  meta: {
                    label: "Editar Atividade",
                  },
                  component: ActivityEdit,
                },
                {
                  path: "detail/:id_atividade",
                  meta: {
                    label: "Detalhes da Atividade",
                  },
                  component: ActivityDetail,
                },
              ],
            },
          ],
        },
        {
          path: "/500",
          name: "500",
          component: Page500,
        },
        {
          path: "/404",
          alias: "*",
          name: "404",
          component: Page404,
        },
      ],
    },
  ];
}

export default router;
