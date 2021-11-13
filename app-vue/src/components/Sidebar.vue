<template>
  <nav id="sidebar" class="sidebar js-sidebar" :class="collapsed?'collapsed':''">
    <div class="sidebar-content js-simplebar">
      <router-link class="sidebar-brand" :to="$router.getByName('home-page')">
        <div class="sidebar_logo">
          <img :src="require('../assets/plane-inline.svg')" alt="Punto Etichette">
        </div>
      </router-link>


      <SidebarLink :navLinks="navLinks"></SidebarLink>


    </div>
  </nav>
</template>

<script>
import SidebarLink from "@/components/Sidebar/SidebarLink";

export default {
  name: "Sidebar",
  components: {SidebarLink},
  data() {
    return {
      navLinks: [],
    }
  },
  props: {
    collapsed: Boolean,
    info: Object,
  },
  methods: {
    navigationToLink() {
      let navLinks = [];
      let navigation_item = this.info?.navigation;
      let li = '';

      let withParent = [];
      for (let i in navigation_item) {
        let el = navigation_item[i];
        if (el?.group_name !== li) {
          navLinks.push({type: 'header', name: el?.group_name});
          li = el?.group_name;
        }

        if (el.parent_id === null) {
          if (el.link === this.$route.path) {
            el.is_active = true;
          } else {
            el.is_active = false;
          }

          navLinks.push({...el, type: 'standard', children: [], active_cildren: false});
        } else {
          withParent.push({...el, type: 'standard'})
        }
      }

      while (withParent.length) {
        let children = withParent.pop();

        for (let i in navLinks) {
          if (navLinks[i].id === children.parent_id) {
            if (children.link === this.$route.path) {
              children.is_active = true;
              navLinks[i].active_cildren = true;
            } else {
              children.is_active = false;
            }
            navLinks[i].children.unshift(children)
          }
        }
      }


      this.navLinks = navLinks;
      return navLinks;
    }
  },
  beforeMount() {
    this.navigationToLink();
  }
}
</script>

<style scoped>


.sidebar {
  direction: ltr;
  max-width: 260px;
  min-width: 260px
}

.sidebar, .sidebar-content {
  background: #222e3c;
  transition: margin-left .35s ease-in-out, left .35s ease-in-out, margin-right .35s ease-in-out, right .35s ease-in-out
}

.sidebar-content {
  display: flex;
  flex-direction: column;
  height: 100vh
}


.sidebar-brand {
  color: #f8f9fa;
  display: block;
  font-size: 1.15rem;
  font-weight: 600;
  padding: 1.15rem 1.5rem;
  text-decoration: none
}

.sidebar-brand span {
  text-decoration: underline;
}

.sidebar-brand span:hover {
  color: #f8f9fa;
  text-decoration: none
}

.sidebar-brand:focus {
  outline: 0
}


.sidebar.collapsed {
  margin-left: -260px
}

@media (min-width: 1px) and (max-width: 991.98px) {
  .sidebar {
    margin-left: -260px
  }

  .sidebar.collapsed {
    margin-left: 0
  }
}

.sidebar-header {
  background: transparent;
  color: #ced4da;
  font-size: .75rem;
  padding: 1.5rem 1.5rem .375rem
}

.sidebar_logo {
  background: #FFF;
  padding: 10px;
  width: 140px;
  height: 40px;
  border-radius: 30px;
  display: flex;
  margin: 0 auto;
}

.sidebar_logo img {
  margin: 0 auto;
}

.sidebar-nav {
  background-color: #222e3c;
}
</style>