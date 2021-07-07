<template>
  <div>
    <ProductJsonForm />
    <md-divider></md-divider>
    <ProductsTable />
    <md-divider></md-divider>
  </div>
</template>

<script>
import ProductsTable from "@/components/product/ProductsTable.vue";
import ProductJsonForm from "../components/product/ProductJsonForm.vue";
export default {
  components: {
    ProductsTable,
    ProductJsonForm,
  },
};
</script>

<style>
</style>