<template>
    <div>
        <h6>Возрастная категория</h6>
        <div class="col-9">
            <select class="custom-select mb-3 text-light border-0 bg-white" name="age_category_id"
                    v-model="age_category_id" @change="getAgeCategoryId()">
                <option selected>Все</option>
                <option v-for="age in age_categories"
                    :value="age.id"
                    :key="age.id">
                    {{age.title}}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
import { eventEmitter } from './../../../app'

export default {
    name: "age-categories-select",

    data() {
        return {
            age_categories: [],
            coach_id: '',
            age_category_id: ''
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
            axios.get(`/get-age-categories-competition/` + this.competition_id)
                .then((response) => {
                    this.age_categories = response.data
                    console.log(this.age_categories)
                })
        },
        getAgeCategoryId(){
            eventEmitter.$emit('getAgeCategoryId', this.age_category_id)
            },
        },
    mounted() {
        this.getAgeCategories()
    },
}
</script>

<style scoped>

</style>
