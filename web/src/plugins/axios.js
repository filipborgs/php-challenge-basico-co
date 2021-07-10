import axios from "axios";
import Vue from "vue";

axios.defaults.baseURL = 'http://localhost:8000/api/v1';
axios.defaults.headers.common["key"] = "qNBC!GvgpFHJNVLmD7su";
Vue.prototype.$axios = axios;