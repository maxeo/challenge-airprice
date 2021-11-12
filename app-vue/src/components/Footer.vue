<template>
  <footer class="footer">
    <div class="container-fluid">
      <div class="row text-muted">
        <div class="col-6 text-start">
          <p class="mb-0">
            <a class="text-muted" href="https://www.maxeo.net" target="_blank"><strong>Maxeo.net</strong></a> &copy;
          </p>
        </div>
        <div class="col-6 text-end">
          <ul class="list-inline">
            <li class="list-inline-item">
              <router-link class="text-muted" :to="$router.getByName('admin-supporto')">Supporto</router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: "Footer"
}
</script>

<style scoped>

</style>