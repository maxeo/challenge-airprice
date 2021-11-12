<template>
  <nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle" @click="$emit('toggle_sidebar_collapse')">
      <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
      <ul class="navbar-nav navbar-align">
        <li class="nav-item dropdown">
          <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
            <i class="fas fa-cogs"></i>
          </a>
          <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
            <img :src="require('../assets/plane.svg')" class="avatar img-fluid rounded me-1" :alt="user?.name"/>
            <span class="text-dark">{{ (user?.first_name + ' ' + user?.last_name).trim() }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-end">
            <router-link v-if="info?.user_permissions?.indexOf('profile/menu') > -1" class="dropdown-item" :to="$router.getByName('admin-profilo')"><i class="far fa-user-circle me-2"></i>
              Profilo
            </router-link>
            <div class="dropdown-divider"></div>
            <router-link v-if="info?.user_permissions?.indexOf('support/menu') > -1" class="dropdown-item" :to="$router.getByName('admin-supporto')"><i class="far fa-question-circle me-2"></i> Supporto
            </router-link>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" @click="$emit('do_logout')"><i class="fas fa-sign-out-alt me-2"></i> Log out</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  name: "Navbar",
  props: {
    user: {
      type: Object,
    },
    info: {
      type: Object,
    },
  },
  methods: {
  }
}
</script>

<style scoped>

.avatar {
  height: 40px;
  width: 40px;

}

.sidebar-toggle {
  cursor: pointer;
  display: flex;
  height: 26px;
  width: 26px
}


@media (prefers-reduced-motion: reduce) {
  .nav-link {
    transition: none
  }
}

.nav-link:focus, .nav-link:hover {
  color: #2f64b1;
  text-decoration: none
}

.nav-link.disabled {
  color: #6c757d;
  cursor: default;
  pointer-events: none
}


.nav-tabs .nav-link {
  background: none;
  border: 1px solid transparent;
  border-top-left-radius: .2rem;
  border-top-right-radius: .2rem;
  margin-bottom: -1px
}

.nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
  border-color: #e9ecef #e9ecef #dee2e6;
  isolation: isolate
}

.nav-tabs .nav-link.disabled {
  background-color: transparent;
  border-color: transparent;
  color: #6c757d
}

.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
  background-color: #f5f7fb;
  border-color: #dee2e6 #dee2e6 #f5f7fb;
  color: #495057
}

.nav-tabs .dropdown-menu {
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  margin-top: -1px
}

.nav-pills .nav-link {
  background: none;
  border: 0;
  border-radius: .2rem
}

.nav-pills .nav-link.active, .nav-pills .show > .nav-link {
  background-color: #3b7ddd;
  color: #fff
}

.nav-fill .nav-item, .nav-fill > .nav-link {
  flex: 1 1 auto;
  text-align: center
}

.nav-justified .nav-item, .nav-justified > .nav-link {
  flex-basis: 0;
  flex-grow: 1;
  text-align: center
}

.nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
  width: 100%
}

.navbar {
  align-items: center;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  padding: .875rem 1.375rem;
  position: relative
}

.navbar-nav {
  display: flex;
  flex-direction: column;
  list-style: none;
  margin-bottom: 0;
  padding-left: 0
}

.navbar-nav .nav-link {
  padding-left: 0;
  padding-right: 0
}

.navbar-nav .dropdown-menu {
  position: static
}

.navbar-collapse {
  align-items: center;
  flex-basis: 100%;
  flex-grow: 1
}

@media (min-width: 576px) {
  .navbar-expand-sm {
    flex-wrap: nowrap;
    justify-content: flex-start
  }

  .navbar-expand-sm .navbar-nav {
    flex-direction: row
  }

  .navbar-expand-sm .navbar-nav .dropdown-menu {
    position: absolute
  }

  .navbar-expand-sm .navbar-nav .nav-link {
    padding-left: .5rem;
    padding-right: .5rem
  }


  .navbar-expand-sm .navbar-collapse {
    display: flex !important;
    flex-basis: auto
  }
}

