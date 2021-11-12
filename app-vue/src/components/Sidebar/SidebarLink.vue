<template>
  <ul class="sidebar-nav">
    <template v-for='navLink in navLinks'>
      <li v-if="navLink?.type==='header'" class="sidebar-header"> {{ navLink?.name }}</li>
      <li v-else class="sidebar-item" :class="navLink.is_active?'active':(navLink.children.length?'sidebar-multilevel':'')">
        <template v-if="navLink.children.length">
          <a :href="'#sidebar_open_'+navLink.id" data-bs-toggle="collapse" class="sidebar-link" :class="navLink.active_cildren?'':'collapsed'">
            <i :class="navLink?.icon"></i> {{ navLink?.title }}
          </a>
          <ul :id="'sidebar_open_'+navLink.id" class="sidebar-dropdown list-unstyled collapse" :class="navLink.active_cildren?'show':''">
            <li v-for="link in navLink.children" class="sidebar-item" :class="link.is_active?'active':''">
              <router-link class="sidebar-link" :to="$router.getByName(link.link)">
                <i :class="link?.icon"></i>
                <span class="align-middle">{{ link?.title }}</span>
              </router-link>
            </li>
          </ul>
        </template>
        <template v-else>
          <router-link class="sidebar-link" :to="$router.getByName(navLink?.link)">
            <i :class="navLink?.icon"></i>
            <span class="align-middle">{{ navLink?.title }}</span>
          </router-link>
        </template>
      </li>
    </template>
  </ul>
</template>

<script>
export default {
  name: "SidebarLink",
  props: {
    navLinks: Array,
  },
}
</script>

<style scoped>

.sidebar-nav {
  flex-grow: 1;
  list-style: none;
  margin-bottom: 0;
  padding-left: 0
}

.sidebar-link, a.sidebar-link {
  background: #222e3c;
  border-left: 3px solid transparent;
  color: rgba(233, 236, 239, .5);
  cursor: pointer;
  display: block;
  font-weight: 400;
  padding: .625rem 1.625rem;
  position: relative;
  text-decoration: none;
  transition: background .1s ease-in-out
}

.sidebar-link i, .sidebar-link svg, a.sidebar-link i, a.sidebar-link svg {
  color: rgba(233, 236, 239, .5);
  margin-right: .75rem
}

.sidebar-link:focus {
  outline: 0
}

.sidebar-link:hover {
  background: #222e3c;
  border-left-color: transparent
}

.sidebar-link:hover, .sidebar-link:hover i, .sidebar-link:hover svg {
  color: rgba(233, 236, 239, .75)
}

.sidebar-item.active .sidebar-link:hover, .sidebar-item.active > .sidebar-link {
  background: linear-gradient(90deg, rgba(59, 125, 221, .1), rgba(59, 125, 221, .0875) 50%, transparent);
  border-left-color: #3b7ddd;
  color: #e9ecef
}

.sidebar-item.active .sidebar-link:hover i, .sidebar-item.active .sidebar-link:hover svg, .sidebar-item.active > .sidebar-link i, .sidebar-item.active > .sidebar-link svg {
  color: #e9ecef
}

.sidebar-brand span {
  text-decoration: underline;
}

.sidebar-brand span:hover {
  color: #f8f9fa;
  text-decoration: none
}

.sidebar-header {
  background: transparent;
  color: #ced4da;
  font-size: .75rem;
  padding: 1.5rem 1.5rem .375rem
}


.sidebar [data-bs-toggle="collapse"]::after {
  border: 0 solid;
  border-right-width: .075rem;
  border-bottom-width: .075rem;
  content: " ";
  display: inline-block;
  padding: 2px;
  position: absolute;
  right: 1.5rem;
  top: 1.2rem;
  transform: rotate(135deg);
  transition: all .2s ease-out;
}

.sidebar [aria-expanded="true"]::after, .sidebar [data-bs-toggle="collapse"]:not(.collapsed)::after {
  top: 1.4rem;
  transform: rotate(45deg);
}

.sidebar-multilevel .sidebar-dropdown .sidebar-link {
  padding-left: 35px;
}

</style>