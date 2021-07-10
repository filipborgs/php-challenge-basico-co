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
    <md-divider></md-divider>
    <div class="md-layout pt-3 md-gutter" :class="`md-alignment-center-center`">
      <div class="md-layout-item md-size-35">
        <md-field md-clearable>
          <md-icon>search</md-icon>
          <label for="title">Pesquisa</label>
          <md-input
            name="title"
            id="title"
            @input="search"
            v-model="paginate.search"
          />
        </md-field>
      </div>

      <div v-if="products.length" class="md-layout-item md-size-10">
        Exibindo: {{ products.length }} de {{ paginate.totalProduct }}
      </div>
    </div>
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
          new Date(product.created_at).toLocaleDateString()
        }}</md-table-cell>
        <md-table-cell>
          <md-button
            :disabled="loading"
            class="md-icon-button md-primary"
            :to="{ name: 'product', params: { id: product.id } }"
          >
            <md-icon>edit</md-icon>
          </md-button>

          <md-button
            :disabled="loading"
            class="md-icon-button md-accent"
            @click="askDelete(index)"
          >
            <md-icon>delete</md-icon>
          </md-button></md-table-cell
        >
      </md-table-row>
    </md-table>
    <div class="md-layout pt-3 md-gutter" :class="`md-alignment-center-center`">
      <md-button :disabled="loading || isLast" @click="getProductsPaginate">
        <md-icon>arrow_downward</md-icon>
        Carregar Mais
      </md-button>
    </div>
  </div>
</template>

<script>
export default {
  async mounted() {
    this.getProductsPaginate();
  },

  data: () => ({
    active: false,
    index: null,
    timeOut: null,
  }),

  methods: {
    search() {
      console.log(this.paginate.search);
      clearTimeout(this.timeOut);
      this.timeOut = setTimeout(() => {
        this.paginate.nextPage = 1;
        this.paginate.lastPage = null;
        this.getProductsPaginate();
      }, 300);
    },

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
      this.deleteProduct({ id, index: this.index }).then(alert).catch(alert);
    },
  },

  computed: {
    getSelectedProduct() {
      return Number.isInteger(this.index)
        ? this.products[this.index].title
        : "";
    },

    isLast() {
      const page = this.paginate;
      return page.lastPage && page.nextPage > page.lastPage;
    },
  },
};
</script>
