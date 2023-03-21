<template>
    <div>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Скачать список</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
                <li><a href="#" class="dropdown-item">Все </a></li>
                <li class="dropdown-divider"></li>

                <li class="dropdown-submenu dropdown-hover">
                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Дети 10-11 лет</a>
                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                        <li>
                            <a tabindex="-1" href="#" class="dropdown-item">Группа С</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </li>
    </div>
</template>

<script>
export default {
    data() {
        return {
            routes: []
        }
    },
    props: [
        'competition_id'
    ],

    methods: {
        getRoutes() {
            axios.get(`/api/competitors-export/`+this.competition_id)
                .then((response) => {
                    this.routes = response.data
                })
        }
    },
    mounted() {
        this.getRoutes()
    }
}
</script>

<style scoped>

</style>
