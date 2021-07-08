<template>
  <div>
    <form novalidate class="md-layout" @submit.prevent="validate">
      <md-card class="md-layout-item">
        <md-card-header>
          <div class="md-title">Produto</div>
        </md-card-header>

        <md-card-content>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('title')">
                <label for="title">Título</label>
                <md-input
                  name="title"
                  id="title"
                  v-model="product.title"
                  :disabled="loading"
                />
                <span class="md-error" v-if="!$v.product.title.required"
                  >O título é obrigatório</span
                >
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('type')">
                <label for="type">Tipo</label>
                <md-input
                  name="type"
                  id="type"
                  v-model="product.type"
                  :disabled="loading"
                />
                <span class="md-error" v-if="!$v.product.type.required"
                  >O tipo é obrigatório</span
                >
              </md-field>
            </div>
          </div>

          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field>
                <label for="rating">Rating</label>
                <md-input
                  type="number"
                  name="rating"
                  id="rating"
                  v-model="product.rating"
                  :disabled="loading"
                >
                </md-input>
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('price')">
                <label for="price">Preço</label>
                <md-input
                  name="price"
                  type="number"
                  step=".01"
                  id="price"
                  v-model="product.price"
                  :disabled="loading"
                />
                <span class="md-error" v-if="!$v.product.price.required"
                  >O Preço é obrigatório</span
                >
              </md-field>
            </div>
          </div>

          <md-field>
            <label for="description">Descrição</label>
            <md-input
              id="description"
              name="description"
              v-model="product.description"
              :disabled="loading"
            />
          </md-field>
        </md-card-content>

        <md-card-actions>
          <md-button type="submit" class="md-primary" :disabled="loading"
            >Salvar</md-button
          >
        </md-card-actions>
      </md-card>
    </form>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";

export default {
  name: "ProductForm",
  mixins: [validationMixin],

  async mounted() {
    const id = this.$route.params.id;
    try {
      await this.getProduct(id);
    } catch (e) {
      alert(e);
      this.$router.replace({ name: "products" });
    }
  },

  validations: {
    product: {
      title: {
        required,
      },
      type: {
        required,
      },
      price: {
        required,
      },
    },
  },

  methods: {
    getValidationClass(fieldName) {
      const field = this.$v.product[fieldName];

      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty,
        };
      }
    },

    validate() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.submit();
      }
    },

    async submit() {
      const id = this.$route.params.id;
      try {
        const mens = await this.saveProduct(id);
        alert(mens);
        this.$router.replace({ name: "products" });
      } catch (e) {
        alert(e);
      }
    },
  },

  beforeDestroy() {
    this.destroyStore();
  },
};
</script>

