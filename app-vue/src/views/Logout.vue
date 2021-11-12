<template>
</template>

<script>

import {setTitle} from "../helper/utility";
import Sidebar from "../components/Sidebar";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";

export default {
  name: 'LogOut',
  components: {
    Footer,
    Navbar,
    Sidebar
  },
  data() {
    return {
    };
  },
  beforeMount() {
    this.$emit('do_logout');
  },
  props: {
    access_token: String,
    sidebar_collapsed:Boolean,
    user: Object,
    info: Object,
    is_logged: Boolean,
  },
  methods: {
  },
  setup(props, {emit}) {
    setTitle('Supporto');
  },
  emits: ['do_logout', 'do_login', 'check-authenticate','toggle_sidebar_collapse'],
}
</script>