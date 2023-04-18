<template>
    <div v-show="agecategory_id">
        <h6>Весовая категория</h6>
        <div class="col-9">
            <select class="custom-select mb-3 text-light border-0 bg-white" name="weightcategory_id"
                    v-model="weightcategory_id" @change="getWeightCategoryId()">
                <option selected value="">Все</option>
                <option v-for="weight in weightcategories"
                    :value="weight.id"
                    :key="weight.id">
                    <span v-if="weight.gender === '1'">(м.)</span>
                    <span v-else>(ж.)</span>
                    {{weight.title}} ({{getCountAthletes(weight.id)}})
                </option>
            </select>
        </div>
    </div>
</template>

<script>
import { eventEmitter } from './../../../app'

export default {
    name: "weight-categories-select",

    data() {
        return {
            weightcategories: [],
            weightcategory_id: '',
            gender: '',
            agecategory_id: null,
            competitors: []
        }
    },
    created() {
        this.getWeightCategories()
    },
    methods: {
        getWeightCategories() {
            axios.get(`/get-weight-categories-competition`, {
                params: {
                    agecategory_id: this.agecategory_id,
                }
            })
                .then((response) => {
                    this.weightcategories = response.data
                })
        },
        getWeightCategoryId(){
            eventEmitter.$emit('getWeightCategoryId', this.weightcategory_id)
            },
        getCountAthletes(weightcategory_id) {
            const weightcategories = []
            let count = 0
            this.competitors.forEach(element => weightcategories.push(element.weightcategory))

            for (const weightcategory of weightcategories) {
                if (weightcategory.id === weightcategory_id) count++;
            }
            return count
        }
        },
    mounted() {
        eventEmitter.$on('getAgeCategoryId', age_category_id => {
            this.agecategory_id = age_category_id
            this.getWeightCategories()
        })

        eventEmitter.$on('getCompetitorsCount', competitors => {
            this.competitors = competitors
        })
    },
}
</script>

<style scoped>

</style>