@media (min-width: 768px) {
  .navbar-expand-md {
    flex-wrap: nowrap;
    justify-content: flex-start
  }

  .navbar-expand-md .navbar-nav {
    flex-direction: row
  }

  .navbar-expand-md .navbar-nav .dropdown-menu {
    position: absolute
  }

  .navbar-expand-md .navbar-nav .nav-link {
    padding-left: .5rem;
    padding-right: .5rem
  }

  .navbar-expand-md .navbar-collapse {
    display: flex !important;
    flex-basis: auto
  }
}

@media (min-width: 992px) {
  .navbar-expand-lg .navbar-nav {
    flex-direction: row
  }

  .navbar-expand-lg .navbar-nav .dropdown-menu {
    position: absolute
  }

  .navbar-expand-lg .navbar-nav .nav-link {
    padding-left: .5rem;
    padding-right: .5rem
  }

  .navbar-expand-lg .navbar-collapse {
    display: flex !important;
    flex-basis: auto
  }
}

@media (min-width: 1200px) {
  .navbar-expand-xl {
    flex-wrap: nowrap;
    justify-content: flex-start
  }

  .navbar-expand-xl .navbar-nav {
    flex-direction: row
  }

  .navbar-expand-xl .navbar-nav .dropdown-menu {
    position: absolute
  }

  .navbar-expand-xl .navbar-nav .nav-link {
    padding-left: .5rem;
    padding-right: .5rem
  }

  .navbar-expand-xl .navbar-collapse {
    display: flex !important;
    flex-basis: auto
  }
}

@media (min-width: 1440px) {

  .navbar-expand-xxl .navbar-nav {
    flex-direction: row
  }

  .navbar-expand-xxl .navbar-nav .dropdown-menu {
    position: absolute
  }

  .navbar-expand-xxl .navbar-nav .nav-link {
    padding-left: .5rem;
    padding-right: .5rem
  }

  .navbar-expand-xxl .navbar-collapse {
    display: flex !important;
    flex-basis: auto
  }
}

.navbar-expand {
  flex-wrap: nowrap;
  justify-content: flex-start
}

.navbar-expand .navbar-nav {
  flex-direction: row
}

.navbar-expand .navbar-nav .dropdown-menu {
  position: absolute
}

.navbar-expand .navbar-nav .nav-link {
  padding-left: .5rem;
  padding-right: .5rem
}


.navbar-expand .navbar-collapse {
  display: flex !important;
  flex-basis: auto
}

.navbar-light .navbar-nav .nav-link {
  color: rgba(0, 0, 0, .55)
}

.navbar-light .navbar-nav .nav-link:focus, .navbar-light .navbar-nav .nav-link:hover {
  color: rgba(0, 0, 0, .7)
}

.navbar-light .navbar-nav .nav-link.disabled {
  color: rgba(0, 0, 0, .3)
}

.navbar-light .navbar-nav .nav-link.active, .navbar-light .navbar-nav .show > .nav-link {
  color: rgba(0, 0, 0, .9)
}

.navbar-light .navbar-text a, .navbar-light .navbar-text a:focus, .navbar-light .navbar-text a:hover {
  color: rgba(0, 0, 0, .9)
}

.navbar-dark .navbar-nav .nav-link {
  color: rgba(255, 255, 255, .55)
}

.navbar-dark .navbar-nav .nav-link:focus, .navbar-dark .navbar-nav .nav-link:hover {
  color: rgba(255, 255, 255, .75)
}

.navbar-dark .navbar-nav .nav-link.disabled {
  color: rgba(255, 255, 255, .25)
}

.navbar-dark .navbar-nav .nav-link.active, .navbar-dark .navbar-nav .show > .nav-link {
  color: #fff
}

.navbar-dark .navbar-text a, .navbar-dark .navbar-text a:focus, .navbar-dark .navbar-text a:hover {
  color: #fff
}

</style>