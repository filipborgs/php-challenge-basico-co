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
    loading: false,
    paginate: {
        nextPage: 1,
        lastPage: null,
        search: null,
        totalProduct: null
    }
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

        async uploadProductJson({ commit }, file) {
            commit('SET_LOADING');

            const formData = new FormData();
            formData.append("products", file);

            const request = {
                method: 'post',
                url: '/products',
                headers: {
                    "Content-Type": "multipart/form-data",
                },
                data: formData
            }

            try {
                await axios(request);
                return "Json enivado com sucesso, e está sendo processado, em instantes ele estará disponível"
            } catch (e) {
                alert(e.response.data);
            } finally {
                commit('SET_LOADING');
            }
        },

        async deleteProduct({ commit }, { id, index }) {
            commit('SET_LOADING');
            try {
                await axios.delete(`/products/${id}`);
                commit('REMOVE_PRODUCT', index);
                return 'Produto deletado com sucesso!';
            } catch (e) {
                throw e.response.data.message;
            } finally {
                commit('SET_LOADING');
            }
        },

        async getProductsPaginate({ commit, state }) {
            const next = state.paginate.nextPage;
            const last = state.paginate.lastPage;
            if (last && next > last) {
                return
            }
            commit('SET_LOADING');

            const request = {
                method: "get",
                url: "/products/paginate",
                params: {
                    page: next,
                    search: state.paginate.search
                }
            }
            try {
                const { data } = await axios(request);
                commit('SET_PAGE', data);
                commit('SET_PRODUCTS', data.data);
            } finally {
                commit('SET_LOADING');
            }
        },

        destroyStore({ state }) {
            Object.assign(state, getState());
        },

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
            console.log(products);
            if (state.paginate.nextPage == 2)
                state.products = products;
            else
                state.products.push(...products);
        },

        REMOVE_PRODUCT(state, index) {
            state.products.splice(index, 1);
        },

        SET_PAGE(state, { current_page, last_page, total }) {
            state.paginate.nextPage = current_page + 1;
            state.paginate.lastPage = last_page;
            state.paginate.totalProduct = total;
        }
    }
}

export default new Vuex.Store(store);