<template>
  <div>
    <div class="md-layout md-gutter" :class="`md-alignment-center-center`">
      <div class="md-layout-item md-size-50">
        <form novalidate class="md-layout">
          <md-field :class="getValidationClass()">
            <label>Json de Produtos</label>
            <md-file
              @md-change="selectFile($event)"
              accept="application/json"
            />
            <span class="md-error" v-if="!$v.file.required"
              >O arquivo é obrigatório</span
            >
            <span class="md-error" v-if="!$v.file.mustBeJson"
              >O arquivo deve ser do tipo JSON</span
            >
          </md-field>
        </form>
      </div>

      <div class="md-layout-item md-size-5">
        <md-button
          class="md-primary md-raised"
          @click="validate"
          :disabled="loading"
          >
            <md-icon>upload</md-icon>
          Enviar</md-button
        >
      </div>
    </div>
  </div>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";

const mustBeJson = (val) => {
  if (val && val.type == "application/json") return true;
  return false;
};

export default {
  mixins: [validationMixin],

  data: () => ({
    file: null,
  }),

  validations: {
    file: {
      required,
      mustBeJson,
    },
  },

  methods: {
    selectFile(evt) {
      this.file = evt[0];
    },

    validate() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.uploadProductJson(this.file).then(alert).catch(alert);
      }
    },

    getValidationClass() {
      const field = this.$v.file;
      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty,
        };
      }
    },
  },
};
</script>

<style>
</style>