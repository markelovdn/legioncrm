<template>
    <div>
        <h6>Возрастная категория</h6>

        <div class="col-9">
            <select class="custom-select mb-3 text-light border-0 bg-white" name="age_category_id"
                    v-model="age_category_id" @change="getAgeCategoryId()">
                <option selected value="">Все</option>
                <option v-for="age in age_categories"
                    :value="age.id"
                    :key="age.id">
                    {{age.title}} ({{getCountAthletes(age.id)}})
                </option>
            </select>
        </div>
    </div>
</template>

<script>
import eventEmitter from 'tiny-emitter/instance'

export default {
    name: "age-categories-select",

    data() {
        return {
            age_categories: [],
            age_category_id: '',
            competitors: []
        }
    },
    props: [
        'competition_id'
    ],
    created() {
        this.getAgeCategories()
    },
    methods: {
        getAgeCategories() {
            axios.get(`/get-age-categories-competition`, {
                params: {
                    competition_id: this.competition_id
                }
            })
                .then((response) => {
                    this.age_categories = response.data
                })
        },

        getAgeCategoryId(){
            eventEmitter.$emit('getAgeCategoryId', this.age_category_id)
            },

        getCountAthletes(agecategory_id) {
            const agecategories = []
            let count = 0
            this.competitors.forEach(element => agecategories.push(element.agecategory))

            for (const agecategory of agecategories) {
                if (agecategory.id === agecategory_id) count++;
            }
            return count
        }
        },
    mounted() {
        this.getAgeCategories()
        eventEmitter.on('getCompetitorsCount', competitors => {
            this.competitors = competitors
        })
    },
}
</script>

<style scoped>

</style>
