import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';

Vue.use(Vuex);

const getState = () => ({
    products: [],
    product: {
        title: null,
        type: null,
        rating: null,
        description: null,
        price: null,
    },
    loading: false
})

const store = {
    state: getState(),

    actions: {
        async saveProduct({ state, commit }, id) {
            commit('SET_LOADING');
            try {
                await axios.put(`/products/${id}`, { product: state.product });
                return "Salvo com sucesso!"
            } catch (e) {
                throw e.response.data.message;
            } finally {
                commit('SET_LOADING');

            }
        },

        async getProduct({ commit }, id) {
            commit('SET_LOADING');
            try {
                const { data } = await axios.get(`/products/${id}`);
                commit('SET_PRODUCT', data);
            } catch (_) {
                throw "Produto não encontrado";
            } finally {
                commit('SET_LOADING');
            }
        },

        async getProducts({ commit }) {
            commit('SET_LOADING');
            try {
                const { data } = await axios.get("/products");
                commit('SET_PRODUCTS', data);
            } finally {
                commit('SET_LOADING');
            }
        },

        async deleteProduct({ commit }, id) {
            commit('SET_LOADING');
            try {
                await axios.delete(`/products/${id}`);
                return 'Produto deletado com sucesso!';
            } catch (e) {
                throw e.response.data.message;
            } finally {
                commit('SET_LOADING');
            }
        },

        destroyStore({ state }) {
            Object.assign(state, getState());
        }
    },

    mutations: {
        SET_PRODUCT(state, product) {
            for (const key in state.product) {
                if (product[key]) state.product[key] = product[key];
            }
        },

        SET_LOADING(state) {
            state.loading = !state.loading;
        },

        SET_PRODUCTS(state, products) {
            state.products = products;
        }
    }
}

export default new Vuex.Store(store);