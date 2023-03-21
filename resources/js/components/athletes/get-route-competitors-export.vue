<template>
    <div>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Скачать список</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
                <li><a :href="getUrl()+'competition_id='+competition_id+'/agecategory_id=0/tehkvalgroup_id=0'" class="dropdown-item">Все </a></li>
                <li class="dropdown-divider"></li>

                <li class="dropdown-submenu dropdown-hover" v-for="route in routes">
                    <a id="dropdownSubMenu2" :href="getUrl()+'competition_id='+competition_id+
                                                             '/agecategory_id='+route.pivot.agecategory_id+
                                                             '/tehkvalgroup_id=0'"
                       role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false" class="dropdown-item dropdown-toggle">{{ route.title }}</a>
                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                        <a tabindex="-1" :href="getUrl()+'competition_id='+competition_id+
                                                             '/agecategory_id='+route.pivot.agecategory_id+
                                                             '/tehkvalgroup_id=0'"
                           class="dropdown-item">Все</a>
                        <li v-for="tehkvalgroup in route.tehkvalgroup" v-if="tehkvalgroup.competition_id === route.pivot.competition_id">
                            <a tabindex="-1" :href="getUrl()+'competition_id='+competition_id+
                                                             '/agecategory_id='+route.pivot.agecategory_id+
                                                             '/tehkvalgroup_id='+tehkvalgroup.id"
                               class="dropdown-item">{{ tehkvalgroup.title }}</a>
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
        'competition_id',
        'url'
    ],

    methods: {
        getRoutes() {
            axios.get(`/api/competitors-export/`+this.competition_id)
                .then((response) => {
                    console.log(response.data)
                    this.routes = response.data
                })
        },

        getUrl() {
            return this.url.slice(0, 38)
        }
    },
    mounted() {
        this.getRoutes()
    }
}
</script>

<style scoped>

</style>
