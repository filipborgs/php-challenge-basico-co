<template>
  <div>
    <md-dialog-confirm
      :md-active.sync="active"
      md-title="Tem certeza que deseja deletar o produto?"
      :md-content="getSelectedProduct"
      md-confirm-text="Confirmar"
      md-cancel-text="Cancelar"
      @md-confirm="confirmDelete"
      @md-cancel="cancelDelete"
    />

    <md-table>
      <md-table-row>
        <md-table-head>Título</md-table-head>
        <md-table-head>Tipo</md-table-head>
        <md-table-head>Rating</md-table-head>
        <md-table-head>Preço</md-table-head>
        <md-table-head>Enviado em</md-table-head>
        <md-table-head>Ações</md-table-head>
      </md-table-row>

      <md-table-row v-for="(product, index) in products" :key="product.id">
        <md-table-cell>{{ product.title }}</md-table-cell>
        <md-table-cell>{{
          product.type ? product.type.toUpperCase() : ""
        }}</md-table-cell>
        <md-table-cell>{{ product.rating }}</md-table-cell>
        <md-table-cell>{{ product.price }}</md-table-cell>
        <md-table-cell>{{
          new Date(product.updated_at).toLocaleDateString()
        }}</md-table-cell>
        <md-table-cell>
          <md-button
            class="md-icon-button md-primary"
            :to="{ name: 'product', params: { id: product.id } }"
          >
            <md-icon>edit</md-icon>
          </md-button>

          <md-button class="md-icon-button md-accent" @click="askDelete(index)">
            <md-icon>delete</md-icon>
          </md-button></md-table-cell
        >
      </md-table-row>
    </md-table>
  </div>
</template>

<script>
export default {
  async mounted() {
    this.getProducts();
  },

  data: () => ({
    active: false,
    index: null,
  }),

  methods: {
    async askDelete(id) {
      this.index = id;
      this.active = true;
    },

    cancelDelete() {
      this.index = null;
      this.active = false;
    },

    confirmDelete() {
      const id = this.products[this.index].id;
      this.deleteProduct(id).then(alert).catch(alert);
    },
  },

  computed: {
    getSelectedProduct() {
      return Number.isInteger(this.index)
        ? this.products[this.index].title
        : "";
    },
  },
};
</script>
