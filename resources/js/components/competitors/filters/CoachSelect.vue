<template>
    <div>
        <h6>Тренер</h6>
        <div class="col-9">
            <select class="custom-select mb-3 text-light border-0 bg-white" name="coach_id" v-model="coach_id" @change="onChange(), getCoachId()">
                <option selected>Все</option>
                <option v-for="coach in coaches"
                    :value="coach.id"
                    :key="coach.id">
                    {{coach.user.secondname}} {{coach.user.firstname}} {{coach.user.patronymic}}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
import { eventEmitter } from './../../../app'
export default {
    name: "coach-select",

    data() {
        return {
            coaches: [],
            coach_id: ''
        }
    },
    props: [
        'competition_id'
    ],
    created() {
        this.getCoaches()
    },
    methods: {
        getCoaches() {
            axios.get(`/get-coaches-competition/` + this.competition_id)
                .then((response) => {
                    this.coaches = response.data
                })
        },
        getCoachId(){
            eventEmitter.$emit('getCoachId', this.coach_id)
        },
        onChange() {
            this.$emit('coach_id', {
                coach_id: this.coach_id
            })
            console.log(this.coach_id)
        }
    },
    mounted() {
        this.getCoaches()
    },
}
</script>

<style scoped>

</style>
