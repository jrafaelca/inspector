<template>
    <div>
        <h2 class="text-center font-weight-bold mb-4">
            Inspector<span class="font-weight-lighter">.dev</span>
        </h2>

        <form @submit.prevent="handleSubmit" class="mb-4">
            <div class="form-group">
                <label for="url" class="form-label">
                    Ingrese una URL
                </label>

                <input
                    v-model="data.url"
                    id="url"
                    name="url"
                    type="text"
                    class="form-control form-control-lg"
                    :class="{'is-invalid': errors.url}"
                    placeholder="Ingresa la dirección a consultar"
                    autofocus>

                <span class="invalid-feedback" role="alert" v-if="errors.url">
                    <strong>{{ errors.url[0] }}</strong>
                </span>

                <small id="url-help" class="form-text text-muted">
                    Debe ingresar una dirección web valida ej. https://www.position.cl
                </small>
            </div>

            <div class="my-4">
                <img
                    v-if="loading"
                    src="/images/undraw_web_search_eetr.svg"
                    height="200"
                    class="mx-auto d-block">

                <img
                    v-if="searched && results.images == 0 && results.stylesheets == 0"
                    src="/images/undraw_empty_xct9.svg"
                    height="200"
                    class="mx-auto d-block">
            </div>

            <table
                v-if="searched && results.images != 0
                || searched && results.stylesheets != 0"
                class="table">
                <thead>
                <tr>
                    <th>
                        Este sitio web contiene:
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <img src="/images/bxs-image.svg" class="img-fluid">
                        {{ results.images }} Imagenes
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="/images/bxs-file-css.svg" class="img-fluid">
                        {{ results.stylesheets }} Hojas de estilo
                    </td>
                </tr>
                <tr v-if="results.style">
                    <td>
                        <img src="/images/bx-code.svg" class="img-fluid">
                        Está usando estilo en la página
                    </td>
                </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary btn-lg btn-block" :disabled="loading">
                <span v-if="!loading">Consultar</span>
                <span v-else>Cargando...</span>
            </button>
        </form>
    </div>
</template>

<script>
export default {
    name: "InspectionComponent",
    data() {
        return {
            loading: false,
            searched: false,
            data: {
                url: ''
            },
            results: {},
            errors: {}
        }
    },
    methods: {
        handleSubmit() {
            this.errors = {}
            this.results = {}
            this.loading = true
            this.searched = false

            axios.post('/api/inspections', this.data)
                .then(({data}) => {
                    this.results = data.data
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.loading = false
                    this.searched = true
                })
        }
    }
}
</script>
