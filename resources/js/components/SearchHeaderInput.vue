<template>
    <div class="navbar-search-block">
            <div class="input-group input-group-sm">
                <input :search="search"
                       v-model="search"
                       @input="getSearchString"
                       class="form-control form-control-navbar"
                       name="search_field"
                       type="search"
                       placeholder="Найти по фамилии"
                       aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

    </div>
</template>

<script>
import eventEmitter from 'tiny-emitter/instance'
export default {
    name: "search-header-input",
    data() {
        return {
            search: ''
        }
    },
    methods: {
        getSearchString(){
            eventEmitter.$emit('getSearchString', this.search)
        }
    },
}
</script>

<style scoped>

</style>
