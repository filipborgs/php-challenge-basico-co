<template>
  <div>
    <div class="md-layout md-gutter" :class="`md-alignment-center-center`">
      <div class="md-layout-item md-size-50">
        <md-field>
          <label>Json de Produtos</label>
          <md-file />
        </md-field>
      </div>

      <div class="md-layout-item md-size-5">
        <md-button class="md-primary md-raised">Enviar</md-button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({}),
};
</script>

<style>
</style>