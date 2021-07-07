<template>
  <div>
    <md-tabs md-sync-route>
      <md-tab id="tab-home" md-label="Home" :to="{ name: 'home' }" exact>
      </md-tab>

      <md-tab id="tab-pages" md-label="Produtos" :to="{ name: 'products' }">
      </md-tab>
    </md-tabs>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>