<template>
    <div v-show="agecategory_id">
        <h6>Группы по технической квалификации</h6>
        <div class="col-9">
            <select class="custom-select mb-3 text-light border-0 bg-white" name="tehkvalgroup_id"
                    v-model="tehkvalgroup_id" @change="getTehKvalGroupId()">
                <option selected value="">Все</option>
                <option v-for="tehkvalgroup in tehkvalgroups"
                    :value="tehkvalgroup.id"
                    :key="tehkvalgroup.id">
                    {{tehkvalgroup.title}} ({{getCountAthletes(tehkvalgroup.id)}})
                </option>
            </select>
        </div>
    </div>
</template>

<script>
import { eventEmitter } from './../../../app'

export default {
    name: "teh-kval-group-select",

    data() {
        return {
            tehkvalgroups: [],
            tehkvalgroup_id: '',
            agecategory_id: null,
            competitors: []
        }
    },
    props: [
        'competition_id'
    ],
    created() {
        this.getTehKvalGroups()
    },
    methods: {
        getTehKvalGroups() {
            axios.get(`/get-tehkval-groups`, {
                params: {
                    competition_id: this.competition_id,
                    agecategory_id: this.agecategory_id,
                }
            })
                .then((response) => {
                    this.tehkvalgroups = response.data
                })
        },
        getTehKvalGroupId(){
            eventEmitter.$emit('getTehKvalGroupId', this.tehkvalgroup_id)
            },

        getCountAthletes(tehkvalgroup_id) {
            const tehkvalgroups = []
            let count = 0
            this.competitors.forEach(element => tehkvalgroups.push(element.tehkvalgroup))

            for (const tehkvalgroup of tehkvalgroups) {
                if (tehkvalgroup.id === tehkvalgroup_id) count++;
            }
            return count
        }
        },
    mounted() {
        eventEmitter.$on('getAgeCategoryId', age_category_id => {
            this.agecategory_id = age_category_id
            this.getTehKvalGroups()
        })

        eventEmitter.$on('getCompetitorsCount', competitors => {
            this.competitors = competitors
        })
    },
}
</script>

<style scoped>

</style>
