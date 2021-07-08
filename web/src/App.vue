<template>
  <div id="app">
    <TopBar />
    <md-content>
      <Tabs />
      <div class="centered-container">
        <md-content class="md-elevation-3">
          <md-progress-bar md-mode="indeterminate" v-if="loading" />
          <router-view />
        </md-content>
      </div>
    </md-content>
  </div>
</template>

<script>
import Tabs from "./components/layout/Tabs.vue";
import TopBar from "./components/layout/TopBar.vue";

export default {
  name: "App",
  components: { TopBar, Tabs },
};
</script>

