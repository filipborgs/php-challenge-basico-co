<template>
  <md-table>
    <md-table-row>
      <md-table-head>Título</md-table-head>
      <md-table-head>Tipo</md-table-head>
      <md-table-head>Rating</md-table-head>
      <md-table-head>Preço</md-table-head>
      <md-table-head>Enviado em</md-table-head>
      <md-table-head>Ações</md-table-head>
    </md-table-row>

    <md-table-row v-for="product in products" :key="product.id">
      <md-table-cell>{{ product.title }}</md-table-cell>
      <md-table-cell>{{
        product.type ? product.type.toUpperCase() : ""
      }}</md-table-cell>
      <md-table-cell>{{ product.rating }}</md-table-cell>
      <md-table-cell>{{ product.price }}</md-table-cell>
      <md-table-cell>{{ new Date(product.updated_at).toLocaleDateString() }}</md-table-cell>
      <md-table-cell>
        <md-button
          class="md-icon-button md-primary"
          :to="{ name: 'product', params: { id: product.id } }"
        >
          <md-icon>edit</md-icon>
        </md-button>

        <md-button
          class="md-icon-button md-accent"
          @click="askDelete(product.id)"
        >
          <md-icon>delete</md-icon>
        </md-button></md-table-cell
      >
    </md-table-row>
  </md-table>
</template>

<script>
export default {
  async mounted() {
    this.getProducts();
  },

  methods: {
    async askDelete(id) {
      try {
        const mens = await this.deleteProduct(id);
        alert(mens);
      } catch (e) {
        alert(e);
      }
    },
  },
};
</script>
